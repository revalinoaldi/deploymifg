import json
from fastapi import APIRouter, Header
from routers import ContextIncludedRoute
import requests
from base64 import b64encode
import base64
from utils.tredis import Tredis
from dto.ifg import *
from const.ifg import *
from requests.auth import HTTPBasicAuth

router = APIRouter(route_class=ContextIncludedRoute)
redis_conn = Tredis()

@router.post('/agen')
def agen(req: Agen):
    msg = "success"
    r = []
    try:
        # return req
        req = jsonable_encoder(req)
        payload = req
        author = "{}:{}".format(username, password)
        author = author.encode('ascii')
        author = base64.b64encode(author)

        headers = {"Authorization": author}
        r = requests.get(IFG_ENDPOINT + 'mifg', params=payload, auth=HTTPBasicAuth(username, password))
        r = r.text
        print("======================= HEADER PAY CONFIRMATION ============================", headers)
        print("===================================================", r)
        r = json.loads(r)
    except Exception as e:
        print("Error IFG :", str(e))
        msg = str(e)

    return dict(resp=r, req=req, msg=msg)
