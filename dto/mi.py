from pydantic import BaseModel, Field, validator
from fastapi import UploadFile, File
from typing import List, Optional
from responses.BaseResponse import *

class ItemsCancel(BaseModel):
    nomorKartuInhealth: str
    tanggalPembatalan: str = Field(..., example='1993-11-12')
    tipePembatalan: str
    alasanPembatalan: str
    extraInfo: dict

class IndividualInsuranceCancel(BaseModel):
    cancellationList: List[ItemsCancel]

class Alamat(BaseModel):
    alamat: str
    RT: str
    RW: str
    kelurahan: str
    kecamatan: str
    kota: str
    provinsi: str
    kodePos: str

class Pekerjaan(BaseModel):
    pekerjaan: str
    bidangUsaha: str
    jabatan: str
    namaInstitusiTempatKerja: str
    alamat: Alamat
    telepon: str

class PemegangPolis(BaseModel):
    namaLengkap: str
    jenisKartuIdentitas: str
    nomorKartuIdentitas: str
    tanggalLahir: str = Field(..., example='1993-11-12')
    tempatLahir: str
    jenisKelamin: str
    statusPerkawinan: str
    alamatSesuaiIdentitas: Alamat
    alamatDomisili: Alamat
    handphone: str
    telepon: str
    email: str
    pekerjaan: Pekerjaan
    alamatSuratMenyurat: str
    hubungan: str

class Tertanggung(BaseModel):
    namaLengkap: str
    jenisKartuIdentitas: str
    nomorKartuIdentitas: str
    tempatLahir: str
    tanggalLahir: str = Field(..., example='1993-11-12')
    jenisKelamin: str
    statusPerkawinan: str
    alamatSesuaiIdentitas: Alamat
    alamatDomisili: Alamat
    handphone: str
    telepon: str
    email: str
    pekerjaan: Pekerjaan

class SumberDana(BaseModel):
    tujuanPengajuanAsuransi: List[str]
    sumberPenghasilanPerbulan: List[str]
    jumlahPenghasilanKotorPertahun: str
    metodePembayaranPremi: str
    caraBayarPremi: str
    premi: str
    #periodeBayarPremi: str
    #tanggalBayarPremi: str
    #jumlahBayarPremi: str

class PembayaranPremi(BaseModel):
    pemegangPolis: bool
    sumberDana: SumberDana

class PenerimaManfaat(BaseModel):
    namaLengkap: str
    nomorIndukKependudukan: str
    tanggalLahir: str
    jenisKelamin: str
    hubungan: str
    persentase: str

class ManfaatUtama(BaseModel):
    kode: Optional[str] = None
    nama: Optional[str] = None

class ManfaatTambahan(BaseModel):
    kode: Optional[str] = None
    nama: Optional[str] = None

class DataAsuransi(BaseModel):
    produk: str
    manfaatUtama: List[ManfaatUtama]
    plan: str
    kelas: str
    manfaatTambahan: List[ManfaatTambahan]
    provider: str
    masaAsuransi: str
    mataUang: str

class KepemilikanAsuransi(BaseModel):
    statusKepemilikan: bool
    alasan: Optional[str] = None

class KesehatanTertanggung(BaseModel):
    idPernyataan: str
    opsi: bool
    textValue: List[str]

class AgenPenutup(BaseModel):
    noAgen: str
    noLisensiAgen: str
    namaAgen: str
    teleponAgen: str

class ApplicationList(BaseModel):
    nomorSPAJ: str
    #nomorPolis: str
    statusPengajuan: str
    pemegangPolis: PemegangPolis
    tertanggung: Tertanggung
    pembayaranPremi: PembayaranPremi
    penerimaManfaat: List[PenerimaManfaat]
    dataAsuransi: DataAsuransi
    kepemilikanAsuransi: KepemilikanAsuransi
    kesehatanTertanggung: List[KesehatanTertanggung]
    pencetakanPolis: bool
    alamatPengirimanPolis: str
    ikhtisarCetakanPolis: str
    agenPenutup: AgenPenutup


class IndividualInsurance(BaseModel):
    applicationList: List[ApplicationList]

class PaymentList(BaseModel):
    nomorSPAJ: str
    tanggalBayarPremi: str = Field(..., example='2021-10-28 13:48:20')
    jumlahBayarPremi: str = Field(..., example='800.000')

class PaymentConfirmation(BaseModel):
    paymentList: List[PaymentList]


class UploadFileSPAJ(BaseModel):
    nomorSPAJ: str = Field(..., example='')
    fileKTPPemegangPolis: str
    fileKKPemegangPolis: str
    fileKTPTertanggung: str
    fileKKTertanggung: str


class ClosingPernyataan(BaseModel):
    id: str
    textValue: str


class ClosingAgentData(BaseModel):
    nomorSPAJ: str = Field(..., example='SPAJ-0040')
    noAgen: str = Field(..., example='9999999999')
    noLisensiAgen: str = Field(..., example='"AGEN-A-001')
    namaAgen: str = Field(..., example='FENDY C')
    teleponAgen: str = Field(..., example='081000000')
    pernyataan: List[ClosingPernyataan] = Field(..., example=[{"id": "CSA001","textValue": "< 1 Tahun"},{"id": "CSA002","textValue": "Referensi"}])


class ClosingAgent(BaseModel):
    closingAgentList: List[ClosingAgentData]


class UploadFileClosingAgent(BaseModel):
    nomorSPAJ: str = Field(..., example='')
    fileStatement: str