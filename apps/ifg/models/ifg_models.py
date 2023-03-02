from pydantic import BaseModel, Field
from datetime import datetime


class HcPerusahaan(BaseModel):
    NAMA_PERUSAHAAN: str = Field(..., example="PT. XX")
    ALAMAT_PERUSAHAAN: str = Field(..., example="Jl. XX")
    KOTA_PERUSAHAAN: str = Field(..., example="Jakarta")
    KD_POS: str = Field(..., example="11111", max_length=5)
    TELP_PERUSAHAAN: str = Field(..., example="021111111")
    FAX_PERUSAHAAN: str = Field(..., example="021111111")
    JENIS_USAHA: str = Field(..., example="Teknologi Informasi")
    NARAHUBUNG: str = Field(..., example="Fulan")
    ALAMAT_NARAHUBUNG: str = Field(..., example="Jl. XX")
    TELP_NARAHUBUNG: str = Field(..., example="081111111")


class HcSpa(BaseModel):
    ALAMAT_PENAGIHAN: str = Field(..., example="JL. XX")
    KOTA_PENAGIHAN: str = Field(..., example="DKI Jakarta")
    KD_POS_PENAGIHAN: str = Field(..., example="11111", max_length=5)
    TELP_PENAGIHAN: str = Field(..., example="0211111")
    TGL_MOHON_SPA: str = Field(..., example="2121-01-01")
    TERTANGGUNG: str = Field(..., example="PT. XX")
    TGL_REKAM: str = Field(..., example="2021-12-12")
    USER_REKAM: str = Field(..., example="fulan")


class HcPolis(BaseModel):
    NO_POLIS: str = Field(..., example="MIFGxxxxxxxxx")
    NO_SPA: str = Field(..., example="XX12312", max_length=10)
    MASA_ASURANSI: str = Field(..., example="360")
    TGL_MULAI_POLIS: str = Field(..., example=datetime.utcnow())
    TGL_AKHIR_POLIS: str = Field(..., example=datetime.utcnow())
    TGL_DISETUJUI: str = Field(..., example=datetime.utcnow())
    NAMA_PENANGGUNG_JAWAB: str = Field(..., example="MIFGxxxxxxxxx")
    EMAIL_PENANGGUNG_JAWAB: str = Field(..., example="MIFGxxxxxxxxx")
    TGL_REKAM: str = Field(..., example=datetime.utcnow())
    USER_REKAM: str = Field(..., example="fulan")
    TGL_UBAH: str = Field(..., example=datetime.utcnow())
    PENUTUP: str = Field(..., example="MIFGxxxxxxxxx")
    TEMBUSAN1: str = Field(..., example="mr a")
    TEMBUSAN2: str = Field(..., example="mr a")
    AKRONIM: str = Field(..., example="")


class HcMutasiPeserta(BaseModel):
    NO: int = Field(..., example="1")
    ID_ORANG: str = Field(..., example="XX12312", max_length=11)
    NO_SPA: str = Field(..., example="XX12312", max_length=10)
    NO_PESERTA: str = Field(..., example="MIFGxxxx")
    KD_STATUS_AWAL: int = Field(..., example="1")
    KD_STATUS_AKHIR: int = Field(..., example="1")
    KD_JENIS_MUTASI: int = Field(..., example="1")
    KD_PLAN: str = Field(..., example="PA12312", max_length=7)
    TGL_AWAL: str = Field(..., example=datetime.utcnow())
    TGL_AKHIR: str = Field(..., example=datetime.utcnow())
    KETERANGAN: str = Field(..., example="XX12312", max_length=200)
    TGL_REKAM: str = Field(..., example=datetime.utcnow())
    USER_REKAM: str = Field(..., example="fulan")


class HcTertanggung(BaseModel):
    KD_PLAN: str = Field(..., example="PA12312", max_length=7)
    TGL_MULAI_BEKERJA: str = Field(..., example=datetime.utcnow())
    TGL_BERHENTI_BEKERJA: str = Field(..., example=datetime.utcnow())
    TGL_MULAI_KEPESERTAAN: str = Field(..., example=datetime.utcnow())
    JML_ANAK: int = Field(..., example="1")
    HUBUNGAN: int = Field(..., example="1", description="1 Peserta Utama, 2 Istri, 3 Suami, 4 dst Anak")
    PREMI: int = Field(..., example="XX12312")


class HcPenerimaManfaat(BaseModel):
    NAMA_ORANG: str = Field(..., example="fulana")
    NO_KTP: str = Field(..., example="1551222211113333", max_length=16)
    TELP: str = Field(..., example="0812222222", max_length=25)
    HUBUNGAN: int = Field(..., example="1", description="1 Peserta Utama, 2 Istri, 3 Suami, 4 dst Anak")
    PERSENTASE: int = Field(..., example="80")
    TGL_REKAM: str = Field(..., example="XX12312")
    USER_REKAM: str = Field(..., example="flan", max_length=50)


class HcOrang(BaseModel):
    KD_KAWIN: str = Field(..., example="b", max_length=2)
    NAMA_ORANG: str = Field(..., example="fulana")
    NO_KTP: str = Field(..., example="1551222211113333", max_length=16)
    GELAR_DEPAN: str = Field(..., example="TN")
    GELAR_BELAKANG: str = Field(..., example="S.KOM")
    TEMPAT_LAHIR: str = Field(..., example="Jakarta")
    TGL_LAHIR: str = Field(..., example="XX12312")
    JENIS_KELAMIN: str = Field(..., example="1", max_length=1, description="1=pria, 0=wanita")
    ALAMAT_KTP: str = Field(..., example="kebon jeruk")
    KOTA_KTP: str = Field(..., example="Jakaarta Barat")
    KD_POS_KTP: str = Field(..., example="111111", max_length=5)
    ALAMAT_RUMAH: str = Field(..., example="jl. kt")
    KOTA_RUMAH: str = Field(..., example="kt")
    FILE_KTP:str = Field(..., example="https://wwww.aaa.com/ktp.png", default_factory=None)
    FILE_KK:str = Field(..., example="https://wwww.aaa.com/kk.png", default_factory=None)
    KD_POS_RUMAH: str = Field(..., example="111111", max_length=5)
    TELP: str = Field(..., example="0812222222", max_length=25)
    EMAIL: str = Field(..., example="XX12312@aaaacom", max_length=50)
    KETERANGAN: str = Field(..., example="XX12312", default_factory=None)
    TGL_REKAM: str = Field(..., example="XX12312")
    USER_REKAM: str = Field(..., example="flan", max_length=50)


class HcBenefitSPa(BaseModel):
    KD_PLAN: str = Field(..., example="XX12312", max_length=7)
    KD_BENEFIT: str = Field(..., example="XX12312", max_length=5)
    KD_KELAS: str = Field(..., example="XX12312", max_length=10)
    KD_MATA_UANG: str = Field(..., example="IDR", max_length=3)
    KD_BATASAN: int = Field(..., example="XX12312")
    KD_FREKUENSI: int = Field(..., example="XX12312")
    KD_MANFAAT: int = Field(..., example="XX12312")
    NILAI_MANFAAT: int = Field(..., example="XX12312")
    FAKTOR_FREKUENSI: int = Field(..., example="XX12312")
    KETERANGAN: str = Field(..., example="XX12312", max_length=250)
    TGL_REKAM: str = Field(..., example="2021-01-01")
    USER_REKAM: str = Field(..., example="XX12312")


class HcProvicer(BaseModel):
    PROVIDER_TYPE: str = Field(..., example="PR")
    KD_PROVINSI: str = Field(..., example="JKT")


class PesertaParams(BaseModel):
    NO_SPA: str = Field(..., example="SPA1111")


class HcPertanyaanKesehatan(BaseModel):
    PERTANYAAN: str = Field(..., example="PR")
    JAWABAN: str = Field(..., example="Yes")
    NILAI: int = Field(..., example="100")


class SendOtp(BaseModel):
    msisdn: str = Field(..., example="0811111")
    message: str = Field(..., example="OTP Anda 00000")


class SendEmail(BaseModel):
    from_alias: str = Field(..., example="example@a.com")
    to: str = Field(..., example="example2@a.com")
    subject: str = Field(..., example="Example Subject")
    body: str = Field(..., example="Example Body")
    type: str = Field(..., example="html")
