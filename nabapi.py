import time

import requests
import json

token = ""
header = {'content-type' : 'application/json', 'authorization': 'Bearer ' + token}

# host = "http://127.0.0.1:8000/"
host = 'http://172.16.204.20:8080/'
login = host+"auth/login"
otp_login = host+"auth/verify_otp_login"
price = host+"master/price"
inq = host+"prepaid/inq"
trx = host+"prepaid/pay"
emoneyprods = host+'master/list_emoney'

# msisdn = "082191358706"
# uuid = "6aac2167-131d-4be5-a139-1165d839a6db"

msisdn = "081285136739"
uuid = "96e28b0c-e3bd-4d7c-b9bd-ea958326f74a"


access_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIwODEyODUxMzY3MzkiLCJ1dWlkIjoiOTZlMjhiMGMtZTNiZC00ZDdjLWI5YmQtZWE5NTgzMjZmNzRhIiwidXNlcl9sZXZlbCI6MywiZXhwIjoxNjI3NDA2Mjk3fQ.N2u1rtYFmoBxc9yYKXYMDRU259wvdgUpZ4-IOmXDo14"
headerin = {'Content-Type': 'application/json', 'Authorization': 'Bearer {}'.format(access_token)}
# print(headerin)
"""
login
"""

l = requests.post(url=login, json=dict(msisdn=msisdn, uuid=uuid), headers=header)
lr = json.loads(l.text)
print("login: ", lr)
print("login: ", l.headers)

exit()


# o = requests.post(url=otp_login, json=dict(msisdn=msisdn, uuid=uuid, otp_code="2474"), headers=header)
# r0 = json.loads(o.text)
# print("otp: ", r0)
# print("otp: ", o.headers)
# exit()


# p = requests.post(url=emoneyprods)
# pr = json.loads(p.text)
# print("get product: ", pr)
# print("get product header: ", p.headers)
#
# time.sleep(3)
# exit()

reqid = "EM00006"
ptype = "emandiri"
# subscriber_id = "081298156385:MTS10:10800:R:1:Reguler 10.000"
# subscriber_id = "081298156380:MTS5:5650:R:1:Reguler 5.000"
# subscriber_id = "081298156380:MTS15:15000:R:1:Reguler 15.000"
# subscriber_id = "081298156386:MGP25:26000:R:9:Top Up Gopay Customer 25,000"
subscriber_id = f"{msisdn}:160000:{ptype}:31:Mandiri E-Money:6013500601505192:andreasdimas@gmail.com"


i = requests.post(url=trx, json=dict(reqid=reqid, user_msisdn=msisdn, subscriber_id=subscriber_id,
                                       ptype=ptype, longitude="", latitude=""), headers=headerin)
ir = json.loads(i.text)
print("inquiry: ", ir)
print("inquiry: ", i.headers)


# t = requests.post(url=trx, json=dict(reqid=reqid, user_msisdn=msisdn, subscriber_id=subscriber_id,
#                                        ptype="pulsa", longitude="", latitude=""), headers=headerin)
# tr = json.loads(t.text)
# print("transaksi: ", tr)
# print("transaksi: ", t.headers)