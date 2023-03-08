from vendors.base import BasePayment


class Payment(BasePayment):

    def request_payment(self):
        req = self._req
        print('-----------', req.invoice_no)
