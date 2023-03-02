# -*- coding: utf-8 -*-
from fastapi import Depends
from fastapi.encoders import jsonable_encoder
from fastapi.routing import APIRouter
from starlette import status

from apps.ifg.depends.get_jwt import get_jwt
from apps.ifg.depends.get_token_decode import get_token_decoded
from apps.ifg.models.token_models import *
from apps.ifg.serializers.token_response import *
from core.serializers.message import Message
from datetime import datetime, timedelta
import jwt

router = APIRouter()


@router.post('/get-token', response_model=TokenResp, status_code=status.HTTP_200_OK,
             responses={400: {"model": Message}})
def get_token(app: TokenReq):
    now = datetime.utcnow() + timedelta(minutes=30)

    a = jwt.encode(
        {'message': app.user}, app.secreet_key
    )
    return jsonable_encoder({"token": a, "exp": now})
