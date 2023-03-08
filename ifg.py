from fastapi import FastAPI, Depends
from fastapi.middleware.cors import CORSMiddleware


from routers import payment
# from helper import AuthHelper
from exceptions.HTTPExceptions import HTTPException
from starlette.requests import Request
from starlette.responses import JSONResponse
from responses.BaseResponse import default_response
from utils.rotatelogger import configure_rotating_logger
from routers import mi
from routers import ifg, sms, address, notification
app = FastAPI(debug=True)

origins = [
    "http://localhost:8080",
]

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"]
)

app.include_router(
    router=payment.router,
    prefix='/payment',
    tags=['payment'],
    responses={404: {'message': 'Not Found'}},
    # dependencies=[Depends(AuthHelper.get_current_active_user)]
)

app.include_router(
    router=mi.router,
    prefix='/mi',
    tags=['mi'],
    responses={404: {'message': 'Not Found'}},
    # dependencies=[Depends(AuthHelper.get_current_active_user)]
)

app.include_router(
    router=ifg.router,
    prefix='/ifg',
    tags=['ifg'],
    responses={404: {'message': 'Not Found'}},
    # dependencies=[Depends(AuthHelper.get_current_active_user)]
)

app.include_router(
    router=sms.router,
    prefix='/sms',
    tags=['sms'],
    responses={404: {'message': 'Not Found'}},
    # dependencies=[Depends(AuthHelper.get_current_active_user)]
)

app.include_router(
    router=address.router,
    prefix='/address',
    tags=['address'],
    responses={404: {'message': 'Not Found'}},
    # dependencies=[Depends(AuthHelper.get_current_active_user)]
)

app.include_router(
    router=notification.router,
    prefix='/notification',
    tags=['notification'],
    responses={404: {'message': 'Not Found'}},
    # dependencies=[Depends(AuthHelper.get_current_active_user)]
)


@app.on_event("startup")
def startup_event():
    configure_rotating_logger('ifg', debug=True)


@app.exception_handler(HTTPException)
async def unicorn_exception_handler(request: Request, exc: HTTPException):
    return JSONResponse(
        status_code=exc.status_code,
        content=default_response(data=exc.data, rc=exc.rc, msg=exc.msg),
        headers=exc.headers
    )