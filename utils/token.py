import os
import sys
from datetime import datetime, timedelta
from jose import jwt, JWTError
from typing import Optional
from dto.authreg import RequestToken
from utils.misc import *
from responses.BaseResponse import *
from utils.tredis import Tredis
from const.appcfg import SECRET_ACCESS_KEY, SECRET_REFRESH_KEY, ALGORITHM, ACCESS_TOKEN_EXPIRE_MINUTES


def generate_token(data: dict, category: Optional[str] = 'access',  expires_delta: Optional[timedelta] = None):
    # token type : access or refresh
    redis = Tredis()
    token = False
    try:
        rawdata = data.copy()
        if expires_delta:
            expire = datetime.now() + expires_delta
        else:
            expire = datetime.now() + timedelta(minutes=ACCESS_TOKEN_EXPIRE_MINUTES)
        key = SECRET_ACCESS_KEY if category == 'access' else SECRET_REFRESH_KEY

        rawdata.update(exp=expire)
        token = jwt.encode(rawdata, key, ALGORITHM)
        if category == 'refresh':
            msisdn = data['sub']
            redis.set_cache("{}-{}".format('RT', msisdn), token, int(30 * 60 * ACCESS_TOKEN_EXPIRE_MINUTES))

    except Exception as e:
        exc_type, exc_obj, exc_tb = sys.exc_info()
        fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
        print(exc_type, fname, exc_tb.tb_lineno)

    return token


def request_access_token(msisdn):
    redis = Tredis()
    msisdn = sanitize_msisdn(msisdn)
    try:
        refresh_token = redis.get_cache("{}-{}".format('RT', msisdn))
        if refresh_token is None:
            return dict(rc=RC_TOKEN_REFRESH_EXPIRED, access_token='')

        payload = jwt.decode(refresh_token, SECRET_REFRESH_KEY, algorithms=[ALGORITHM], options={'verify_exp': False})
        msisdn: str = payload.get("sub")
        uuid: str = payload.get("uuid")
        userlevel: str = payload.get("user_level")
        if msisdn is None or uuid is None:
            return dict(rc=RC_TOKEN_REFRESH_EXPIRED, access_token='')

        # expired = payload.get("exp")
        #
        # if expired < time.time():
        #     new_exp = redis.get_cache("{}{}".format(msisdn, uuid))
        #     if not new_exp:
        #         return dict(rc=RC_TOKEN_REFRESH_EXPIRED, access_token='')
        # redis.set_cache("{}{}".format(msisdn, uuid), True, int(60 * ACCESS_TOKEN_EXPIRE_MINUTES))
        redis.set_cache("{}-{}".format('RT', msisdn), refresh_token, int(30 * 60 * ACCESS_TOKEN_EXPIRE_MINUTES))

    except JWTError as e:
        return dict(rc=RC_TOKEN_AUTH_FAILED, access_token='')

    access_token = generate_token(
        data={
            "sub": msisdn,
            "uuid": uuid,
            "user_level": userlevel
        }, category='access'
    )
    return dict(rc=RC_SUCCESS,access_token=access_token)