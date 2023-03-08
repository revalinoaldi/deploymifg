

class BasePayment(object):

    def __init__(self, req):
        self._req = req
        self._rc = 1
        self._msg = ''
        self._prodlist = []
        self._reqbody = dict()
        self._cartid = ''
        self._data = ''
        self._products = ''
        self._supporderid = ''
        self._nestorderid = ''

    """
    Class Property contains variables to be overridden in child class
    """
    @property
    def rc(self):
        return self._rc

    @property
    def msg(self):
        return self._msg

    @property
    def prodlist(self):
        return self._prodlist

    @property
    def reqbody(self):
        return self._reqbody

    @property
    def cartid(self):
        return self._cartid

    @property
    def data(self):
        return self._data

    @property
    def products(self):
        return self._products

    @property
    def supporderid(self):
        return self._supporderid

    @property
    def nestorderid(self):
        return self._nestorderid

    """
    Interfaces
    """
    def save_product_feed(self):
        pass

    def get_product_detail(self):
        pass

    def check_product_availabilty(self):
        pass

    def create_order(self):
        pass

    def track_order(self):
        pass

    def checkout(self):
        pass

    def create_order(self):
        pass

    """
    Standardize API Response
    """
    def save_feed_response(self):
        return dict(rc=self.rc, msg=self.msg)

    def product_detail_response(self):
        return dict(rc=self.rc, msg=self.msg, data=self.data)

    def checkout_response(self):
        return dict(rc=self.rc, msg=self.msg, cartid=self.cartid, products=self.products)

    def submit_order_response(self):
        return dict(rc=self.rc, msg=self.msg, supporderid=self.supporderid, nestorderid=self.nestorderid, products=self.products)

    def product_feed_response(self):
        return dict(rc=self.rc, msg=self.msg, products=self.products)

    def order_status_response(self):
        return dict(rc=self.rc, msg=self.msg, data=self.data)
