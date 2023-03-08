import inspect
import json
import logging
import time
from datetime import datetime

from fastapi import Request, Response
from fastapi.exceptions import RequestValidationError, HTTPException as FastapiHTTPException
from fastapi.routing import APIRoute

from typing import Callable

from const.rcval import RC_UNKNOWN_ERROR, RCMSG_ID, RC_INVALID_PARAM
from dto.logdata import LogData
from exceptions.HTTPExceptions import HTTPException
from responses import BaseResponse
from utils.misc import gen_random_an
logger = logging.getLogger('ifg')


class ContextIncludedRoute(APIRoute):
    def get_route_handler(self) -> Callable:
        original_route_handler = super().get_route_handler()

        async def custom_route_handler(request: Request) -> Response:
            ld = LogData()
            ld.req_id = gen_random_an(6) + datetime.now().strftime('%Y%m%d%H%M%S')
            ld.http_method = request.method
            ld.url_path = request.url.path
            ld.headers = request.headers.items()
            ld.query_param = request.query_params.multi_items()

            request.state.extras = []
            request.state.extras.append(request.headers.items().__str__())

            ld.ip_forwarded = request.headers.get("X-Forwarded-For")
            ld.ip_client_host = request.client.host

            if await request.body():
                ld.request_body = await request.body()
                ld.request_body = ld.request_body.decode('utf-8')

            start_time = time.time()
            try:
                response: Response = await original_route_handler(request)
                process_time = time.time() - start_time
                if response.media_type == "application/json":
                    ld.response_body = response.body.decode('utf-8')
                ld.response_time = "{}ms".format(int(round(process_time, 2) * 1000))
                ld.extras = request.state.extras
                response.headers["Request-ID"] = ld.req_id
                logger.info(json.dumps(ld.__dict__))
                return response

            except RequestValidationError as e:
                ld.error = str(e)
                logger.info(json.dumps(ld.__dict__))
                return BaseResponse.response(str(e), RC_INVALID_PARAM)
            except HTTPException as e:
                ld.error = str(vars(e))
                logger.info(json.dumps(ld.__dict__))
                raise e
            except FastapiHTTPException as e:
                ld.error = str(vars(e))
                logger.info(json.dumps(ld.__dict__))
                raise e
            except Exception as e:
                ld.error = str(e)
                ld.trace = str(inspect.trace())
                logger.exception(json.dumps(ld.__dict__), exc_info=True)
                raise HTTPException(rc=RC_UNKNOWN_ERROR, msg=RCMSG_ID.get(RC_UNKNOWN_ERROR), status_code=500)

        return custom_route_handler

