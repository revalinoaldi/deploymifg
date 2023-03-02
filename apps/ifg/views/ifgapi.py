# -*- coding: utf-8 -*-
from fastapi import Depends
from fastapi.routing import APIRouter
from starlette import status

from apps.ifg.constants.ifg import BASE_URL, BASE_URL_OTP, BASE_URL_EMAIL
from apps.ifg.models.ifg_models import *
from apps.ifg.serializers.ifg_response import SpaResp, SmsResp, EmailResp
from apps.ifg.depends.get_jwt import get_jwt
from apps.ifg.depends.get_token_decode import get_token_decoded
import requests
from core.serializers.message import Message
from typing import List
import jwt

router = APIRouter()


@router.post('/pengajuan-spaj', status_code=status.HTTP_200_OK, response_model=SpaResp)
def spaj(perusahaan:HcPerusahaan, spa:HcSpa, tertanggung:HcTertanggung, penerima_manfaat:List[HcPenerimaManfaat], orang: HcOrang, benefit: HcBenefitSPa, pertanyaan:List[HcPertanyaanKesehatan], token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):

    try:
        pm = []
        for pen in penerima_manfaat:
            pm.append(pen.dict())
        q = []
        for qw in pertanyaan:
            q.append(qw.dict())
        params = dict(
            perusahaan=perusahaan.dict(),
            spa=spa.dict(),
            tertanggung=tertanggung.dict(),
            penerima_manfaat=pm,
            orang=orang.dict(),
            benefit=benefit.dict(),
            pertanyaan=q
        )
        ret = requests.post(url="{}{}".format(BASE_URL, "pengajuan-spaj"), json=params)
    except Exception as e:
        ret = None
        print(e)
    return ret.json()


@router.post('/get-peserta', status_code=status.HTTP_200_OK, response_model=SpaResp)
def getPeserta(app:PesertaParams, token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):
    try:
        ret = requests.post(url="{}{}".format(BASE_URL, "get-peserta"), json=app.dict())
    except Exception as e:
        ret = None
        print(e)
    return ret.json()


@router.post('/update-polis', status_code=status.HTTP_200_OK, response_model=SpaResp)
def polis(polis:HcPolis, token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):

    try:
        ret = requests.post(url="{}{}".format(BASE_URL, "update-polis"), json=polis.dict())
    except Exception as e:
        ret = None
        print(e)
    return ret.json()


@router.post('/add-mutasi', status_code=status.HTTP_200_OK, response_model=SpaResp)
def mutasi(app:HcMutasiPeserta, token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):

    try:
        ret = requests.post(url="{}{}".format(BASE_URL, "add-mutasi"), json=app.dict())
    except Exception as e:
        ret = None
        print(e)
    return ret.json()


@router.post('/send-otp', status_code=status.HTTP_200_OK, response_model=SmsResp)
def otp(app: SendOtp, token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):

    try:
        ret = requests.get(url=BASE_URL_OTP, params=app.dict())
    except Exception as e:
        ret = None
        print(e)
    return ret.json()


@router.post('/send-email', status_code=status.HTTP_200_OK, response_model=EmailResp)
def email(app: SendEmail, token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):

    try:
        ret = requests.post(url=BASE_URL_EMAIL, data=app.dict(), auth=("emailcustomercare", "C0stuMerC4R3!"))
    except Exception as e:
        ret = None
        print(e)
    return ret.json()




