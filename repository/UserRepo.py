from dto.authreg import *
from utils.sqlpool import Mysql
from utils.misc import *
from utils.misc import current_dt
import json


class UserRepo:

    def __init__(self, mysql: Mysql=None):
        self.__mysql = mysql

    def get_user(self, msisdn, uuid, mysql):
        row = mysql.fetch_rows(
            sql=""" SELECT ot.uname, ot.uemail, ot.msisdn,  ot.pin_trx, 
                    IF(ot.is_blocked=1, 1, 0) as is_blocked, 
                    otm.cvs_code, otm.cluster_code, otm.`user_level`, otm.kyc_level, 
                    IFNULL(otb.`admin_verified`,0) as `admin_verified`,
                    IFNULL(otb.max_plafond,0) as plafond, otb.business_name, '' as version_code, otb.`remarks_update`
                    FROM ot_user ot  
                    INNER JOIN ot_user_agent_maping otm on ot.id = otm.user_id  
                    LEFT JOIN ot_borrower otb ON ot.`msisdn` = otb.`msisdn` and  otb.app_type = 'nabila'
                    LEFT JOIN ot_cluster otc ON otm.`cluster_code` = otc.`cluster_code`
                    WHERE ot.msisdn = %s AND ot.uuid = %s """,
            values=(msisdn, uuid,), ck='{}-{}'.format('usr', msisdn), ttl=10
        )
        if row is not None and row['remarks_update'] != '' and row['remarks_update'] is not None:
            row['remarks_update'] = json.dumps(row['remarks_update'].split('#'))
        return row

    def get_agent(self, msisdn, mysql):
        row = mysql.fetch_rows(
            sql=""" select u.`msisdn`, m.`agent_id` from ot_user u
                    inner join `ot_user_agent_maping` m on u.`id` = m.`user_id`
                    where u.msisdn = %s """,
            values=(msisdn,), ck='get_agent-{}-{}'.format('user', msisdn), ttl=30
        )
        print(row)
        return row

    def get_user_data_transfer_inq(self, msisdn, mysql):
        row = mysql.fetch_rows(
            sql=""" select u.`msisdn`, m.`agent_id`,u.`uname`  from ot_user u
                    inner join `ot_user_agent_maping` m on u.`id` = m.`user_id`
                    where u.msisdn = %s """,
            values=(msisdn,), ck='get_agent-{}-{}'.format('user', msisdn), ttl=30
        )
        print(row)
        return row

    def validate_user_data(self, data = None, val = None, mysql = None):
        cond = None

        if data == 'msisdn':
            cond = " AND ot.msisdn = %s "
            val = (val,)
        elif data == 'email':
            cond = " AND ot.uemail = %s "
            val = (val,)
        elif data == 'pin_trx':
            cond = " AND ot.pin_trx = %s AND ot.msisdn = %s "
            val = val

        row = mysql.fetch_rows(
            sql=""" SELECT ot.uname, ot.uemail, ot.msisdn,  ot.pin_trx,
                    IF(ot.is_blocked=1, 1, 0) as is_blocked,
                    otm.cvs_code, otm.cluster_code, otm.`user_level`, otm.kyc_level, 
                    IFNULL(otb.`admin_verified`,0) as `admin_verified`, 
                    IFNULL(otb.max_plafond,0) as plafond, otb.business_name, '' as version_code, otb.`remarks_update`
                    FROM ot_user ot  
                    INNER JOIN ot_user_agent_maping otm on ot.id = otm.user_id  
                    LEFT JOIN ot_borrower otb ON ot.`msisdn` = otb.`msisdn` and  otb.app_type = 'nabila'
                    LEFT JOIN ot_cluster otc ON otm.`cluster_code` = otc.`cluster_code`
                    WHERE ot.is_verified=1  """ + cond,
            values=val, ck='{}-{}'.format('validate', val), ttl=30
        )

        if row is not None and row['remarks_update'] != '' and row['remarks_update'] is not None:
            row['remarks_update'] = json.dumps(row['remarks_update'].split('#'))

        return row

    def update_otp(self, otp, msisdn, mysql):
        upd = mysql.update_rows('ot_user', dictset=dict(verification_code=otp), dictwhere=dict(msisdn=msisdn))
        mysql.dispose()
        return upd

    def update_pin(self, pin, msisdn, mysql):
        upd = mysql.update_rows('ot_user', dictset=dict(pin_trx=pin), dictwhere=dict(msisdn=msisdn))
        mysql.dispose()
        return upd

    def update_uuid(self, uuid, msisdn, mysql):
        upd = mysql.update_rows('ot_user', dictset=dict(uuid=uuid), dictwhere=dict(msisdn=msisdn))
        mysql.dispose()
        return upd

    def new_user(self, reguser, mysql):
        reg = UserReg(**reguser)

        param = dict(
            msisdn=reg.msisdn,
            uuid=reg.uuid,
            uname=reg.name,
            uemail=reg.email,
            pin_trx=reg.pin,
            created_date=current_dt(),
            is_blocked=0,
            is_verified=1
        )
        nu = mysql.insert_rows('ot_user', param=param)
        return nu

    def new_agent_mapping(self, userid, agentid, agentkey, sfcode, clustercode, apptype, mysql):
        param = dict(
            user_id=userid,
            agent_id=agentid,
            agent_key=agentkey,
            app_type=apptype,
            cvs_code=sfcode,
            cluster_code=clustercode,
            user_level=3
        )
        nam = mysql.insert_rows('ot_user_agent_maping', param=param)

        return nam

    def get_user_data_transfer(self, msisdn, mysql):
        row = mysql.fetch_rows(
        """
            SELECT 
                ou.uname, agent_id, is_blocked, is_verified, app_type, gcm_device_id
            FROM
                ot_user ou
                    INNER JOIN
                ot_user_agent_maping ouam ON ou.id = ouam.user_id
            WHERE
                ou.msisdn = %s 
        """, (msisdn,), ck=f"USERDATATRANSFER:{msisdn}", ttl=300)
        return row

    def get_user_data_ticket_topup(self, msisdn, mysql):
        row = mysql.fetch_rows(
        """
            SELECT 
                ouam.agent_id, ouam.kyc_level, ouam.app_type
            FROM
                ot_user ou
                    INNER JOIN
                ot_user_agent_maping ouam ON ou.id = ouam.user_id
            WHERE
                ou.msisdn = %s
        """, (msisdn,), ck=f"USERDATATICKETTOPUP:{msisdn}", ttl=10)
        return row

    def add_favorite(self, subscriber_id, name, type, agent_id):
        res = self.__mysql.insert_rows('favorite', {
            'type': type,
            'subscriber_id': subscriber_id,
            'name': name,
            'agent_id': agent_id,
            'is_deleted': 0
        })
        return res

    def get_favorite(self, type, agent_id):
        res = self.__mysql.fetch_rows(
            sql="""
                SELECT name, subscriber_id FROM favorite WHERE agent_id = %s AND type = %s AND is_deleted = 0
            """,
            values=(agent_id, type),
            many=True,
            ck='GET_FAVORITE:{}:{}'.format(agent_id, type),
            ttl=1
        )
        return res

    def get_favorite_specific_data(self, subscriber_id, type, agent_id):
        res = self.__mysql.fetch_rows(
            sql="""
                SELECT name, subscriber_id, type FROM favorite WHERE agent_id = %s AND type = %s AND subscriber_id = %s AND is_deleted = 0
            """,
            values=(agent_id, type, subscriber_id,),
            many=False,
            ck='GET_FAVORITE_SPECIFIC:{}:{}'.format(agent_id, type),
            ttl=1
        )
        return res

    def delete_favorite(self, subscriber_id, name, type, agent_id):
        res = self.__mysql.update_rows(
            tbl='favorite',
            dictset={
                "is_deleted": 1
            },
            dictwhere={
                "subscriber_id": subscriber_id,
                "name": name,
                "type": type,
                "agent_id": agent_id
            }
        )
        return res

    def update_fcm(self, msisdn, fcmid, platform, mysql):
        upd = mysql.update_rows('ot_user', dictset=dict(gcm_device_id=fcmid, device_platform=platform), dictwhere=dict(msisdn=msisdn))
        mysql.dispose()
        return upd

    def get_fcm(self, msisdn, mysql):
        self.__mysql = mysql
        row = self.__mysql.fetch_rows(
            sql=""" select u.`msisdn`, m.`agent_id`, u.`gcm_device_id` from ot_user u
                    left join `ot_user_agent_maping` m on u.`id` = m.`user_id`
                    where u.msisdn = %s """,
            values=(msisdn,), ck='get_gcm-{}-{}'.format('user', msisdn), ttl=30
        )
        print(row)
        return row

