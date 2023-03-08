import importlib
import requests
import json
import os
import sys

from fastapi import APIRouter, Header, BackgroundTasks
from fastapi.encoders import jsonable_encoder

from datetime import datetime
from utils.sqlpool import Mysql
from repository.PermintaanRepo import PermintaanRepo
from routers import ContextIncludedRoute
from responses.BaseResponse import *
from helper.DokuHelper import DokuHelper
from helper.IfgHelper import IFGHelper
from helper.SmsHelper import SmsHelper
from helper.EmailHelper import *
from dto.doku import *
from const.appcfg import *

router = APIRouter(route_class=ContextIncludedRoute)


#is_prod = False
is_prod = True
if is_prod:
    url_checkout = URLCHECKOUTPROD
    client_id = DOKU_CLIENT_ID_PROD
    secret_key = DOKU_SECRET_KEY_PROD
else:
    url_checkout = URLCHECKOUTDEV
    client_id = DOKU_CLIENT_ID_SANDBOX
    secret_key = DOKU_SECRET_KEY_SANDBOX


@router.post('/payment_checkout')
def payment_checkout(data: Checkout):
    totamount = int(data.total_amount) + ADMFEE
    order = dict(
        amount=totamount,
        invoice_number=data.invoice_no,
        # line_items=data.line_items,
        currency=CURRENCY,
        callback_url=CALLBACK
    )
    payment = dict(
        payment_due_date=EXPIRY,
        payment_method_types=PAYMENT_METHOD
    )
    customer = dict(
        id=data.customer.custid,
        name=data.customer.name,
        email=data.customer.email,
        phone=data.customer.phone,
        address=data.customer.address,
        country=COUNTRY
    )
    args = dict(order=order, payment=payment, customer=customer)

    hlp = DokuHelper()
    digest = hlp.genDigest(json.dumps(args))
    reqid, reqtimestamp = hlp.reqid_timestamp()
    sign = hlp.genSignature(reqid, reqtimestamp, TARGETCHECKOUT, digest, client_id, secret_key)

    head = {
        "Client-Id": client_id,
        "Request-Id": reqid,
        "Request-Timestamp": reqtimestamp,
        "Signature": sign
    }
    print("URL CHECKOUT------> ", url_checkout)
    print("CLIENT_ID----> ", client_id)
    print("SECRET_KEY---> ", secret_key)
    print("ARGSS-----> ", json.dumps(args))
    print('REACTIVATE HEADER----->: ', head)

    resp = requests.post(url_checkout, json=args, headers=head)
    print("RESPONSE--------------------------------")
    print(resp.text)
    if resp.status_code == 200:
        res = resp.json()['response']
        rc = '00'
        msg = resp.json()['message'][0]
        inv_no = res['order']['invoice_number']
        expired_date = datetime.strftime(datetime.strptime(res['payment']['expired_date'], '%Y%m%d%H%M%S'),
                                         '%Y-%m-%d %H:%M:%S')
        # items = res['order']['line_items']
        paymentpage = res['payment']['url']

        log = res
    else:
        res = resp.json()
        rc = '01'
        inv_no, items, expired_date, paymentpage = '', '', '', ''
        try:
            msg = res['error']['message']
        except:
            msg = res['message']

        log = res

    resp1 = dict(status=rc, msg=msg, inv_no=inv_no, expired_date=expired_date, endpoint=paymentpage,
                 log=log)

    return jsonable_encoder(resp1)


def payment_checkout_doku(data: Checkout):
    totamount = int(data.total_amount) + ADMFEE
    order = dict(
        amount=totamount,
        invoice_number=data.invoice_no,
        # line_items=data.line_items,
        currency=CURRENCY,
        callback_url=CALLBACK
    )
    payment = dict(
        payment_due_date=EXPIRY,
        payment_method_types=PAYMENT_METHOD
    )
    customer = dict(
        id=data.customer.custid,
        name=data.customer.name,
        email=data.customer.email,
        phone=data.customer.phone,
        address=data.customer.address,
        country=COUNTRY
    )
    args = dict(order=order, payment=payment, customer=customer)

    hlp = DokuHelper()
    digest = hlp.genDigest(json.dumps(args))
    reqid, reqtimestamp = hlp.reqid_timestamp()
    sign = hlp.genSignature(reqid, reqtimestamp, TARGETCHECKOUT, digest, client_id, secret_key)

    head = {
        "Client-Id": client_id,
        "Request-Id": reqid,
        "Request-Timestamp": reqtimestamp,
        "Signature": sign
    }
    print("URL CHECKOUT------> ", url_checkout)
    print("CLIENT_ID----> ", client_id)
    print("SECRET_KEY---> ", secret_key)
    print("ARGSS-----> ", json.dumps(args))
    print('REACTIVATE HEADER----->: ', head)

    resp = requests.post(url_checkout, json=args, headers=head)
    print("RESPONSE--------------------------------")
    print(resp.text)
    if resp.status_code == 200:
        res = resp.json()['response']
        rc = '00'
        msg = resp.json()['message'][0]
        inv_no = res['order']['invoice_number']
        expired_date = datetime.strftime(datetime.strptime(res['payment']['expired_date'], '%Y%m%d%H%M%S'),
                                         '%Y-%m-%d %H:%M:%S')
        # items = res['order']['line_items']
        paymentpage = res['payment']['url']

        log = res
    else:
        res = resp.json()
        rc = '01'
        inv_no, items, expired_date, paymentpage = '', '', '', ''
        try:
            msg = res['error']['message']
        except:
            msg = res['message']

        log = res

    resp1 = dict(status=rc, msg=msg, inv_no=inv_no, expired_date=expired_date, endpoint=paymentpage,
                 log=log)

    return resp1



@router.post('/notif_va')
def notif_va(notif: NotifVa, background_task: BackgroundTasks, Client_Id: str = Header(None), Request_Id: str = Header(None),
          Request_Timestamp: str = Header(None), Signature: str = Header(None)):
    try:
        reqid = notif.transaction.original_request_id
        trxdate = notif.transaction.date
        trxstatus = notif.transaction.status
        vano = notif.virtual_account_info.virtual_account_number
        nospa = notif.order.invoice_number
        print(reqid)
        print(trxdate)
        print(trxstatus)
        print(vano)
    except Exception as e:
        print(str(e))
        exc_type, exc_obj, exc_tb = sys.exc_info()
        fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
        print(exc_type, fname, exc_tb.tb_lineno)
        rc = 0
        msg = 'failed populate data'
        return basic_response(rc, msg)
    #
    # # check if date format is correct
    try:
        tdate = datetime.strptime(trxdate, '%Y-%m-%dT%H:%M:%SZ')
    except Exception as e:
        print(str(e))
        rc = 0
        msg = 'failed date format'
        return basic_response(rc, msg)

    # check if signature is valid
    try:
        jsondata = json.dumps(notif.dict())
        hlp = DokuHelper()
        dig = hlp.genDigest(jsondata)
        # validsign = hlp.validateSignature(Request_Id, Request_Timestamp, REQTARGETNOTIFVA, dig, Signature,
        #                                   Client_Id, secret_key)
    except Exception as e:
        print(str(e))
        rc = 0
        msg = 'auth failed'
        return basic_response(rc, msg)

    if Client_Id != client_id:
        rc = 0
        msg = 'invalid signature'
        return basic_response(rc, msg)

    # start eksekusi

    mth = datetime.strftime(tdate, '%m')
    trxdate = datetime.strftime(tdate, '%Y-%m-%d %H:%M:%S')

    # main process
    mysql = Mysql()
    try:
        fp = PermintaanRepo(mysql)
        row = fp.get_spaj(nospa)
        data = json.loads(row['data_spaj'])
        ag = data['applicationList'][0]['agenPenutup']
        al = data['applicationList'][0]
        pl = al['pemegangPolis']
        trt = al['tertanggung']
        pyp = al['pembayaranPremi']
        da = al['dataAsuransi']

        amount = '{:,}'.format(int(row['jumlah_bayar_premi']))
        name = pl['namaLengkap']
        emailto = pl['email']
        agentno = ag['noAgen']
        emailagent = ag['emailAgen']
        #emailagent = 'revalinoaldi@gmail.com'
        bank = notif.acquirer.id
        trxdate = notif.transaction.date.replace('T', ' ').replace('Z', '')
        ifgh = IFGHelper()
        tk = ifgh.process_ifg(nospa, trxdate, amount)
        head = {
            'Authorization': 'token ' + tk
        }
        dttime = datetime.now().strftime('%d/%m/%Y Jam %H:%M')
        email = EmailHelper()
        smsh = SmsHelper()
        background_task.add_task(email.email_payment_confirm, name=name, amount=amount, bank=bank, emailto=emailto,
                                 head=head)
        background_task.add_task(email.email_pelunasan_agent, agentno=agentno, cppname=name, emailto=emailagent,
                                 nospaj=nospa,
                                 amt=f"{row['jumlah_bayar_premi']:,}", head=head)
        background_task.add_task(smsh.notif_payment, name=name, amount=f"{row['jumlah_bayar_premi']:,}", nospaj=nospa,
                                 dttime=dttime, msisdn=pl['handphone'])
    except Exception as e:
        print(e)
        exc_type, exc_obj, exc_tb = sys.exc_info()
        fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
        print(exc_type, fname, exc_tb.tb_lineno)
    mysql.dispose()
    mysql.closing()



@router.post('/notif_cc')
def notif_cc(notif: NotifCc, background_task: BackgroundTasks, Client_Id: str = Header(None), Request_Id: str = Header(None),
          Request_Timestamp: str = Header(None), Signature: str = Header(None)):
    try:
        reqid = notif.transaction.original_request_id
        trxdate = notif.transaction.date
        trxstatus = notif.transaction.status
        nospa = notif.order.invoice_number
        print(reqid)
        print(trxdate)
        print(trxstatus)
    except Exception as e:
        print(str(e))
        exc_type, exc_obj, exc_tb = sys.exc_info()
        fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
        print(exc_type, fname, exc_tb.tb_lineno)
        rc = 0
        msg = 'failed populate data'
        return basic_response(rc, msg)
    #
    # # check if date format is correct
    try:
        tdate = datetime.strptime(trxdate, '%Y-%m-%dT%H:%M:%SZ')
    except Exception as e:
        print(str(e))
        rc = 0
        msg = 'failed date format'
        return basic_response(rc, msg)

    # check if signature is valid
    try:
        jsondata = json.dumps(notif.dict())
        hlp = DokuHelper()
        dig = hlp.genDigest(jsondata)
        validsign = hlp.validateSignature(Request_Id, Request_Timestamp, REQTARGETNOTIFCC, dig, Signature,
                                          Client_Id, secret_key)
    except Exception as e:
        print(str(e))
        rc = 0
        msg = 'auth failed'
        return basic_response(rc, msg)

    if Client_Id != client_id:
        rc = 0
        msg = 'invalid signature'
        return basic_response(rc, msg)

    # start eksekusi

    mth = datetime.strftime(tdate, '%m')
    trxdate = datetime.strftime(tdate, '%Y-%m-%d %H:%M:%S')

    # main process
    mysql = Mysql()
    fp = PermintaanRepo(mysql)
    row = fp.get_spaj(nospa)
    data = json.loads(row['data_spaj'])
    ag = data['applicationList'][0]['agenPenutup']
    al = data['applicationList'][0]
    pl = al['pemegangPolis']
    trt = al['tertanggung']
    pyp = al['pembayaranPremi']
    da = al['dataAsuransi']
    amount = '{:,}'.format(int(row['jumlah_bayar_premi']))
    name = pl['namaLengkap']
    emailto = pl['email']
    agentno = ag['noAgen']
    emailagent = ag['emailAgen']
    #emailagent = 'revalinoaldi@gmail.com'
    bank = notif.acquirer.id
    trxdate = notif.transaction.date.replace('T', ' ').replace('Z', '')
    ifgh = IFGHelper()
    tk = ifgh.process_ifg(nospa, trxdate, amount)
    head = {
        'Authorization': 'token ' + tk
    }
    dttime = datetime.now().strftime('%d/%m/%Y Jam %H:%M')
    email = EmailHelper()
    smsh = SmsHelper()
    background_task.add_task(email.email_payment_confirm, name=name, amount=amount, bank=bank, emailto=emailto,
                             head=head)
    background_task.add_task(email.email_pelunasan_agent, agentno=agentno, cppname=name, emailto=emailagent, nospaj=nospa,
                             amt=f"{row['jumlah_bayar_premi']:,}",head=head)
    background_task.add_task(smsh.notif_payment, name=name, amount=f"{row['jumlah_bayar_premi']:,}", nospaj=nospa,
                             dttime=dttime, msisdn=pl['handphone'])

@router.post('/req_payment')
def req_payment(data: ReqPayment):
    dl = importlib.import_module('vendors.{}.{}'.format(data.payvendor, data.paytype))
    b = dl.Payment(data)
    b.request_payment()
    # return b.product_detail_response()
