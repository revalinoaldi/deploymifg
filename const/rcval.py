"""
Prepaid RC for users
"""
RC_FAIL = 0
RC_SUCCESS = 1
RC_PENDING = 2
RC_INVALID_AMOUNT = 3
RC_PRODUCT_NOT_AVAILABLE = 4
RC_NOT_ENOUGH_DEPOSIT = 5
RC_TRID_NOT_FOUND = 6
RC_UNAUTHORIZED = 7
RC_INVALID_PARAM = 8
RC_SETPRICE_ERROR = 9
RC_SUBID_NOT_VALID = 11
RC_SUBID_TEMPORARY_SUSPEND = 12
RC_BILLER_ERROR = 13
RC_MSISDN_BLOCKED = 14
RC_SUBID_PERMANENT_SUSPEND = 15
RC_BILL_PAID = 16
RC_NO_BILL = 17
RC_PAY_REJECTED = 18
RC_OUTSTANDING_BILL = 19
RC_UNDEFINED_ERROR = 20
RC_AMOUNT_INCORRECT = 21
RC_MERCHANT_CODE_UNAVAILABLE = 22
RC_BILLER_CODE_UNAVAILABLE = 23
RC_TRX_CANNOT_BE_PROCESSED = 24
RC_TRX_DOUBLE = 25
RC_INVALID_MSISDN = 43
RC_MSISDN_NOT_FOUND = 46
RC_MSISDN_IN_GRACE_PERIOD = 47
RC_MSISDN_EXPIRED = 48
RC_INQUIRY_FAIL = 50
RC_INQ_PAY_TOO_LONG = 51
RC_INSUFFICIENT_BALANCE_TO_TRANSFER = 62
RC_TRANSFER_TO_SAME_AGENT = 62
RC_WAITING = 80
RC_MAINTENANCE = 81
RC_PENDING_SUCCESS = 82
RC_AGENT_ALREADY_EXISTS = 91
RC_INVALID_UPLINE_ID = 92
RC_TEST_NOT_FOUND = 98
RC_TOO_MANY_REQUEST = 99
RC_UNKNOWN_ERROR = 100
RC_ACTIVE_TICKET_FOUND = 101
RC_BANK_CLOSED = 102
RC_NO_ACTIVE_TICKET = 103
RC_TICKET_EXPIRED = 104
RC_TICKET_PAID_SUCCESSFULLY = 105
RC_TICKET_NOT_FOUND = 106
RC_BANK_NOT_AVAILABLE = 107
RC_DAILY_LIMIT_EXCEEDED = 108
RC_MONTHLY_LIMIT_EXCEEDED = 109
RC_OTP_INVALID = 120
RC_OTP_EXPIRED = 121
RC_TOKEN_AUTH_FAILED = 122
RC_TOKEN_ACCESS_EXPIRED = 123
RC_TOKEN_REFRESH_EXPIRED = 124
RC_MSISDN_EXIST = 125
RC_EMAIL_EXIST = 126
RC_SF_NOT_FOUND = 127
RC_OLD_PIN_INVALID = 128
RC_NIK_EXIST = 129
RC_FAV_SUB_ID_EXIST=130
RC_SYSTEM_ERROR = 200
RC_IMAGE_NULL = 201

AMIN_RC_MAP = {
    "1": RC_SUCCESS,
    "0": RC_FAIL,
    "3": RC_AMOUNT_INCORRECT,
    "4": RC_PRODUCT_NOT_AVAILABLE,
    "6": RC_TRX_DOUBLE,
    "11": RC_INVALID_MSISDN
}

OKB_RC_MAP = {
     1: RC_SUCCESS,
     0: RC_FAIL,
    13: RC_BILLER_ERROR
}

ELOGIC_RC_MAP = {
    "00": RC_SUCCESS,
    "10": RC_INVALID_PARAM,
    "11": RC_INVALID_PARAM,
    "16": RC_BILL_PAID, # temp added by dimas, provide ito dummy data for bill paid scenario on PLN postpaid
    "20": RC_UNAUTHORIZED,
    "21": RC_PENDING,  #dt is too old - temporarily set to pending
    "22": RC_TOO_MANY_REQUEST,
    "31": RC_PRODUCT_NOT_AVAILABLE,
    "32": RC_UNAUTHORIZED,
    "40": RC_FAIL,
    "42": RC_PENDING,
    "43": RC_INVALID_MSISDN,
    "44": RC_PRODUCT_NOT_AVAILABLE,
    "45": RC_NOT_ENOUGH_DEPOSIT,
    "46": RC_MSISDN_NOT_FOUND,
    "47": RC_MSISDN_IN_GRACE_PERIOD,
    "48": RC_BILLER_ERROR,
    "49": RC_MSISDN_BLOCKED,
    "50": RC_MSISDN_EXPIRED,
    "51": RC_BILLER_ERROR,
    "52": RC_MAINTENANCE,
    "53": RC_TRID_NOT_FOUND,
    "61": RC_AMOUNT_INCORRECT,
    "62": RC_INSUFFICIENT_BALANCE_TO_TRANSFER,
    "63": RC_INVALID_AMOUNT,
    "64": RC_BILLER_ERROR,
    "65": RC_TRANSFER_TO_SAME_AGENT,
    "66": RC_BILLER_ERROR,
    "72": RC_PRODUCT_NOT_AVAILABLE,
    "75": RC_INQUIRY_FAIL,
    "80": RC_PENDING,
    "91": RC_AGENT_ALREADY_EXISTS,
    "92": RC_INVALID_UPLINE_ID,
    "101": RC_ACTIVE_TICKET_FOUND,
    "102": RC_BANK_CLOSED,
    "103": RC_NO_ACTIVE_TICKET,
    "104": RC_TICKET_EXPIRED,
    "105": RC_TICKET_PAID_SUCCESSFULLY,
    "106": RC_TICKET_NOT_FOUND,
    "200": RC_BILL_PAID,  # add new rc 200 found when inq pln bill paid
    "205": RC_NO_BILL,
    "210": RC_AMOUNT_INCORRECT
}

RCMSG_ID = {
    RC_FAIL: "Failed",
    RC_SUCCESS: "Success",
    RC_PENDING: "Transaksi anda Pending, jangan khawatir anda akan mendapat notifikasi status transaksi sebentar lagi.",
    RC_INVALID_AMOUNT: "Format pembayaran salah",
    RC_PRODUCT_NOT_AVAILABLE: "Produk tidak tersedia",
    RC_NOT_ENOUGH_DEPOSIT: "Saldo tidak mencukupi",
    RC_TRID_NOT_FOUND: "Transaksi tidak ditemukan",
    RC_UNAUTHORIZED: "Tidak memiliki otorisasi untuk melakukan transaksi",
    RC_INVALID_PARAM: "Parameter salah",
    RC_SETPRICE_ERROR: "Terjadi kesalahan pada setting harga",
    RC_SUBID_NOT_VALID: "ID pelanggan tidak valid",
    RC_SUBID_TEMPORARY_SUSPEND: "ID pelanggan dibekukan sementara",
    RC_BILLER_ERROR: "Terjadi gangguan pada billing",
    RC_MSISDN_BLOCKED: "MSISN dibekukan",
    RC_SUBID_PERMANENT_SUSPEND: "ID pelanggan telah dibekukan",
    RC_BILL_PAID: "Tagihan sudah lunas",
    RC_NO_BILL: "Tidak ada tagihan",
    RC_PAY_REJECTED: "Pembayaran ditolak",
    RC_OUTSTANDING_BILL: "Ada pembayaran tertunggak yang belum dibayarkan",
    RC_UNDEFINED_ERROR: "Error tidak dikenal",
    RC_AMOUNT_INCORRECT: "Jumlah total pembayaran yang dibayarkan tidak sesuai",
    RC_MERCHANT_CODE_UNAVAILABLE: "Nomor agent tidak sesuai",
    RC_BILLER_CODE_UNAVAILABLE: "Kode Biller salah",
    RC_TRX_CANNOT_BE_PROCESSED: "Transaksi tidak bisa diproses",
    RC_INVALID_MSISDN: "MSISDN salah",
    RC_MSISDN_NOT_FOUND: "MSISDN tidak ditemukan",
    RC_MSISDN_IN_GRACE_PERIOD: "MSISDN dalam masa 'Grace Period' ",
    RC_MSISDN_EXPIRED: "MSISDN telah expired",
    RC_INQUIRY_FAIL: "Inquiry gagal",
    RC_INQ_PAY_TOO_LONG: "Timeout ketika inquiry",
    RC_INSUFFICIENT_BALANCE_TO_TRANSFER: "Saldo tidak cukup untuk melakukan transfer",
    RC_TRANSFER_TO_SAME_AGENT: "Tidak diperbolehkan transfer ke agent yang sama",
    RC_WAITING: "Transaksi sedang menunggu konfirmasi status",
    RC_MAINTENANCE: "Sedang ada system maintenance, silahkan coba beberapa saat lagi",
    RC_AGENT_ALREADY_EXISTS: "Pendaftaran agent gagal dikarenakan MSISDN telah terdaftar",
    RC_INVALID_UPLINE_ID: "Pendaftaran agent gagal dikarenakan Upline tidak sah",
    RC_TOO_MANY_REQUEST: "Inquiry diluar batas, silahkan coba beberapa saat lagi",
    RC_ACTIVE_TICKET_FOUND: "Request tiket gagal dikarenakan tiket aktif ditemukan",
    RC_BANK_CLOSED: "Layanan tiket dibuka pukul 06.00 - 21.00",
    RC_NO_ACTIVE_TICKET: "Tiket aktif tidak ditemukan",
    RC_TICKET_EXPIRED: "Tiket expired",
    RC_TICKET_PAID_SUCCESSFULLY: "Pengisian saldo telah berhasil, tiket ditutup",
    RC_TICKET_NOT_FOUND: "Tiket tidak ditemukan",
    RC_OTP_INVALID: "OTP yang anda masukkan salah",
    RC_OTP_EXPIRED: "OTP yang anda masukkan sudah kadaluarsa, silahkan request yang baru",
    RC_TOKEN_AUTH_FAILED: "Autentikasi token gagal",
    RC_TOKEN_ACCESS_EXPIRED: "Akses token kadaluarsa",
    RC_TOKEN_REFRESH_EXPIRED: "Refresh token kadaluarsa",
    RC_MSISDN_EXIST: "No ponsel yang anda masukkan sudah terdaftar",
    RC_EMAIL_EXIST: "Email yang anda masukkan sudah terdaftar",
    RC_SF_NOT_FOUND: "No ponsel sales tidak ditemukan",
    RC_BANK_NOT_AVAILABLE: "bank sedang tidak tersedia",
    RC_DAILY_LIMIT_EXCEEDED: "Total amount telah melampaui batas harian",
    RC_MONTHLY_LIMIT_EXCEEDED: "Total amount telah melampaui batas bulanan",
    RC_OLD_PIN_INVALID: "PIN lama anda tidak sesuai",
    RC_UNKNOWN_ERROR: "Unknown error!",
    RC_NIK_EXIST: "NIK KTP sudah pernah digunakan untuk KYC nabila sebelumnya",
    RC_SYSTEM_ERROR: "Terjadi kesalahan pada system, silahkan hubungi customer support atau sales anda",
    RC_IMAGE_NULL: "Terjadi kesalahan, foto belum diupload atau upload ulang",
    RC_FAV_SUB_ID_EXIST: "Nomor/ID Pelanggan yang anda masukkan sudah terdaftar",
    RC_TRX_DOUBLE: "Pembayaran transaksi anda tidak berhasil, silahkan melakukan transaksi yang sama setelah 5 menit"
}



