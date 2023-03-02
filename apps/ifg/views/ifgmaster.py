# -*- coding: utf-8 -*-
from fastapi import Depends
from fastapi.routing import APIRouter
from starlette import status
import requests
from apps.ifg.constants.ifg import BASE_URL
from apps.ifg.serializers.ifg_response import *
from apps.ifg.depends.get_jwt import get_jwt
from apps.ifg.depends.get_token_decode import get_token_decoded
from apps.ifg.models.ifg_models import HcProvicer
from typing import List
from core.serializers.message import Message

router = APIRouter()


@router.get('/plan', status_code=status.HTTP_200_OK, response_model=List[PlanResp])
def plan(token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):
    ret = requests.get(url="{}{}".format(BASE_URL, "plan"))
    return ret.json()


@router.get('/benefit', status_code=status.HTTP_200_OK, response_model=List[BenefitResp])
def benefit(token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):
    ret = requests.get(url="{}{}".format(BASE_URL, "benefit"))
    return ret.json()


@router.get('/batasan', status_code=status.HTTP_200_OK, response_model=List[BatasanResp])
def batasan(token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):
    ret = requests.get(url="{}{}".format(BASE_URL, "batasan"))
    return ret.json()


@router.get('/frequensi', status_code=status.HTTP_200_OK, response_model=List[FrequensiResp])
def frequensi(token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):
    ret = requests.get(url="{}{}".format(BASE_URL, "frequensi"))
    return ret.json()


@router.get('/manfaat', status_code=status.HTTP_200_OK, response_model=List[ManfaatResp])
def manfaat(token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):
    ret = requests.get(url="{}{}".format(BASE_URL, "manfaat"))
    return ret.json()


@router.get('/kawin', status_code=status.HTTP_200_OK, response_model=List[KawinResp])
def kawin(token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):
    ret = requests.get(url="{}{}".format(BASE_URL, "kawin"))
    return ret.json()


@router.get('/kelas', status_code=status.HTTP_200_OK, response_model=List[KelasResp])
def kelas(token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):
    ret = requests.get(url="{}{}".format(BASE_URL, "kelas"))
    return ret.json()


@router.get('/provider-type', status_code=status.HTTP_200_OK, response_model=List[ProviderTypeResp])
def providerType(token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):
    ret = requests.get(url="{}{}".format(BASE_URL, "provider-type"))
    return ret.json()


@router.get('/provice', status_code=status.HTTP_200_OK, response_model=List[ProvinceResp])
def provice(token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):
    ret = requests.get(url="{}{}".format(BASE_URL, "provice"))
    return ret.json()


@router.post('/provider', status_code=status.HTTP_200_OK, response_model=List[ProviderResp])
def provider(app: HcProvicer ,token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):
    ret = requests.post(url="{}{}".format(BASE_URL, "provider"), json=app.dict())
    return ret.json()


@router.get('/jenis-mutasi', status_code=status.HTTP_200_OK, response_model=List[JenisMutasiResp])
def jenisMutasi(token: str = Depends(get_token_decoded), jwt_token: str = Depends(get_jwt)):
    ret = requests.get(url="{}{}".format(BASE_URL, "jenis-mutasi"))
    return ret.json()
