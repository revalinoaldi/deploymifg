from utils.sqlpool import Mysql


class TicketRepo:

    def __init__(self, mysql: Mysql):
        self.__mysql = mysql

    def get_ticket(self, msisdn):
        ticket_status = self.__mysql.fetch_rows(
            sql= """
                SELECT 
                    ot.trx_amount,
                    ot.ticket_amount,
                    ot.request_datetime,
                    ot.via_bank
                FROM
                    ot_user ou
                        INNER JOIN
                    ot_user_agent_maping ouam ON ou.id = ouam.user_id
                        INNER JOIN
                    ot_ticket ot ON ot.agent_id = ouam.agent_id
                WHERE 
                    ou.msisdn = %s AND ot.is_closed = 0
            """,
            values=(msisdn,),
            many=False,
            ck="TICKETSTATUS:{}".format(msisdn),
            ttl=10
        )
        return ticket_status

    def get_ticket_amount_this_month(self, agent_id):
        ticket_amount = self.__mysql.fetch_rows(
            sql= """
                SELECT 
                    SUM(trx_amount) sum_amount
                FROM
                    ot_ticket
                WHERE
                    agent_id = %s
                        AND is_closed IN (0 , 105)
                        AND MONTH(request_datetime) = MONTH(CURDATE())
                        AND YEAR(request_datetime) = YEAR(CURDATE())
            """,
            values=(agent_id,),
            many=False,
            ck="TICKETAMOUNTMONTH:{}".format(agent_id),
            ttl=1
        )
        return ticket_amount

    def get_ticket_amount_today(self, agent_id):
        ticket_amount = self.__mysql.fetch_rows(
            sql= """
                SELECT 
                    SUM(trx_amount) sum_amount
                FROM
                    ot_ticket
                WHERE
                    agent_id = %s
                        AND is_closed IN (0 , 105)
                        AND DAY(request_datetime) = DAY(CURDATE())
                        AND MONTH(request_datetime) = MONTH(CURDATE())
                        AND YEAR(request_datetime) = YEAR(CURDATE())
            """,
            values=(agent_id,),
            many=False,
            ck="TICKETAMOUNTDAY:{}".format(agent_id),
            ttl=1
        )
        return ticket_amount

    def insert_ticket(self, data):
        res = self.__mysql.insert_rows('ot_ticket', data)
        return res