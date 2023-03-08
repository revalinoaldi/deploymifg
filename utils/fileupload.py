import base64
import logging
from datetime import datetime, timedelta
from const.uploads import SOURCE_IMAGE
from const.rcval import *

logger = logging.getLogger('nabila')


class Fileupload:

    @staticmethod
    def padding_byte(data_encoded):
        pad = len(data_encoded) % 4
        data_encoded += b"=" * pad
        return data_encoded

    @staticmethod
    def export_base64_to_file(filename, file_content_str, folder):
        try:
            pathfolder=SOURCE_IMAGE+folder+'/'
            print('pathfolder---------------------', pathfolder)
            filename = f'{filename}.png'
            raw_data = file_content_str.encode()
            encoded_padding_data = Fileupload.padding_byte(raw_data)
            blob = base64.b64decode(encoded_padding_data)
            with open(f'{pathfolder}{filename}', 'w+b') as f:
                f.write(blob)
            return filename
        except Exception as e:
            print(e)
            raise Exception

    @staticmethod
    def export_file_to_base64(filename):
        try:
            with open(f'{SOURCE_IMAGE}{filename}', 'rb') as f:
                blob = base64.b64encode(f.read())
            blob = blob.decode('utf-8')
            return blob
        except Exception as e:
            logger.error(str(e))
            raise Exception

    @staticmethod
    def parsing_photo_base64(enc64):
        try:
            images = enc64.split(',')
            # cek photo jika mengandung data:image/jpeg;base64,
            if len(images) > 1:
                file_photo = images[1]
            else:
                file_photo = images[0]

            return dict(rc=RC_SUCCESS, data=file_photo)
        except Exception as e:
            return dict(rc=RC_SYSTEM_ERROR, data=str(e))
