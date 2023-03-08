from pydantic import BaseModel, Field
from typing import Optional


class AddressMap(BaseModel):
    provinsi: Optional[str] = Field(..., example="DKI Jakarta")
    kota: Optional[str] = Field(..., example="Jakarta Selatan")
    kecamatan: Optional[str] = Field(..., example="Pasar Minggu")
    kelurahan: Optional[str] = Field(..., example="Pejaten Barat")