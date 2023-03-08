from fastapi.responses import JSONResponse
from fastapi.encoders import jsonable_encoder
from starlette.responses import FileResponse

# from const.appcfg import IMAGE
from const.rcval import *


def response(data, rc: int = RC_SUCCESS):
    return JSONResponse(default_response(data, RCMSG_ID[rc], rc))


def default_response(data, msg, rc):
    return {
        'status': {
            'msg': msg,
            'rc': rc
        },
        'data': jsonable_encoder(data)
    }


def basic_response(rc: int = RC_SUCCESS, msg: str = 'Success'):
    return JSONResponse(default_basic_response(msg, rc))


def default_basic_response(msg, rc):
    return {
        'status': {
            'msg': msg,
            'rc': rc
        }
    }


# def image_response(file_name):
#     return media_response(file_name, IMAGE)


def media_response(file_name, media_type):
    return FileResponse(f"assets/{media_type}/{file_name}")