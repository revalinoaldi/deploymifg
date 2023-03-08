import importlib
import requests
import json

from fastapi import APIRouter, Header, Depends
from fastapi.encoders import jsonable_encoder

from datetime import datetime

from routers import ContextIncludedRoute
from responses.BaseResponse import *
from helper.IfgHelper import IFGHelper
from dto.smsgw import *
from const.appcfg import *

router = APIRouter(route_class=ContextIncludedRoute)

#URL_SMS = 'http://192.168.1.5:8080/send.otp.php'
URL_SMS_OTP = 'http://gateway.ifg-life.id/smsgw/send.otp.php'

@router.post('/otp')
def otp(req: Otp, tk=Depends(IFGHelper().get_token)):
    try:
        otpwording = "Konfirmasi untuk MIFG My Managed Care Anda adalah {}. Mohon Jaga kerahasiaannya"
        msg = otpwording.format(req.pin)
        head = {
            'Authorization': 'token ' + tk
        }
        print("TOKEN---> ", tk)
        print("HEADER---> ", head)
        #r = requests.post(IFG_OTP_URL, json=dict(msisdn=req.msisdn, message=msg),  headers=head)
        r = requests.get(URL_SMS_OTP, params=(dict(msisdn=req.msisdn, message=msg)))
        print("RESPONSE---> ", r.text)
        if r.json()['result']['code'] == '1':
            return basic_response(RC_SUCCESS)
        else:
            return response(data=r.text, rc=RC_FAIL)
    except Exception as e:
        print(e)
        return response(data=str(e), rc=RC_FAIL)
