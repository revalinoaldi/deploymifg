# from utils.sqlpool import Mysql
from utils.misc import *
from utils.misc import current_dt
import json


class PermintaanRepo:

    def __init__(self,  mysql):
        self.__conn = mysql

    def get_spaj(self, spajno):
        row = self.__conn.fetch_rows(
            sql=""" select no_spaj, data_spaj, id, jumlah_bayar_premi, premi_tambahan, paid_status 
                    from form_permintaan where no_spaj =  %s """,
            values=(spajno,), ck='get_spaj-{}'.format(spajno), ttl=30
        )
        # print(row)
        return row

    def count_polis(self, month):
        row = self.__conn.fetch_rows(
            sql=""" select count(id) as num from form_permintaan where date_format(created_date, '%%m') =  %s """,
            values=(month,), ck='get_spaj-{}'.format(month), ttl=1
        )
        # print(row)
        return row['num']

    def update_polis(self, dictset, dictwhere):
        upd = self.__conn.update_rows('form_permintaan', dictset=dictset, dictwhere=dictwhere)
        self.__conn.dispose()
        return upd

    def get_uploaded_file(self, spajno):
        row = self.__conn.fetch_rows(
            sql=""" select upload_ktp, upload_kk, upload_ktp_tertanggung, upload_kk_tertanggung from form_permintaan 
                    where no_spaj =  %s """,
            values=(spajno,), ck='get_ktp-{}'.format(spajno), ttl=30
        )
        # print(row)
        return row