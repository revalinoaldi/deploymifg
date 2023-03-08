
def bake_prepaid_product(obj, opid, cd=None, cp=None):
    if cp is None:
        cp = []
    if cd is None:
        cd = []
    exclude = ""
    if len(obj) > 0:
        for o in obj:
            if opid in [1, 2, 3, 4, 11]:
                if o['product_type'] == 'D':
                    cdc = {"terlaris": True if o['is_favourite'] == 'True' else False,
                           "terbaru": True if o['is_new'] == 'True' else False,
                           "habis": False if o['is_available'] == 'True' else True,
                           "product_code": o['product_code'], "order": int(o['id']),
                           "product_type": o['product_type'], "product_price": int(o['product_price']),
                           "product_name": o['product_name'], "group": o['product_group']}
                    cd.append(cdc)
                    exclude += "'{}',".format(o['product_code'])
                else:
                    cpc = {"terlaris": True if o['is_favourite'] == 'True' else False,
                           "terbaru": True if o['is_new'] == 'True' else False,
                           "habis": False if o['is_available'] == 'True' else True,
                           "product_code": o['product_code'], "order": int(o['id']),
                           "product_type": o['product_type'], "product_price": int(o['product_price']),
                           "product_name": o['product_name'], "group": o['product_group']}
                    cp.append(cpc)
                    exclude += "'{}',".format(o['product_code'])
            else:
                cpc = {"terlaris": True if o['is_favourite'] == 'True' else False,
                       "terbaru": True if o['is_new'] == 'True' else False,
                       "habis": False if o['is_available'] == 'True' else True,
                       "product_code": o['product_code'], "order": int(o['id']),
                       "product_type": o['product_type'], "product_price": int(o['product_price']),
                       "product_name": o['product_name'], "group": o['product_group']}
                cp.append(cpc)
                exclude += "'{}',".format(o['product_code'])
    ret = {"combo_data": cd, "combo_pulsa": cp, "exclude": exclude}
    return ret
