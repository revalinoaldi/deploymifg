from const.ck import *
from const.rcval import *
from exceptions.HTTPExceptions import HTTPException
from fastapi import status


class PriceRepo(object):

    def __init__(self, mysql):
        self._conn = mysql

    def prepaid_price(self, opid, cluster_code, msisdn="", exclude=""):
        if cluster_code == 'NOU':
            rows = self._conn.fetch_rows(sql="""select * from prepaid_product
                                                WHERE is_active = 1 AND product_group <> 'TBA'
                                                AND elogic_operator_id=%s""",
                                         values=(opid,), many=True)
        else:
            exc = " AND product_code NOT in ({})".format(exclude[:-1]) if len(exclude) > 0 else ""
            rows = self._conn.fetch_rows(sql="""select * from prepaid_product
                                            WHERE is_active = 1 AND product_group <> 'TBA'
                                            AND elogic_operator_id=%s {}""".format(exc),
                                         values=(opid,), many=True)
        """
        RONALD: Temporary code for TO
        """
        # if msisdn == "082246345877":
        #     if cluster_code == 'NOU':
        #         rows = self._conn.fetch_rows(sql="""select * from prepaid_product
        #                                             WHERE is_active = 1 AND product_group <> 'TBA'
        #                                             AND elogic_operator_id=%s""",
        #                                      values=(opid,), many=True)
        #     else:
        #         exc = " AND product_code NOT in ({})".format(exclude[:-1]) if len(exclude) > 0 else ""
        #         rows = self._conn.fetch_rows(sql="""select * from prepaid_product
        #                                         WHERE is_active = 1 AND product_group <> 'TBA'
        #                                         AND elogic_operator_id=%s {}""".format(exc),
        #                                      values=(opid,), many=True)
        # else:
        #     rows = self._conn.fetch_rows(sql="""select * from prepaid_product
        #                                         WHERE is_active = 1 AND product_group <> 'TBA'
        #                                         AND elogic_operator_id=%s""",
        #                                  values=(opid,), many=True)
        return rows

    def custom_prepaid_price(self, opid, cluster_code, msisdn=""):
        """
        RONALD: Temporary code for TO
        """
        # if msisdn != "082246345877":
        #     rows = []
        # else:
        #     if cluster_code == 'NOU':
        #         rows = []
        #     else:
        #         rows = self._conn.fetch_rows(sql="""select pp.id, pp.product_code, pp.product_name, pp.product_type,
        #                                             pp.product_group, cpp.product_price, pp.denom,
        #                                             pp.is_favourite, pp.is_available, pp.is_new,
        #                                             pp.elogic_operator_id, pp.operator_name
        #                                             from prepaid_product pp
        #                                             inner join prepaid_custom_price cpp on cpp.product_code = pp.product_code
        #                                             where pp.is_active = 1 AND pp.has_custom_price = 1
        #                                             AND pp.elogic_operator_id=%s AND cpp.cluster_code=%s """,
        #                                      values=(opid, cluster_code,), many=True,
        #                                      ck=CK_QUERY_CPP_BY_OPERATORID.format(opid, cluster_code))
        if cluster_code == 'NOU':
            rows = []
        else:
            rows = self._conn.fetch_rows(sql="""select pp.id, pp.product_code, pp.product_name, pp.product_type,
                                                pp.product_group, cpp.product_price, pp.denom,
                                                pp.is_favourite, pp.is_available, pp.is_new,
                                                pp.elogic_operator_id, pp.operator_name
                                                from prepaid_product pp
                                                inner join prepaid_custom_price cpp on cpp.product_code = pp.product_code
                                                where pp.is_active = 1 AND pp.has_custom_price = 1
                                                AND pp.elogic_operator_id=%s AND cpp.cluster_code=%s """,
                                         values=(opid, cluster_code,), many=True)
        return rows


    def product_price(self, tredis, prod_code=None, cluster_code=None, msisdn=None):
        """
        RONALD: Temporary code for TO
        """
        # t = tredis
        # if msisdn == "082246345877":
        #     print("\n\n >>>>>>> TESTER user get price >>>>>>>")
        #     memkey = CK_PRICE.format(prod_code, cluster_code)
        #     price = t.get_cache(memkey)
        #     if not price:
        #         #  find from prepaid_products first, if has custom price is 1 then look at prepaid_custom_price
        #         prc = self._conn.fetch_rows(sql=""" select product_code, product_price, has_custom_price
        #                                         from prepaid_product
        #                                         where product_code = %s and is_active = 1 """,
        #                                     values=(prod_code,))
        #         if prc is None:
        #             self._conn.dispose()
        #             self._conn.closing()
        #             raise HTTPException(status_code=status.HTTP_200_OK, rc=RC_PRODUCT_NOT_AVAILABLE,
        #                                 msg=RCMSG_ID[RC_PRODUCT_NOT_AVAILABLE],
        #                                 data=dict(), headers={"WWW-Authenticate": "Bearer"})
        #         if prc['has_custom_price'] == 0:
        #             cv = prc['has_custom_price'], prc['product_price']
        #             t.set_cache(memkey, cv, 86400)
        #             return cv
        #         elif cluster_code == "NOU":
        #             cv = 0, prc['product_price']
        #             t.set_cache(memkey, cv, 86400)
        #             return cv
        #         else:
        #             prct = self._conn.fetch_rows(sql=""" select cluster_code, product_code, product_price
        #                                             from prepaid_custom_price
        #                                             where product_code = %s and cluster_code = %s and is_active = 1 """,
        #                                         values=(prod_code, cluster_code,))
        #             if prct is None:
        #                 cv = 0, prc['product_price']
        #                 t.set_cache(memkey, cv, 86400)
        #             else:
        #                 cv = 1, prct['product_price']
        #                 t.set_cache(memkey, cv, 86400)
        #             return cv
        #     else:
        #         has_custom_price, product_price = price
        #         return has_custom_price, product_price
        # else:
        #     print("\n\n >>>>>>> other user get price >>>>>>>")
        #     ck = "prodprice_{}".format(prod_code)
        #     price = t.get_cache(ck)
        #     if not price:
        #         prc = self._conn.fetch_rows(sql=""" select product_code, product_price, has_custom_price
        #                                               from prepaid_product
        #                                               where product_code = %s and is_active = 1 """,
        #                                     values=(prod_code,))
        #         cv = 0, prc['product_price']
        #         t.set_cache(ck, cv, 86400)
        #         return cv
        #     else:
        #         has_custom_price, product_price = price
        #         return has_custom_price, product_price

        t = tredis
        memkey = CK_PRICE.format(prod_code, cluster_code)
        price = t.get_cache(memkey)
        if not price:
            #  find from prepaid_products first, if has custom price is 1 then look at prepaid_custom_price
            prc = self._conn.fetch_rows(sql=""" select product_code, product_price, has_custom_price
                                                from prepaid_product
                                                where product_code = %s and is_active = 1 """,
                                        values=(prod_code,))
            if prc is None:
                self._conn.dispose()
                self._conn.closing()
                raise HTTPException(status_code=status.HTTP_200_OK, rc=RC_PRODUCT_NOT_AVAILABLE,
                                    msg=RCMSG_ID[RC_PRODUCT_NOT_AVAILABLE],
                                    data=dict(), headers={"WWW-Authenticate": "Bearer"})
            if prc['has_custom_price'] == 0:
                cv = prc['has_custom_price'], prc['product_price']
                t.set_cache(memkey, cv, 86400)
                return cv
            elif cluster_code == "NOU":
                cv = 0, prc['product_price']
                t.set_cache(memkey, cv, 86400)
                return cv
            else:
                prct = self._conn.fetch_rows(sql=""" select cluster_code, product_code, product_price
                                                    from prepaid_custom_price
                                                    where product_code = %s and cluster_code = %s and is_active = 1 """,
                                             values=(prod_code, cluster_code,))
                if prct is None:
                    cv = 0, prc['product_price']
                    t.set_cache(memkey, cv, 86400)
                else:
                    cv = 1, prct['product_price']
                    t.set_cache(memkey, cv, 86400)
                return cv
        else:
            has_custom_price, product_price = price
            return has_custom_price, product_price
