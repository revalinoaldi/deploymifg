from hashlib import sha256
from base64 import b64encode
from datetime import datetime
import hmac


class DokuHelper(object):

    def genDigest(self, jsondata):
        # print('JSONDATA--->: ', jsondata)
        sh = sha256(jsondata.encode()).digest()
        return b64encode(sh).decode()

    def genSignature(self, reqid, reqtimestamp, reqtarget, digest, clientid, secretkey):
        componentSignature = "Client-Id:" + clientid
        componentSignature += "\n"
        componentSignature += "Request-Id:" + reqid
        componentSignature += "\n"
        componentSignature += "Request-Timestamp:" + reqtimestamp
        componentSignature += "\n"
        componentSignature += "Request-Target:" + reqtarget
        componentSignature += "\n"
        componentSignature += "Digest:" + digest

        print('COMPONENT SIGNATURE--->: ', componentSignature)
        print('SECRET KEY--->', secretkey)
        dig = hmac.new(key=secretkey.encode(), msg=componentSignature.encode(), digestmod=sha256).digest()

        return '{}{}'.format('HMACSHA256=', b64encode(dig).decode())

    def validateSignature(self, reqid, reqtimestamp, reqtarget, digest, signature, clientid, secretkey):
        sign = self.genSignature(reqid, reqtimestamp, reqtarget, digest, clientid, secretkey)

        return sign == signature

    def reqid_timestamp(self):
        # reqid to doku, timestamp
        nw = datetime.utcnow()
        return nw.strftime('TRBK-%y%m%d-%H%M%S%f'), nw.strftime('%Y-%m-%dT%H:%M:%SZ')