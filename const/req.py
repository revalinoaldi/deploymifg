from collections import namedtuple


"""
Request Tuple
"""
PrepaidReq = namedtuple('PrepaidReq', """subscriber_id agent_id agent_name agent_msisdn agent_key longitude latitude ptype pay reg_id admin_fee price is_custom""")
PrepaidReq.__new__.__defaults__ = (None,)


PostpaidReq = namedtuple('PostpaidReq', 'subscriber_id agent_id agent_name agent_msisdn agent_key longitude latitude ptype pay reg_id')
PostpaidReq.__new__.__defaults__ = (None,)


R_BILLER = namedtuple('R_BILLER', 'customer_no customer_name blth ref_no bill penalty admin total_payment')
R_BILLER.__new__.__defaults__ = (None,)

R_PREPAID = namedtuple('R_PREPAID', 'customer_no customer_name ref_no bill admin total_payment')
R_PREPAID.__new__.__defaults__ = (None,)