from pydantic import BaseModel, Field
from typing import Optional


class EmailNotif(BaseModel):
    nospaj: str = Field(..., example='SPAJ-2112-H0JBP')