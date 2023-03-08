from pydantic import BaseModel
from typing import Optional


class Otp(BaseModel):
    msisdn: str
    pin: str
    nopolis: Optional[str] = ''

