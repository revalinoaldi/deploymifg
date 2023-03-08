from dto.mi import PaymentConfirmation
from const.appcfg import *
from utils.tredis import Tredis
from utils.misc import *
from utils.sqlpool import Mysql
from repository.PermintaanRepo import PermintaanRepo
from helper.EmailHelper import *
from routers.mi import *
from datetime import datetime, timedelta

import hmac
import json
import requests
import os
import sys

FILE_HOST = '/var/www/html/ifg-life/frontend/web/uploads/'

class IFGHelper(object):

    def get_token(self):
        memkey = 'ifg-token'
        rd = Tredis()
        tk = None
        try:
            # tk = rd.get_cache(memkey)
            if not tk:
                r = requests.post(IFG_TOKEN_URL, json=dict(user=IFG_USERID, secreet_key=IFG_SECRETKEY))
                print("FROM GEN  TOKEN--->", r.text )
                if r.status_code == 200:
                    tk = r.json()['token']
                    rd.set_cache(memkey, tk, 3600)
                else:
                    tk = None
                pass
        except Exception as e:
            print(e)

        return tk

    def __get_peserta(self, nospa):
        res = None
        try:
            tk = self.get_token()
            head = {'Authorization': tk}
            r = requests.post(IFG_PESERTA_URL, json=dict(NO_SPA=nospa), headers=head)
            if r.status_code == 200:
                res = r.json()
            else:
                res = None
            pass
        except Exception as e:
            print(e)

        return res

    def __update_polis(self, nospa, tk, nopolis, mysql):
        res = False
        try:
            pass
        except Exception as e:
            print(e)

        return res

    def __add_mutasi(self, nospa, tk, nopolis):
        res = False
        try:
            head = {'Authorization': tk}
            psr = self.__get_peserta(nospa)
            if psr is None:
                return False
            # update polis
            pls = psr.get('polis')
            org = psr.get('orang')
            ben = psr.get('benefit')
            parampolis = dict(
                NO=1,
                ID_ORANG=org['ID_ORANG'],
                NO_SPA=nospa,
                NO_PESERTA=nopolis,
                KD_STATUS_AWAL=1,
                KD_STATUS_AKHIR=1,
                KD_JENIS_MUTASI=1,
                KD_PLAN=ben['KD_PLAN'],
                TGL_AWAL=pls['TGL_MULAI_POLIS'],
                TGL_AKHIR=pls['TGL_AKHIR_POLIS'],
                KETERANGAN=org['KETERANGAN'],
                TGL_REKAM=pls['TGL_REKAM'],
                USER_REKAM=pls['USER_REKAM']
            )
            rpls = requests.post(IFG_ADD_MUTASI_URL, json=parampolis, headers=head)

            if rpls.status_code == 200:
                res = rpls.json()
            else:
                res = rpls.text
            pass
        except Exception as e:
            print(e)

        return res

    def process_ifg(self, nospa, trxdate, amount):
        tk = None
        urlmi = 'https://10.170.64.32:8000/mi/payment_confirmation'
        plarr = []
        try:
            mysql = Mysql()
            pr = PermintaanRepo(mysql)

            tk = self.get_token()
            trxdate = str(datetime.strptime(trxdate, '%Y-%m-%d %H:%M:%S') + timedelta(hours=7))
            pl = dict(nomorSPAJ=nospa, tanggalBayarPremi=trxdate, jumlahBayarPremi=amount)
            plarr.append(pl)
            prm = PaymentConfirmation(**dict(paymentList=plarr))
            r = self.__payment_confirmation(prm)
            print("RESPONSE MI PAYMENT CONFIRM----> ", r)
            resplist = r['resp']['data']['resultList']
            for i in resplist:
                dictset = dict(no_polis=i['nomorPolis'], paid_status='1')
                dictwhere = dict(no_spaj=nospa)
                pr.update_polis(dictset, dictwhere)
            mysql.dispose()
            mysql.closing()
        except Exception as e:
            print(e)
            msg = str(e)
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            print(exc_type, fname, exc_tb.tb_lineno)

        return tk

    def __payment_confirmation(self, req: PaymentConfirmation):
        msg = "success"
        r = []
        try:
            r = auth_login()
            r = json.loads(r)

            # print("====================== AUTH =============================", r)

            req = jsonable_encoder(req)
            # return req
            payload = req

            headers = {"Content-Type": "application/json", "AccessToken": r['data']['accessToken'],
                       'clientId': CLIENT_ID, 'secretKey': SECRET_KEY}
            r = requests.post(BASE_URL + 'ifg_life/payment_confirmation', json=payload, headers=headers)
            r = r.text
            print("======================= HEADER PAY CONFIRMATION ============================", headers)
            print("===================================================", r)
            # r = '{"data": { "transactionNumber": "726cebc5-6910-49ba-b0dd-ffad1f429bcc", "policyTotal": 3, "resultList": [ { "nomorKartuInhealth": "1501621496272", "namaLengkap": "OPIN PASRULI", "jenisKelamin": "L", "PISA": "P", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1511621496273", "namaLengkap": "OPI", "jenisKelamin": "P", "PISA": "I", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1541621496277", "namaLengkap": "RAYA", "jenisKelamin": "P", "PISA": "A", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" } ] }, "resultCode": "1000", "resultMessage": "Success"}'
            r = json.loads(r)
        except Exception as e:
            print("Error MI :", str(e))
            msg = str(e)

        return dict(resp=r, req=req, msg=msg)

    def __upload_spaj(self, req, files):
        msg = "success"
        r = []
        try:
            r = auth_login()
            r = json.loads(r)

            # print("====================== AUTH =============================", r)

            # req = jsonable_encoder(req)
            # return req
            payload = req
            # "Content-Type": "multipart/form-data",
            headers = {
                       "AccessToken": r['data']['accessToken'],
                       'clientId': CLIENT_ID,
                       'secretKey': SECRET_KEY}
            print("======================= HEADER UPLOAD ============================", headers)
            print("======================= PAYLOAD UPLOAD ============================", payload)
            print("======================= PAYLOAD FILES ============================", files)
            # r = requests.post(BASE_URL + 'ifg_life/file_document', data=payload, headers=headers, files=files)
            r = requests.request("POST", BASE_URL + 'ifg_life/file_document', headers=headers, data=payload, files=files)
            r = r.text

            print("==============UPLOAD FILES=============================", r)
            # r = '{"data": { "transactionNumber": "726cebc5-6910-49ba-b0dd-ffad1f429bcc", "policyTotal": 3, "resultList": [ { "nomorKartuInhealth": "1501621496272", "namaLengkap": "OPIN PASRULI", "jenisKelamin": "L", "PISA": "P", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1511621496273", "namaLengkap": "OPI", "jenisKelamin": "P", "PISA": "I", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1541621496277", "namaLengkap": "RAYA", "jenisKelamin": "P", "PISA": "A", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" } ] }, "resultCode": "1000", "resultMessage": "Success"}'
            r = json.loads(r)
        except Exception as e:
            print("Error MI :", str(e))
            msg = str(e)
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            print(exc_type, fname, exc_tb.tb_lineno)

        return dict(resp=r, req=req, msg=msg)