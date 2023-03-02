from pydantic import BaseModel
from typing import List


class PlanResp(BaseModel):
    KD_PLAN: str = None
    KD_STATUS: int = None
    NAMA_PLAN: str = None


class BenefitResp(BaseModel):
    KD_BENEFIT: str = None
    KD_STATUS: int = None
    NAMA_BENEFIT: str = None
    AKRONIM: str = None
    KD_BENEFIT_ADMEDIKA: str = None
    LUMP_SUM: str = None
    NO_URUT: str = None
    KETERANGAN: str = None


class BatasanResp(BaseModel):
    KD_BATASAN: int = None
    BATASAN: str = None
    NILAI: int = None


class FrequensiResp(BaseModel):
    KD_FREKUENSI: int = None
    FREKUENSI: str = None
    FAKTOR: str = None
    NILAI: int = None


class ManfaatResp(BaseModel):
    KD_MANFAAT: int = None
    MANFAAT: str = None


class KawinResp(BaseModel):
    KD_KAWIN: str = None
    STATUS_KAWIN: str = None


class KelasResp(BaseModel):
    KD_KELAS: str = None
    NAMA_KELAS: str = None


class ProviderTypeResp(BaseModel):
    KD_TIPE_PROVIDER: int = None
    TIPE_PROVIDER: str = None
    AKRONIM: str = None
    KD_STATUS: int = None


class ProviderResp(BaseModel):
    KD_PROVIDER: str = None
    KD_TIPE_PROVIDER: int = None
    KD_TIPE_RS: str = None
    KD_MEDIA_BAYAR: str = None
    KD_TIPE_PROVAS: str = None
    KD_STATUS: int = None
    NAMA_PROVIDER: str = None
    ALAMAT_PROVIDER: str = None
    TELP_PROVIDER: str = None
    FAX_PROVIDER: str = None
    KOTA_PROVIDER: str = None
    KD_POS_PROVIDER: str = None
    KETERANGAN: str = None
    PENANDA_TANGAN: str = None
    CONTACT_PERSON: str = None
    TELP_CONTACT_PERSON: str = None
    FAX_CONTACT_PERSON: str = None
    JAM_KERJA: str = None
    NAMA_MARKETING: str = None
    TELP_MARKETING: str = None
    EMAIL_MARKETING: str = None
    RJ: int = None
    RI: int = None
    DISKON: str = None
    KET_DISKON: str = None
    TGL_MULAI: str = None
    TGL_AKHIR: str = None
    NO_PKS_JS: str = None
    NO_PKS_PROVIDER: str = None
    TGL_PKS: str = None
    LAMA_PEMBAYARAN: str = None
    EMAIL: str = None
    CATATAN: str = None
    NAMA_KEUANGAN: str = None
    EMAIL_KEUANGAN: str = None
    TELP_KEUANGAN: str = None
    CATATAN_KEUANGAN: str = None
    KLASIFIKASI_RS: str = None
    USER_REKAM: str = None
    TGL_REKAM: str = None


class ProvinceResp(BaseModel):
    KD_PROVINSI: str = None
    KD_NEGARA: str = None
    NAMA_PROVINSI: str = None
    KETERANGAN: str = None


class JenisMutasiResp(BaseModel):
    KD_JENIS_MUTASI: int = None
    NAMA_JENIS_MUTASI: str = None
    NO_URUT: int = None
    STATUS: int = None


class Perusahaan(BaseModel):
    KD_PERUSAHAAN: str = None
    NAMA_PERUSAHAAN: str = None
    NAMA_ADMEDIKA: str = None
    ALAMAT_PERUSAHAAN: str = None
    KOTA_PERUSAHAAN: str = None
    KD_POS: str = None
    TELP_PERUSAHAAN: str = None
    FAX_PERUSAHAAN: str = None
    JENIS_USAHA: str = None
    NARAHUBUNG: str = None
    ALAMAT_NARAHUBUNG: str = None
    TELP_NARAHUBUNG: str = None


class Polis(BaseModel):
    NO_POLIS: str = None
    NO_SPA: str = None
    KD_PEJABAT: str = None
    MASA_ASURANSI: int = None
    TGL_MULAI_POLIS: str = None
    TGL_AKHIR_POLIS: str = None
    TGL_DISETUJUI: str = None
    NAMA_PENANGGUNG_JAWAB: str = None
    EMAIL_PENANGGUNG_JAWAB: str = None
    TGL_REKAM: str = None
    USER_REKAM: str = None
    TGL_UBAH: str = None
    PENUTUP: str = None
    TEMBUSAN1: str = None
    TEMBUSAN2: str = None
    AKRONIM: str = None
    PIN_WEBSITE: str = None
    NAMA_ADMEDIKA: str = None


class Benefit(BaseModel):
    KD_PLAN: str = None
    KD_BENEFIT: str = None
    KD_KELAS: str = None
    KD_PENGELOLA: str = None
    NO_SPA: str = None
    KD_MATA_UANG: str = None
    KD_BATASAN: int = None
    KD_FREKUENSI: int = None
    KD_MANFAAT: int = None
    NILAI_MANFAAT: int = None
    FAKTOR_FREKUENSI: int = None
    KETERANGAN: str = None
    PLAN_ADMEDIKA: str = None
    NO_ADMEDIKA: str = None
    TAMPILAN_KARTU_ADMEDIKA: str = None
    TGL_REKAM: str = None
    USER_REKAM: str = None


class Orang(BaseModel):
    ID_ORANG: str = None
    KD_KAWIN: str = None
    NAMA_ORANG: str = None
    NO_KTP: str = None
    GELAR_DEPAN: str = None
    GELAR_BELAKANG: str = None
    TEMPAT_LAHIR: str = None
    TGL_LAHIR: str = None
    JENIS_KELAMIN: str = None
    ALAMAT_KTP: str = None
    KOTA_KTP: str = None
    KD_POS_KTP: str = None
    ALAMAT_RUMAH: str = None
    KOTA_RUMAH: str = None
    KD_POS_RUMAH: str = None
    TELP: str = None
    EMAIL: str = None
    KETERANGAN: str = None
    TGL_REKAM: str = None
    USER_REKAM: str = None


class Tertanggung(BaseModel):
    NO_PESERTA: str = None
    NO_SPA: str = None
    ID_ORANG: str = None
    ID_PARENT: str = None
    KD_STATUS: str = None
    KD_KANTOR: str = None
    KD_PLAN: str = None
    TGL_MULAI_BEKERJA: str = None
    TGL_BERHENTI_BEKERJA: str = None
    TGL_MULAI_KEPESERTAAN: str = None
    NO_KARTU_ADMEDIKA: str = None
    JML_ANAK: int = None
    HUBUNGAN: int = None
    PREMI: int = None
    TGL_CETAK_SERTIFIKAT: str = None
    TGL_KIRIM_ADMEDIKA: str = None


class PenemrimaManfaat(BaseModel):
    NO_PESERTA: str = None
    NO_SPA: str = None
    ID_ORANG: str = None
    KD_STATUS: int = None
    HUBUNGAN: int = None
    PERSENTASE: str = None


class SpaResp(BaseModel):
    NO_SPA: str = None
    KD_PERUSAHAAN: str = None
    KD_PAKET: str = None
    KD_PROGRAM: str = None
    KD_MEDIA_BAYAR: int = None
    KD_CARA_BAYAR: int = None
    KD_TIPE_SPA: int = None
    KD_KATEGORI: int = None
    KD_MATA_UANG: str = None
    ALAMAT_PENAGIHAN: str = None
    KOTA_PENAGIHAN: str = None
    KD_POS_PENAGIHAN: str = None
    TELP_PENAGIHAN: str = None
    TGL_MOHON_SPA: str = None
    FILE_SPA: str = None
    FILE_POLIS: str = None
    FILE_BENEFIT: str = None
    FILE_PESERTA: str = None
    FILE_SYARAT_UMUM: str = None
    TGL_CETAK_SERTIFIKAT: str = None
    TGL_CETAK: str = None
    TGL_REKAM: str = None
    USER_REKAM: str = None
    perusahaan: Perusahaan
    polis: Polis = None
    benefit: Benefit
    orang: Orang
    tertanggung: Tertanggung
    penerima_manfaat: List[PenemrimaManfaat]


class Sms(BaseModel):
    code: str = None
    status: str = None
    message: str = None
    msgid: str = None
    insert_db: str = None


class SmsResp(BaseModel):
    result: Sms = None


class EmailResp(BaseModel):
    status: bool = None
    message: str = None
