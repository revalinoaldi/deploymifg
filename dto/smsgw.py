from pydantic import BaseModel
from typing import Optional


class Otp(BaseModel):
    msisdn: str
    pin: str
    nopolis: Optional[str] = ''


class SmsNotif(BaseModel):
    msisdn: str
    msg: str

