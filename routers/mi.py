import importlib
import json
import os
import sys

from fastapi import APIRouter, Header
from routers import ContextIncludedRoute
import requests
from const.mi import *
from dto.mi import *
from typing import Callable, List
from utils.tredis import Tredis
from fastapi.encoders import jsonable_encoder

router = APIRouter(route_class=ContextIncludedRoute)
redis_conn = Tredis()


def auth_login():
    get_auth = redis_conn.get_cache('mi_auth')
    if get_auth is None:
        payload = dict(clientId=CLIENT_ID, password=CLIENT_PASSWORD)
        headers = {"Content-Type": "application/json"}
        r = requests.post(BASE_URL+'authentication/login', json=payload, headers=headers)
        r = r.text
        redis_conn.set_cache('mi_auth', content=r, ttl_seconds=(60 * 90))
    else:
        r = get_auth
    #r = '{"data": { "clientId": "indonesia_financial_group", "clientName": "INDONESIA FINANCIAL GROUP (IFG)", "secretKey": null, "isActive": true, "accessToken": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6ImluZG9uZXNpYV9maW5hbmNpYWxfZ3JvdXAiLCJuYmYiOjE2Mjc3NTU1NDYsImV4cCI6MTYyNzc2Mjc0NiwiaWF0IjoxNjI3NzU1NTQ2LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2luZGl2aWR1YWxpbnN1cmFuY2UiLCJhdWQiOiJodHRwOi8vbG9jYWxob3N0L2luZGl2aWR1YWxpbnN1cmFuY2UifQ.kftudYveq7-wTdKSkZ2yc_on_bm2hOsZmsLUImAFG8Q", "expiresTokenIn": "2021-08-01 03:19:06" }, "resultCode": "1000", "resultMessage": "Success"}'
    return r

@router.post('/individual_insurance')
def individual_insurance(req: IndividualInsurance):
    msg = "success"
    r=[]
    try:
        r = auth_login()
        r = json.loads(r)

        #print("====================== AUTH =============================", r)

        req = jsonable_encoder(req)
        #return req
        payload = dict(applicationList=req['applicationList'])

        headers = {"Content-Type": "application/json",
                   "AccessToken": r['data']['accessToken'],
                   'clientId': CLIENT_ID,
                   'secretKey': SECRET_KEY}
        r = requests.post(BASE_URL+'ifg_life/policy_application', json=payload, headers=headers)
        r = r.text
        print("======================= HEADER ============================", headers)
        print("===================================================", r)
        # r = '{"data": { "transactionNumber": "726cebc5-6910-49ba-b0dd-ffad1f429bcc", "policyTotal": 3, "resultList": [ { "nomorKartuInhealth": "1501621496272", "namaLengkap": "OPIN PASRULI", "jenisKelamin": "L", "PISA": "P", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1511621496273", "namaLengkap": "OPI", "jenisKelamin": "P", "PISA": "I", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1541621496277", "namaLengkap": "RAYA", "jenisKelamin": "P", "PISA": "A", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" } ] }, "resultCode": "1000", "resultMessage": "Success"}'
        r = json.loads(r)
    except Exception as e:
        print("Error MI :", str(e))
        msg = str(e)

    return dict(resp=r, req=req, msg=msg)

# @router.post('/individual_insurance_cancel')
def individual_insurance_cancel(req: IndividualInsuranceCancel):
    r = auth_login()
    r = json.loads(r)

    payload = dict(cancellationList=req.cancellationList)
    headers = {"Content-Type": "application/json", "AccessToken": r['data']['accessToken'], 'clientId': CLIENT_ID, 'secretKey': r['data']['secretKey']}
    # r = requests.post(BASE_URL+'', json=payload, headers=headers)
    # r = r.text
    # r = '{"data": { "transactionNumber": "e8725b8e-355c-4af6-a485-74b9dc5c0da3", "policyTotal": 1, "resultList": [ { "nomorKartuInhealth": "1501621496272", "tanggalEfektif": "2021-08-01", "resultCode": "1000", "resultMessage": "Success" } ] }, "resultCode": "1000", "resultMessage": "Success"}'
    r = json.loads(r)
    return dict(req=req, resp=r)

@router.post('/payment_confirmation')
def payment_confirmation(req: PaymentConfirmation):
    msg = "success"
    r=[]
    try:
        r = auth_login()
        r = json.loads(r)

        #print("====================== AUTH =============================", r)

        req = jsonable_encoder(req)
        #return req
        payload = req


        headers = {"Content-Type": "application/json", "AccessToken": r['data']['accessToken'], 'clientId': CLIENT_ID, 'secretKey': SECRET_KEY}
        r = requests.post(BASE_URL+'ifg_life/payment_confirmation', json=payload, headers=headers)
        r = r.text
        print("======================= HEADER PAY CONFIRMATION ============================", headers)
        print("===================================================", r)
        # r = '{"data": { "transactionNumber": "726cebc5-6910-49ba-b0dd-ffad1f429bcc", "policyTotal": 3, "resultList": [ { "nomorKartuInhealth": "1501621496272", "namaLengkap": "OPIN PASRULI", "jenisKelamin": "L", "PISA": "P", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1511621496273", "namaLengkap": "OPI", "jenisKelamin": "P", "PISA": "I", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1541621496277", "namaLengkap": "RAYA", "jenisKelamin": "P", "PISA": "A", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" } ] }, "resultCode": "1000", "resultMessage": "Success"}'
        r = json.loads(r)
    except Exception as e:
        print("Error MI :", str(e))
        msg = str(e)

    return dict(resp=r, req=req, msg=msg)


@router.post('/upload_spaj')
def upload_spaj(req: UploadFileSPAJ):
    msg = "success"
    r=[]
    FILE_HOST = '/var/www/html/ifg-life/frontend/web/uploads/'
    try:
        r = auth_login()
        r = json.loads(r)

        #print("====================== AUTH =============================", r)

        # req = jsonable_encoder(req)
        ktp = ('fileKTPPemegangPolis', (req.fileKTPPemegangPolis, open('{}{}'.format(FILE_HOST, req.fileKTPPemegangPolis), 'rb')))
        kk = ('fileKKPemegangPolis', (req.fileKKPemegangPolis, open('{}{}'.format(FILE_HOST, req.fileKKPemegangPolis), 'rb')))
        ktptertanggung = ('fileKTPTertanggung', (req.fileKTPTertanggung, open('{}{}'.format(FILE_HOST, req.fileKTPTertanggung), 'rb')))
        kktertanggung = ('fileKKTertanggung', (req.fileKKTertanggung, open('{}{}'.format(FILE_HOST, req.fileKKTertanggung), 'rb')))
        espaj = ('fileSPAJ', (req.nomorSPAJ + '.pdf', open('{}{}{}'.format(FILE_HOST, req.nomorSPAJ, '.pdf'), 'rb')))
        files = list()
        files = [ktp, kk, ktptertanggung, kktertanggung, espaj]
        payload = dict(nomorSPAJ=req.nomorSPAJ, fileSPAJ=espaj, fileKTPPemegangPolis=ktp,
                       fileKKPemegangPolis=kk, fileKTPTertanggung=ktptertanggung, fileKKTertanggung=kktertanggung)

        headers = {"AccessToken": r['data']['accessToken'],
                   'clientId': CLIENT_ID,
                   'secretKey': SECRET_KEY}

        print("======================= HEADER UPLOAD ============================", headers)
        print("======================= PAYLOAD UPLOAD ============================", payload)
        print("======================= PAYLOAD FILES ============================", files)
        r = requests.request("POST", BASE_URL + 'ifg_life/policy_application_document', headers=headers, data=payload, files=files)
        r = r.text
        print("======================= HEADER ============================", headers)
        print("===================================================", r)
        # r = '{"data": { "transactionNumber": "726cebc5-6910-49ba-b0dd-ffad1f429bcc", "policyTotal": 3, "resultList": [ { "nomorKartuInhealth": "1501621496272", "namaLengkap": "OPIN PASRULI", "jenisKelamin": "L", "PISA": "P", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1511621496273", "namaLengkap": "OPI", "jenisKelamin": "P", "PISA": "I", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1541621496277", "namaLengkap": "RAYA", "jenisKelamin": "P", "PISA": "A", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" } ] }, "resultCode": "1000", "resultMessage": "Success"}'
        r = json.loads(r)
    except Exception as e:
        print("Error MI UPLOAD SPAJ:", str(e))
        print("UPLOAD SPAJ PARAM REQ", jsonable_encoder(req))
        msg = str(e)
        exc_type, exc_obj, exc_tb = sys.exc_info()
        fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
        print(exc_type, fname, exc_tb.tb_lineno)

    return dict(resp=r, req=req, msg=msg)


@router.post('/closing_agent')
def closing_agent(req: ClosingAgent):
    msg = "success"
    r=[]
    try:
        r = auth_login()
        r = json.loads(r)

        #print("====================== AUTH =============================", r)

        req = jsonable_encoder(req)
        #return req
        payload = req


        headers = {"Content-Type": "application/json", "AccessToken": r['data']['accessToken'], 'clientId': CLIENT_ID, 'secretKey': SECRET_KEY}
        r = requests.post(BASE_URL+'ifg_life/closing_agent', json=payload, headers=headers)
        r = r.text
        print("======================= HEADER PAY CONFIRMATION ============================", headers)
        print("===================================================", r)
        # r = '{"data": { "transactionNumber": "726cebc5-6910-49ba-b0dd-ffad1f429bcc", "policyTotal": 3, "resultList": [ { "nomorKartuInhealth": "1501621496272", "namaLengkap": "OPIN PASRULI", "jenisKelamin": "L", "PISA": "P", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1511621496273", "namaLengkap": "OPI", "jenisKelamin": "P", "PISA": "I", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1541621496277", "namaLengkap": "RAYA", "jenisKelamin": "P", "PISA": "A", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" } ] }, "resultCode": "1000", "resultMessage": "Success"}'
        r = json.loads(r)
    except Exception as e:
        print("Error MI :", str(e))
        msg = str(e)

    return dict(resp=r, req=req, msg=msg)


@router.post('/upload_closing_agent')
def upload_closing_agent(req: UploadFileClosingAgent):
    msg = "success"
    r=[]
    FILE_HOST = '/var/www/html/ifg-life/frontend/web/uploads/'
    try:
        r = auth_login()
        r = json.loads(r)

        #print("====================== AUTH =============================", r)

        # req = jsonable_encoder(req)
        fileStatement = ('fileStatement', (req.fileStatement, open('{}{}'.format(FILE_HOST, req.fileStatement), 'rb')))

        files = list()
        files = [fileStatement]
        payload = dict(nomorSPAJ=req.nomorSPAJ, fileStatement=req.fileStatement)

        headers = {"AccessToken": r['data']['accessToken'],
                   'clientId': CLIENT_ID,
                   'secretKey': SECRET_KEY}

        print("======================= HEADER UPLOAD ============================", headers)
        print("======================= PAYLOAD UPLOAD ============================", payload)
        print("======================= PAYLOAD FILES ============================", files)
        r = requests.request("POST", BASE_URL + 'ifg_life/closing_agent_document', headers=headers, data=payload, files=files)
        r = r.text
        print("======================= HEADER ============================", headers)
        print("===================================================", r)
        # r = '{"data": { "transactionNumber": "726cebc5-6910-49ba-b0dd-ffad1f429bcc", "policyTotal": 3, "resultList": [ { "nomorKartuInhealth": "1501621496272", "namaLengkap": "OPIN PASRULI", "jenisKelamin": "L", "PISA": "P", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1511621496273", "namaLengkap": "OPI", "jenisKelamin": "P", "PISA": "I", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" }, { "nomorKartuInhealth": "1541621496277", "namaLengkap": "RAYA", "jenisKelamin": "P", "PISA": "A", "tanggalMulai": "2021-09-01", "tanggalAkhir": "2021-12-31", "resultCode": "1000", "resultMessage": "Success" } ] }, "resultCode": "1000", "resultMessage": "Success"}'
        r = json.loads(r)
    except Exception as e:
        print("Error MI :", str(e))
        msg = str(e)

    return dict(resp=r, req=req, msg=msg)