from pydantic import BaseModel, Field, validator
from typing import List, Optional
from responses.BaseResponse import *

class Agen(BaseModel):
    noagen: str