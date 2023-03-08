import http
from typing import Any

from starlette import status


class HTTPException(Exception):

    def __init__(self, status_code: int = status.HTTP_400_BAD_REQUEST, data: Any = None, msg: str = None,
                 rc: int = 40, headers: Any = None,):
        if data is None:
            data = {}
        if msg is None:
            msg = http.HTTPStatus(status_code).phrase
        self.status_code = status_code
        self.data = data
        self.msg = msg
        self.rc = rc
        self.headers = headers
