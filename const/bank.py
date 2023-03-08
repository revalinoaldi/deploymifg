NARINDO_BANK = {
    'bca': '0652706868',
    'mandiri': '1250029886868',
    'sinarmas': '0053155715',
    'bni': '8996868689'
}

BANK_FEE = {
    'va-bca': 2750,
    'bca': 0,
    'mandiri': 0,
    'sinarmas': 0,
    'bni': 0
}

BANK_NAME = {
    'va-bca': 'BCA',
    'bca': 'Bank BCA',
    'mandiri': 'Bank Mandiri',
    'sinarmas': 'Bank Sinarmas',
    'bni': 'Bank BNI'
}

BANK_OWNER_NAME = {
    'va-bca': '',
    'bca': 'PT. NARINDO SOLUSI TELEKOMUNIKASI',
    'mandiri': 'PT. NARINDO SOLUSI TELEKOMUNIKASI',
    'sinarmas': 'PT. NARINDO SOLUSI TELEKOMUNIKASI',
    'bni': 'PT. NARINDO SOLUSI TELEKOMUNIKASI'
}

BASE = "https://api.nabila.app.narindo.com/nstel/v1/{}"
BANK_IMAGE = {
    'va-bca': BASE.format('media/images/logo/bank/BCA.svg'),
    'bca': BASE.format('media/images/logo/bank/BCA.svg'),
    'mandiri': BASE.format('media/images/logo/bank/Mandiri.svg'),
    'sinarmas': BASE.format('media/images/logo/bank/Sinarmas.svg'),
    'bni': BASE.format('media/images/logo/bank/BNI.svg')
}

BANK_OPEN = {
    'bca': {
        'open_hour': 8,
        'open_minute': 00,
        'close_hour': 20,
        'close_minute': 50
    },
    'mandiri': {
        'open_hour': 8,
        'open_minute': 00,
        'close_hour': 21,
        'close_minute': 20
    },
    'sinarmas': {
        'open_hour': 8,
        'open_minute': 00,
        'close_hour': 20,
        'close_minute': 50
    },
    'bni': {
        'open_hour': 8,
        'open_minute': 00,
        'close_hour': 20,
        'close_minute': 50
    }
}

VA_PREFIX = {
    'va-bca': '12375',
}


VA_BANK = ['va-bca']
AVAILABLE_BANK = ['bca', 'mandiri', 'sinarmas', 'bni']
TROUBLE_BANK = []

""" EMONEY LIST AND LOGO """
# AVAILABLE_EMONEY = ['mandiri', 'bri', 'bni', 'dki']
AVAILABLE_EMONEY = ['mandiri', 'bni']

EMONEY_IMAGE = {
    # 'bri': BASE.format('media/images/logo/emoney/brizzi.svg'),
    # 'dki': BASE.format('media/images/logo/emoney/jakcard.svg'),
    'mandiri': BASE.format('media/images/logo/emoney/e-money.png'),
    'bni': BASE.format('media/images/logo/emoney/tapcash.png')
}

EMONEY_NAME = {
    # 'bri': 'BRI BRIZZI',
    # 'dki': 'Bank DKI Jakcard',
    'mandiri': 'Mandiri E-Money',
    'bni': 'BNI Tap Cash'
}

EMONEY_OPERATOR_ID = {
    'mandiri': '31',
    'bni': '32',
    # 'bri': '33',
    # 'dki': '34'
}