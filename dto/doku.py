from pydantic import BaseModel, Field
from typing import Optional, List


class Items(BaseModel):
    name: str = Field(..., example="Asuransi")
    price: str = Field(..., example="30000")
    qty: str = Field(..., example="1")


class Customer(BaseModel):
    custid: str = Field(..., example="CUST-0001")
    name: str = Field(..., example="Anton Budiman")
    email: str = Field(..., example="anton@example.com")
    phone: str = Field(..., example="6285694566147")
    address: str = Field(..., example="Menara Mulia Lantai 8")


class Payment(BaseModel):
    payment_due_date: int = Field(..., example=60)


class ReqPayment(BaseModel):
    invoice_no: str
    total_amount: str
    customer: Customer
    line_items: List[Items] = []
    paytype: str
    payvendor: str
    bank: Optional[str] = None


class Checkout(BaseModel):
    invoice_no: str = Field(..., example="spaj/10202/1010")
    total_amount: str = Field(..., example="300000")
    payment: Payment
    customer: Customer
    line_items: List[str] = []
    paytype: Optional[str] = None
    payvendor: str = Field(..., example="Doku")
    bank: Optional[str] = None


class NotifId(BaseModel):
    id: str


class NotifTransaction(BaseModel):
    status: str
    date: str
    original_request_id: str


class NotifOrder(BaseModel):
    invoice_number: str
    amount: int


class NotifVaInfo(BaseModel):
    virtual_account_number: str


class Identifier(BaseModel):
    name: str
    value: str


class NotifIdentifier(BaseModel):
    identifier: List[Identifier] = []


class NotifVa(BaseModel):
    service: NotifId
    acquirer: NotifId
    channel: NotifId
    transaction: NotifTransaction
    order: NotifOrder
    virtual_account_info: NotifVaInfo
    virtual_account_payment: NotifIdentifier


class CardToken(BaseModel):
    token: str


class CardNotif(BaseModel):
    masked_card_number: str
    approval_code: str
    response_code: str
    response_message: str


class NotifCc(BaseModel):
    service: NotifId
    acquirer: NotifId
    channel: NotifId
    transaction: NotifTransaction
    order: NotifOrder
    # card: CardToken
    card_payment: CardNotif


