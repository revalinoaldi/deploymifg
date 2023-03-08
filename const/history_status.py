class HistoryStatus:

    MSG_UNPAID = 'Belum Dibayar'
    MSG_PENDING = 'Pending'
    MSG_SUCCESS = 'Sukses'
    MSG_FAILED = 'Gagal'
    MSG_EXPIRE = 'Expire'

    # -1 means not available

    _TRANSACTION_CODE = dict(
        unpaid='-1',
        pending="42', '2",
        success="00', '1",
        fail="42', '00', '1', '2", #This mean not in this code
        expire='-1'
    )

    _TRANSFER_CODE = dict(
        unpaid='-1',
        pending='01',
        success='00',
        fail='40',
        expire='99'
    )

    _TOPUP_CODE = dict(
        unpaid='0',
        pending='99',
        success='105',
        fail='40',
        expire='104'
    )

    _TRANSACTION_MESSAGE = {
        '42':MSG_PENDING,
        '00':MSG_SUCCESS,
        '40':MSG_FAILED,
        '48':MSG_FAILED
    }

    _TRANSACTION_PREPAID_MESSAGE = {
        '2':MSG_PENDING,
        '1':MSG_SUCCESS,
        '0':MSG_FAILED
    }

    _TRANSACTION_MULTIBILLER_MESSAGE = {
        '2':MSG_PENDING,
        '1':MSG_SUCCESS,
        '0':MSG_FAILED
    }

    _TRANSFER_MESSAGE = {
        '01':MSG_PENDING,
        '00':MSG_SUCCESS,
        '40':MSG_FAILED,
        '99':MSG_EXPIRE
    }

    _TOPUP_MESSAGE = {
        '0':MSG_UNPAID,
        '99':MSG_PENDING,
        '105':MSG_SUCCESS,
        '40':MSG_FAILED,
        '104':MSG_EXPIRE
    }

    @classmethod
    def get_status_code(cls):
        return dict(
            transaction=cls._TRANSACTION_CODE,
            transfer=cls._TRANSFER_CODE,
            topup=cls._TOPUP_CODE
        )

    @classmethod
    def get_status_message(cls):
        return dict(
            transaction=cls._TRANSACTION_MESSAGE,
            transaction_prepaid=cls._TRANSACTION_PREPAID_MESSAGE,
            transaction_multibiller=cls._TRANSACTION_MULTIBILLER_MESSAGE,
            transfer=cls._TRANSFER_MESSAGE,
            topup=cls._TOPUP_MESSAGE
        )