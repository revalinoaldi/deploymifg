from pydantic import BaseModel, Field


class TokenReq(BaseModel):
    user: str = Field(..., example="someone")
    secreet_key: str = Field(..., example="asldhkasdasdas==")