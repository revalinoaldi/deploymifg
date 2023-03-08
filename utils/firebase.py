from utils import logger
from pyfcm import FCMNotification
from const.appcfg import FCM_KEY

import requests


KS_FCM_SINGLE_NOTIF = "fcm_single_notif"
KS_FCM_MULTIPLE_NOTIF = "fcm_multiple_notif"


class Firebase:
    def __init__(self):
        # self._fcm = FCMNotification(api_key=FCM_KEY, env='ANDROID')
        self._url = 'https://fcm.googleapis.com/fcm/send'
        self._head = dict(Authorization='{}{}'.format('key=',FCM_KEY))

    # def multipleDevicesNotif(self, fcmIdArr, title, msg):
    #     result = None
    #     try:
    #         result = self._fcm.notify_multiple_devices(registration_ids=fcmIdArr, message_title=title,
    #                                                    message_body=msg)
    #     except Exception as e:
    #         logger.loggingError(KS_FCM_MULTIPLE_NOTIF + " " + str(e))
    #     return result
    #
    # def singleDeviceNotifNew(self, fcmId, title, msg):
    #     result = None
    #
    #     data = dict(
    #         id=0,
    #         title=title,
    #         message=msg
    #     )
    #     try:
    #         result = self._fcm.notify_single_device(registration_id=fcmId, data_message=data)
    #         print("RESPONSE FCM NOTIF: ", result)
    #     except Exception as e:
    #         logger.loggingError(KS_FCM_SINGLE_NOTIF + " " + str(e))
    #         return result

    def restDeviceNotif(self, fcmid, title, msg, img=None):
        result = None

        notif = dict(
            body=msg,
            title=title,
            image=img
        )
        param = dict(
            to=fcmid,
            notification=notif
        )
        try:
            result = requests.post(self._url, json=param, headers=self._head)
            print("RESPONSE REST FCM NOTIF: ", result.text)
        except Exception as e:
            logger.loggingError(KS_FCM_SINGLE_NOTIF + " " + str(e))
            return result

