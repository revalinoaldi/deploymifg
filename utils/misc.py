import time
import random
import string
import requests
import hmac
from datetime import datetime
from hashlib import sha256
from base64 import b64encode

from starlette.requests import Request


def current_dt():
    return datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d %H:%M:%S')


def sanitize_msisdn(msisdn, sanitizeto="0"):
    if len(msisdn) > 9:
        msisdn = str(msisdn).replace("+", "")
        if sanitizeto == "0":
            msisdn = msisdn.replace(msisdn[:2], "0", 1) if msisdn[:2] == "62" else msisdn
        elif sanitizeto == "62":
            msisdn = msisdn.replace(msisdn[:1], "62", 1) if msisdn[:1] == "0" else msisdn
        else:
            msisdn = msisdn
    else:
        msisdn = msisdn
    return msisdn


def gen_otp():
    return ''.join(random.SystemRandom().choice(string.digits) for _ in range(4))


def gen_no_polis(n):
    mmyy = datetime.now().strftime("%y%m")
    nm = str(n).zfill(6)
    return '{}{}{}'.format('MIFG', mmyy, nm)


def gen_random_an(length=10):
    return ''.join(random.choices(string.ascii_uppercase + string.digits, k=length))


#def generatePin():
#    return random.randint(111111, 999999)


def _gensignature(msisdn, msg, apps, appkey):
    res = None
    try:
        rawmsg = '{}{}{}{}'.format(msisdn, msg, apps, appkey)
        dig = hmac.new(key=appkey.encode(), msg=rawmsg.encode(), digestmod=sha256).digest()
        res = b64encode(dig).decode()
    except Exception as e:
        print('sms gen sign: ' + str(e))

    return res


def capital_name(nm):
    r = ''
    print("NM-->", nm)
    nm1 = nm.split()
    if len(nm1) > 1:
        for i in nm1:
            r += i.capitalize() + ' '
    else:
        r = nm.capitalize()
    return r.strip()



