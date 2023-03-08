import email
import mimetypes
import smtplib
from email import encoders
from email.mime.base import MIMEBase
from typing import Any
from const.appcfg import EMAIL_ACCOUNT, EMAIL_PASSWORD, SMTP_SERVER


class SMTP:

    def __init__(self, subject: str, receiver: str, content: Any, sender: str = 'nabila@narindo.com', content_type: str = 'text/html'):
        self._msg = email.message.Message()
        self._subject = subject
        self._sender = sender
        if isinstance(receiver, str):
            self._receiver = receiver
        elif isinstance(receiver, list):
            self._receiver = receiver
        self._content = content
        self.__initialize_email_message(content_type)

    def __initialize_email_message(self, content_type: str = 'text/html', attachment=None):
        self._msg.add_header('Content-Type', content_type)
        self._msg.set_payload(self._content)
        self._msg['From'] = self._sender
        self._msg['To'] = self._receiver
        self._msg['Subject'] = self._subject
        if attachment:
            self.set_attachment(attachment)

    def _connect_email_server(self):
        conn = smtplib.SMTP_SSL(SMTP_SERVER, SMTP_PORT)
        conn.starttls()
        conn.login(EMAIL_ACCOUNT, EMAIL_PASSWORD)
        return conn

    def send_mail(self):
        email_conn = self._connect_email_server()
        email_conn.sendmail(EMAIL_ACCOUNT, self._receiver, self._msg.as_string())
        return

    def set_attachment(self, attachment):
        if attachment and attachment != '':
            ctype, encoding = mimetypes.guess_type(attachment)
            maintype, subtype = ctype.split('/', 1)
            with open(attachment, 'rb') as zf:
                payload = MIMEBase(maintype, subtype)
                payload.set_payload(zf.read())
            encoders.encode_base64(payload)
            payload.add_header('Content-Disposition', 'attachment', filename=attachment)
            self._msg.attach(payload)
