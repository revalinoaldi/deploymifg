import requests
from fastapi import Depends

from dto.smsgw import *

from helper.IfgHelper import IFGHelper
from const.appcfg import *
from utils.misc import *
from responses.BaseResponse import *


URL_SMS = 'http://192.168.1.5:8080/send.otp.php'


class SmsHelper:
    def send_sms(self, msisdn, msg):
        tk = IFGHelper().get_token()
        try:
            # otpwording = "Konfirmasi untuk MIFG My Managed Care Anda adalah {}. Mohon Jaga kerahasiaannya"
            # msg = otpwording.format(req.pin)
            head = {
                'Authorization': 'token ' + tk
            }
            print("TOKEN---> ", tk)
            print("HEADER---> ", head)
            r = requests.get(BASE_URL_OTP, params=dict(msisdn=msisdn, message=msg))
            print("RESPONSE---> ", r.text)
            if r.json()['result']['code'] == '1':
                return basic_response(RC_SUCCESS)
            else:
                return response(data=r.text, rc=RC_FAIL)
        except Exception as e:
            print(e)
            return response(data=str(e), rc=RC_FAIL)

    def notif_new_client(self, name, amount, dttime, msisdn):
        # tk = IFGHelper().get_token()
        try:
            wording = "Yth {}, Silahkan lakukan pembayaran MIFG My Managed Care sebesar Rp{} paling lambat {} Info 14072"
            msg = wording.format(capital_name(name), amount, dttime)

            res = self.send_sms(msisdn, msg)
            if res['rc'] == 1:
                return basic_response(RC_SUCCESS)
            else:
                return response(data=res, rc=RC_FAIL)
        except Exception as e:
            print(e)
            return response(data=str(e), rc=RC_FAIL)

    def notif_payment(self, name, amount, nospaj, dttime, msisdn):
        # tk = IFGHelper().get_token()
        try:
            wording = """Yth {}, terimakasih atas pembayaran premi {} sebesar Rp.{} yang kami terima pd tgl {}. Utk Info hub 14072"""
            msg = wording.format(capital_name(name), nospaj, amount, dttime)

            res = self.send_sms(msisdn, msg)
            if res['rc'] == 1:
                return basic_response(RC_SUCCESS)
            else:
                return response(data=res, rc=RC_FAIL)
        except Exception as e:
            print(e)
            return response(data=str(e), rc=RC_FAIL)


