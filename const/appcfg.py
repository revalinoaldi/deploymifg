import os
from dotenv import load_dotenv
from const.testsecrect import *
load_dotenv(override=True)
secret = get_secret()

"""
Database
"""
# DBHOST = "172.16.204.24"
# DBPORT = 3306
# DBUSER = "nabiladev"
# DBPWD = "nabiladev"
# DBNAME = "onetapdev"
# DBCHARSET = "utf8"

DBHOST = os.getenv('DBHOST')
DBPORT = int(os.getenv('DBPORT'))
DBUSER = secret['username']
DBPWD = secret['password']
DBNAME = os.getenv('DBNAME')
DBCHARSET = os.getenv('DBCHARSET')

"""
REDIS
"""
REDIS_HOST = os.getenv('REDIS_HOST')
REDIS_PORT = int(os.getenv('REDIS_PORT'))
REDIS_DB = os.getenv('REDIS_DB')
REDIS_PWD = os.getenv('REDIS_PWD')


"""
DOKU
"""
URLCHECKOUTPROD = 'https://jokul.doku.com/checkout/v1/payment'
URLCHECKOUTDEV = 'https://api-sandbox.doku.com/checkout/v1/payment'
TARGETCHECKOUT = '/checkout/v1/payment'
REQTARGETNOTIFVA = '/doku/notif_va'
REQTARGETNOTIFCC = '/doku/notif_cc'
ADMFEE = 0
CURRENCY = 'IDR'
DOKU_PREFIX_VA = ''
CALLBACK = ''
EXPIRY = 1440
COUNTRY = 'ID'
PAYMENT_METHOD = [
            "VIRTUAL_ACCOUNT_BCA",
            "VIRTUAL_ACCOUNT_BANK_MANDIRI",
            "VIRTUAL_ACCOUNT_BANK_SYARIAH_MANDIRI",
            "VIRTUAL_ACCOUNT_BRI",
            "VIRTUAL_ACCOUNT_DOKU",
            "CREDIT_CARD",
        ]
DOKU_CLIENT_ID_SANDBOX = os.getenv('DOKU_CLIENT_ID_SANDBOX')
DOKU_SECRET_KEY_SANDBOX = os.getenv('DOKU_SECRET_KEY_SANDBOX')

DOKU_CLIENT_ID_PROD = os.getenv('DOKU_CLIENT_ID_PROD')
DOKU_SECRET_KEY_PROD = os.getenv('DOKU_SECRET_KEY_PROD')

"""
IFG Translator
"""
IFG_USERID = os.getenv('IFG_TRANSLATOR_USERID')
IFG_SECRETKEY = os.getenv('IFG_TRANSLATOR_SECRETKEY')

IFG_HOST = os.getenv('ROOT_MIDDLEWARE') + '/api/v1'
IFG_TOKEN_URL = IFG_HOST + '/token/get-token'
IFG_PESERTA_URL = IFG_HOST + '/ifg/get-peserta'
IFG_UPDATE_POLIS_URL = IFG_HOST + '/ifg/update-polis'
IFG_ADD_MUTASI_URL = IFG_HOST + '/ifg/add-mutasi'
IFG_OTP_URL = IFG_HOST + '/ifg/send-otp'
IFG_SEND_EMAIL = IFG_HOST + '/ifg/send-email'

LINK_CLOSING_STATEMENT_AGENT = os.getenv('ROOT_FRONTEND') + '/closing/{}'
BASE_URL_OTP = "http://gateway.ifg-life.id/smsgw/send.otp.php"
BASE_URL_EMAIL = "https://gateway.ifg-life.id/emailapi/messaging/email/send.php"

SMTP_SERVER = "" 
SMTP_PORT = ""