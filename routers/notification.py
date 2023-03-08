from fastapi import APIRouter, Header, Depends, BackgroundTasks
from fastapi.encoders import jsonable_encoder

from datetime import datetime

from routers import ContextIncludedRoute
from routers.payment import payment_checkout
from utils.sqlpool import Mysql
from responses.BaseResponse import *
from helper.EmailHelper import *
from helper.IfgHelper import IFGHelper
from helper.SmsHelper import SmsHelper
from dto.notif import *
from dto.doku import *
from repository.PermintaanRepo import *
from routers.payment import payment_checkout_doku
from const.appcfg import *
import os
import sys


router = APIRouter(route_class=ContextIncludedRoute)


@router.post('/email')
def email(req: EmailNotif, background_task: BackgroundTasks, tk=Depends(IFGHelper().get_token)):
    mysql = Mysql()
    fp = PermintaanRepo(mysql)
    link = None
    try:
        # get agent data
        head = {
            'Authorization': 'token ' + tk
        }
        row = fp.get_spaj(req.nospaj)
        data = json.loads(row['data_spaj'])
        print(data)
        print("====================================")
        print(data['applicationList'])
        ag = data['applicationList'][0]['agenPenutup']
        agentno = ag['noAgen']
        formurl = LINK_CLOSING_STATEMENT_AGENT.format(row['id'])
        emailagent = ag['emailAgen']
        #emailagent = 'mifg.ujicoba@gmail.com'
        # emailagent = 'anggiayunda@gmail.com'
        # generate checkout page
        al = data['applicationList'][0]
        pl = al['pemegangPolis']
        trt = al['tertanggung']
        pyp = al['pembayaranPremi']
        da = al['dataAsuransi']
        tambahan = json.loads(row['premi_tambahan'])
        additionalpremi = __gen_pertanggungan_tambahan(tambahan)
        param = {
            "invoice_no": al['nomorSPAJ'],
            "total_amount": str(row['jumlah_bayar_premi']),
            "payment": {"payment_due_date": 4320},
            "customer": {
                "custid": al['nomorSPAJ'],
                "name": pl['namaLengkap'],
                "email": pl['email'],
                "phone": pl['handphone'],
                "address": pl['alamatSesuaiIdentitas']['alamat']
                },
            "line_items": [],
            "paytype": "",
            "payvendor": "Doku",
            "bank": ""
            }

        prm = Checkout(**param)
        res = payment_checkout_doku(prm)

        plan = 'Platinum' if da['plan'] == 'P' else 'Gold'
        almt = pl['alamatSesuaiIdentitas']
        link = res['endpoint']
        name = dict(pemegangPolis=pl['namaLengkap'], tertanggung=trt['namaLengkap'])
        premi = dict(periodeBayarPremi=pyp['sumberDana']['caraBayarPremi'], plan=plan)
        address = dict(alamat=almt['alamat'], kota=almt['kota'], kodePos=almt['kodePos'])
        emailcn = pl['email']
        expired_date = datetime.strftime(datetime.strptime(res['expired_date'], '%Y-%m-%d %H:%M:%S'),
                                         '%d/%m/%Y Jam %H:%M')

        # email notif ke agent
        email = EmailHelper()
        smsh = SmsHelper()
        print("NAMA--> ", name)
        print("address--> ", address)
        background_task.add_task(email.email_agent, agentno=agentno, link=formurl, emailto=emailagent,
                                 nospaj=req.nospaj, head=head)
        background_task.add_task(email.email_payment_notif, name=name, address=address, premi=premi,
                                 nospaj=req.nospaj, emailto=emailcn, link=link, additionalpremi=additionalpremi, head=head)
        background_task.add_task(smsh.notif_new_client, name=name['pemegangPolis'], amount=f"{row['jumlah_bayar_premi']:,}",
                                 dttime=expired_date, msisdn=pl['handphone'])



    except Exception as e:
        print(str(e))
        exc_type, exc_obj, exc_tb = sys.exc_info()
        fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
        print(exc_type, fname, exc_tb.tb_lineno)
    mysql.dispose()
    mysql.closing()

    return dict(doku=link)


def __gen_pertanggungan_tambahan(tambahandict):
    d = [tambahandict['remark_kematian'], tambahandict['remark_inap'], tambahandict['remark_extra'],
         tambahandict['remark_extra_inap']]
    return ', '.join([x for x in d if x != ''])


@router.post('/email_reject')
def email_reject(req: EmailNotif, background_task: BackgroundTasks, tk=Depends(IFGHelper().get_token)):
    mysql = Mysql()
    fp = PermintaanRepo(mysql)
    link = None
    try:
        # get agent data
        head = {
            'Authorization': 'token ' + tk
        }
        row = fp.get_spaj(req.nospaj)
        data = json.loads(row['data_spaj'])
        print(data)
        print("====================================")
        print(data['applicationList'])
        ag = data['applicationList'][0]['agenPenutup']
        agentno = ag['noAgen']
        emailagent = ag['emailAgen']
        #emailagent = 'mifg.ujicoba@gmail.com'
        # emailagent = 'anggiayunda@gmail.com'
        # generate checkout page
        al = data['applicationList'][0]
        pl = al['pemegangPolis']

        # email notif ke agent
        email = EmailHelper()
        smsh = SmsHelper()
        background_task.add_task(email.email_reject, agentno=agentno, cppname=pl['namaLengkap'], emailto=emailagent,
                                 nospaj=req.nospaj, head=head)

    except Exception as e:
        print(str(e))
        exc_type, exc_obj, exc_tb = sys.exc_info()
        fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
        print(exc_type, fname, exc_tb.tb_lineno)
    mysql.dispose()
    mysql.closing()

    return dict(doku=link)