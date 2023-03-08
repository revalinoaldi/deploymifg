# from utils.smtp import SMTP
from const.appcfg import *
from datetime import datetime
from utils.misc import *
import requests
import os


class EmailHelper(object):

    def email_agent(self, agentno, link, emailto, nospaj, head):
        alias = 'noreply@ifg-life.id'
        email_subject = "IFG AGENT CLOSING STATEMENT"
        email_content = """
                <div style="width: 100%;display: block;position: relative;padding: 20px;">
                <div style="width:50%;float: left;text-align: left;">
                    <img src="https://registration.ifg-life.id/images/logo/logo.png" width="120">
                </div>
                <div style="width:50%;float: right;text-align: right;">
                    <img src="https://www.inhealth.co.id/assets/collections/logo/large/logo.jpg" width="100">
                </div>
                <div class="content">
                    <br><br>
                    <h3 style="margin-top: 50px;">{}</h3>
                    
            
            by Mandiri Inhealth & IFG Life<br>
            Produk Asuransi Bersama<br>
            MIFG My Managed Care<br><br><br>
            
            Kepada Yth. Bapak/Ibu Agen Hebat ({})<br><br>
            
            Surat Permohonan Asuransi Jiwa (SPAJ) No : {} memenuhi kriteria untuk dapat dilakukan proses selanjutnya.<br><br>
            
            Mohon segera mengisi Surat Pernyataan Agen Penutup melalui tautan berikut :<br><br>
            
            {}<br><br>
            
            Salam,<br>
            MIFG<br>
            
            
                </div>
                
            </div>
            <div style="width:50%;float: left;text-align: left;background: #f68d91;">
                    <p style="color: #fff;padding-left: 20px;">www.ifg-life.id</p>
                </div>
                <div style="width:50%;float: right;text-align: right;background: #809eb6;">
                    <p style="color: #fff;padding-right: 20px;">www.mandiriinhealth.co.id</p>
                </div>
                """.format(nospaj, agentno, nospaj, link)
        r = requests.post(IFG_SEND_EMAIL, json=dict(from_alias=alias, to=emailto, subject=email_subject, body=email_content, type='html'),
                          headers=head)
        print(r.text)
        # smtp = SMTP(subject=email_subject, receiver=emailto, content=email_content)
        # smtp.send_mail()

    def email_payment_notif(self, name, address, premi, nospaj, emailto, link, additionalpremi, head):
        dt = datetime.now().strftime('%d %B %Y')
        alias = 'noreply@ifg-life.id'
        email_subject = "IFG PAYMENT NOTIFICATION"
        email_content = """
                <div style="width: 100%;display: block;position: relative;padding: 20px;">
                <div style="width:50%;float: left;text-align: left;">
                    <img src="https://registration.ifg-life.id/images/logo/logo.png" width="120">
                </div>
                <div style="width:50%;float: right;text-align: right;">
                    <img src="https://www.inhealth.co.id/assets/collections/logo/large/logo.jpg" width="100">
                </div>
                <div class="content">
                    <br><br>
                    <h3 style="margin-top: 50px;">{}</h3>
                    <br><br>
                    <p>Jakarta, {}</p><br><br>
                    <p>
                    Kepada Yth.<br>
                    Bapak/Ibu {}<br>
                    {}<br>
                    {}<br>
                    {}
                    </p>
            
                    <br><br>
                    <p>Terimakasih telah memilih MIFG My Managed Care untuk memenuhi kebutuhan perlindungan Kesehatan Bapak/Ibu</p>
                    <table style="width: 100%">
                        <tr>
                            <td>No SPAJ</td><td> : </td><td>{}</td>
                            <td>Pemegang Polis</td><td>	: </td><td>{}</td>
                        </tr>
                        <tr>
                            <td>Periode Pembayaran</td><td>	: </td><td>{}</td>
                            <td>Tertanggung</td><td>	: </td><td>{}</td>
                        </tr>
                        <tr>
                            <td>Pertanggungan Dasar</td><td>	: </td><td>{}</td>
                            <td>Pembayar Premi</td><td>	: </td><td>{}</td>
                        </tr>
                        <tr>
                            <td>Pertanggungan Tambahan</td><td>	: </td><td>{}</td>
                        </tr>
                    </table>
                        <br>
                        <br>
                    <p>Silahkan melakukan pembayaran melalui link di bawah ini: </p><br>
                    {}
                    <br><br>
            
            Permohonan akan otomatis dibatalkan apabila Anda tidak melakukan pembayaran sampai batas yang ditentukan.<br><br>
            
            Untuk pertanyaan dan bantuan, hubungi tim Contact Center kami melalui nomor Hotline 14072<br><br>
            
                    </p>
                
                    <p>
                        Terimakasih atas kepercayaan kepada Mandiri Inhealth dan IFG Life untuk perlindungan Bapak/Ibu.<br><br>
            
            Salam hormat,<br>
            
            MIFG
            
            
                    </p>
            
                </div>
                
            </div>
            <div style="width:50%;float: left;text-align: left;background: #f68d91;">
                    <p style="color: #fff;padding-left: 20px;">www.ifg-life.id</p>
                </div>
                <div style="width:50%;float: right;text-align: right;background: #809eb6;">
                    <p style="color: #fff;padding-right: 20px;">www.mandiriinhealth.co.id</p>
                </div>
                """.format(nospaj, dt, capital_name(name['pemegangPolis']), capital_name(address['alamat']), capital_name(address['kota']), address['kodePos'], nospaj
                           , capital_name(name['pemegangPolis']), premi['periodeBayarPremi'], capital_name(name['tertanggung']), premi['plan'],
                           capital_name(name['pemegangPolis']), additionalpremi, link)
        r = requests.post(IFG_SEND_EMAIL, json=dict(from_alias=alias, to=emailto, subject=email_subject, body=email_content, type='html'),
                          headers=head)
        print(r.text)

    def email_payment_confirm(self, name, amount, bank, emailto, head):
        alias = 'noreply@ifg-life.id'
        email_subject = "EMAIL KONFIRMASI PEMBAYARAN"
        email_content = """
                <html>
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                </head>

                <body>
                    <p>Bapak/Ibu {} yang terhormat</p></br>
                    <p>Terima kasih atas kepercayaan dan kesetiaan Anda menjadikan MIFG My Managed Care</p>
                    <p>sebagai mitra dalam melindungi Anda dan keluarga.</p>
                    
                    <p>Pembayaran Premi Anda sebesar Rp.{} melalui {} </p>
                    <p>telah kami terima dan dengan demikian perlindungan Kesehatan Anda telah dimulai.</p>
                    
                    <p>Apabila Bapak/Ibu membutuhkan informasi lebih lanjut sehubungan dengan produk, Polis, 
                    prosedur klaim atau ingin melakukan koreksi atau penambahan informasi silahkan menghubungi 
                    Customer Service Mandiri Inhealth melalui Telepon: 14072 atau 
                    Email: customerservice@inhealth.co.id</p></br></br>
                    
                    <p>Salam hormat,</p></br></br>
                    
                    <p>MIFG My Managed Care</p>
                </body>
                </html>
                """.format(capital_name(name), amount, bank)
        r = requests.post(IFG_SEND_EMAIL,
                          json=dict(from_alias=alias, to=emailto, subject=email_subject, body=email_content, type='html'),
                          headers=head)
        print(r.text)

    def email_reject(self, agentno, cppname, emailto, nospaj, head):
        alias = 'noreply@ifg-life.id'
        email_subject = "EMAIL NOTIFIKASI PENOLAKAN CPP"
        email_content = """
                <div style="width: 100%;display: block;position: relative;padding: 20px;">
                <div style="width:50%;float: left;text-align: left;">
                    <img src="https://registration.ifg-life.id/images/logo/logo.png" width="120">
                </div>
                <div style="width:50%;float: right;text-align: right;">
                    <img src="https://www.inhealth.co.id/assets/collections/logo/large/logo.jpg" width="100">
                </div>
                <div class="content">
                    <br><br>
                    <h3 style="margin-top: 50px;">{}</h3>


            by Mandiri Inhealth & IFG Life<br>
            Produk Asuransi Bersama<br>
            MIFG My Managed Care<br><br><br>

            Kepada Yth. Bapak/Ibu Agen Hebat ({})<br><br>

            Surat Permohonan Asuransi Jiwa (SPAJ) No : {} atas nama {} tidak memenuhi kriteria untuk dapat dilakukan proses selanjutnya.<br><br>

            Salam,<br>
            MIFG<br>


                </div>

            </div>
            <div style="width:50%;float: left;text-align: left;background: #f68d91;">
                    <p style="color: #fff;padding-left: 20px;">www.ifg-life.id</p>
                </div>
                <div style="width:50%;float: right;text-align: right;background: #809eb6;">
                    <p style="color: #fff;padding-right: 20px;">www.mandiriinhealth.co.id</p>
                </div>
                """.format(nospaj, agentno, nospaj, capital_name(cppname))
        r = requests.post(IFG_SEND_EMAIL,
                          json=dict(from_alias=alias, to=emailto, subject=email_subject, body=email_content,
                                    type='html'),
                          headers=head)
        print(r.text)

    def email_pelunasan_agent(self, agentno, cppname, emailto, nospaj, amt, head):
        alias = 'noreply@ifg-life.id'
        email_subject = "EMAIL NOTIFIKASI PELUNASAN CPP"
        email_content = """
                <div style="width: 100%;display: block;position: relative;padding: 20px;">
                <div style="width:50%;float: left;text-align: left;">
                    <img src="https://registration.ifg-life.id/images/logo/logo.png" width="120">
                </div>
                <div style="width:50%;float: right;text-align: right;">
                    <img src="https://www.inhealth.co.id/assets/collections/logo/large/logo.jpg" width="100">
                </div>
                <div class="content">
                    <br><br>
                    <h3 style="margin-top: 50px;">{}</h3>


            by Mandiri Inhealth & IFG Life<br>
            Produk Asuransi Bersama<br>
            MIFG My Managed Care<br><br><br>

            Kepada Yth. Bapak/Ibu Agen Hebat ({})<br><br>

            Pelunasan Premi Surat Permohonan Asuransi Jiwa (SPAJ) No : {} atas nama {} sebesar Rp. {} telah kami terima dan pertanggungan telah aktif.<br><br>

            Salam,<br>
            MIFG<br>


                </div>

            </div>
            <div style="width:50%;float: left;text-align: left;background: #f68d91;">
                    <p style="color: #fff;padding-left: 20px;">www.ifg-life.id</p>
                </div>
                <div style="width:50%;float: right;text-align: right;background: #809eb6;">
                    <p style="color: #fff;padding-right: 20px;">www.mandiriinhealth.co.id</p>
                </div>
                """.format(nospaj, agentno, nospaj, capital_name(cppname), amt)
        r = requests.post(IFG_SEND_EMAIL,
                          json=dict(from_alias=alias, to=emailto, subject=email_subject, body=email_content,
                                    type='html'),
                          headers=head)
        print(r.text)
