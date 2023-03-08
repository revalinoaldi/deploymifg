from enum import Enum


class UnverifiedUser(Enum):
    MAX_AMOUNT_MONTHLY = 10000000
    MAX_AMOUNT = 500000


class VerifiedUser(Enum):
    MAX_AMOUNT = 1000000000

rejected_reasons = [
    'Foto KTP harus dilakukan secara langsung',
    'Foto KTP salah/tidak sesuai',
    'Foto KTP tidak jelas/blur',
    'Foto Selfie harus dilakukan secara langsung',
    'Foto Selfie salah/tidak sesuai',
    'Foto Selfie tidak jelas/blur/terhalang oleh KTP',
    'Foto Selfie harus memegang KTP',
    'Nama salah/tidak sesuai dengan KTP',
    'No. KTP salah/tidak sesuai dengan kTP',
    'Email salah/tidak sesuai',
    'Jenis kelamin salah/tidak sesuai dengan KTP',
    'Tempat/Tanggal/Tahun lahir salah/tidak sesuai dengan KTP',
    'Alamat salah/tidak sesuai',
    'Alamat wajib diisi'
]


"""
KYC level
"""
UNVERFIED_USER = 0
VERIFIED_USER = 1  # USER HAS NO OUTLET
VERIFIED_AGENT_BORROWER = 2  # USER HAS OUTLET AND REGISTERED AS BORROWER
VERIFIED_AGENT = 3   # USER HAS OUTLET