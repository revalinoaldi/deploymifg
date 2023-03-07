<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */

$this->title = Yii::$app->generalFunction->getSetting('title');
?>
<style type="text/css">
.baten{
	border: solid black 2px; 
	background-color:white;
	color:black;font-family:'Myriad Pro Regular';font-weight:bold;
	padding:10px 50px 10px 50px;border-radius:10px;
	box-shadow: 16px 12px 12px -1px rgba(194,4,9,0.89);
	-webkit-box-shadow: 16px 12px 12px -1px rgba(194,4,9,0.89);
	-moz-box-shadow: 16px 12px 12px -1px rgba(194,4,9,0.89);
}

@media only screen and (max-width: 768px) {
.baten{
		border: solid black 1px; 
		background-color:white;
		color:black;font-family:'Myriad Pro Regular';
		font-weight:bold;
		font-size:11px;
		padding:5px 5px 5px 5px;border-radius:7px;
		box-shadow: 3px 3px 3px -1px rgba(194,4,9,0.89);
		-webkit-box-shadow: 5px 3px 3px -1px rgba(194,4,9,0.89);
		-moz-box-shadow: 5px 3px 3px -1px rgba(194,4,9,0.89);
	}
}
</style>
<div class="row" align="center">
	<div class="col-md-12" style="margin-top:20px;">
		<img class="duologo" src="images/backgrounds/duologos.png" itemprop="thumbnail" alt="Image description" />
	</div>
	<div class="col-md-12" style="margin-top:50px;">
		    <div class="card border-grey border-lighten-2 kontenn" itemscope style="border:solid blue 0px;padding-bottom:40px;">
		                    <a href="/scan">
		                        <img class="gallery-thumbnail card-img-top" src="images/backgrounds/life-hdr.jpg" itemprop="thumbnail" alt="Image description" />
		                    </a>
		                    <div class="card-body px-0 image-grid-product">
		                        <h4 class="card-title" style="font-family:'Myriad Pro Bold';font-weight:normal;font-size:22px;padding-left:40px;"><img src="./images/logo/mifg1.png" height="80"></h4>
								<div style="width:15%;float:left;">
									<img src="images/backgrounds/ulliojk.png"  style="padding-left:60px;"/>
								</div>
								<div style="width:85%;float:left;padding-top:5px;padding-bottom:30px;">
									<p class="card-text">
										<ul style="font-family:'Myriad Pro Regular';font-weight:normal;font-size:16px;padding-right:40px;text-align: justify;">
											<li style="margin-top:10px;">PT Asuransi Jiwa inhealth Indonesia dan PT Asuransi Jiwa IFG terdaftar dan diawasi oleh Otoritas Jasa Keuangan. Produk ini telah mendapat otorisasi dari Otoritas Jasa Keuangan.</li>
											<li style="margin-top:10px;">Produk Asuransi Kesehatan individu dirancang untuk masyarakat Indonesia (yang dinilai telah memenuhi syarat eligible oleh Penanggung) yang membutuhkan jaminan layanan kesehatan yang menyeluruh/komprehensif meliputi Promotif, Preventif, Kuratif dan Rehabilitatif.</li>
											<li style="margin-top:5px;">Usia masuk tertanggung 5-55 Tahun.</li>
											<li style="margin-top:10px;">Pilihan cara pembayaran Tahunan/Semesteran sesuai pilihan pada awal pertanggungan.</li>
											<li style="margin-top:15px;">Tersedia dalam Plan Platinum dengan pilihan kelas: VIP dan Kelas I</li>
										</ul>
									</p>
								</div>
								
		                        <div align="center" style="margin-top:50px;">
									<div class="text-center" class="baten" style="width:50%;float:center;margin-top:50px;">
			                        <a href="/scan" class="baten">AJUKAN SEKARANG</a>
									</div>
								</div>
								
								
								<div align="center">
									<div style="float:left;border:solid red 0px;width:100%;margin-top:35px;font-size:16px;">
										<div style="text-align:center;font-family:'Myriad Pro Regular'">Silakan Membaca</div>
										<div style="text-align:center;font-family:'Myriad Pro Regular'">
											 <a href="images/riplay.pdf"  target="_blank" style="color:#3399FF;">Ringkasan Informasi dan Layanan Produk Asuransi</a>
										</div>
										<div style="margin-top:20px;text-align:center;font-family:'Myriad Pro Regular'">
											 <a href="images/Booklet-MIFG-My-Managed-Care.pdf"  target="_blank" style="color:#3399FF;">Brosur Produk</a>
										</div>
									</div>
								</div>
		                        <!--
		                        <div class="text-center" style="width:50%;float:left;margin-top:30px;">
			                        <a href="images/riplay.pdf"  target="_blank" style="border: solid black 2px; 
									background-color:white;
									color:black;font-family:'Myriad Pro Regular';font-weight:bold;
									padding:10px 50px 10px 50px;border-radius:10px;
									box-shadow: 16px 12px 12px -1px rgba(194,4,9,0.89);
									-webkit-box-shadow: 16px 12px 12px -1px rgba(194,4,9,0.89);
									-moz-box-shadow: 16px 12px 12px -1px rgba(194,4,9,0.89);">INFORMASI PRODUK</a>
			                    </div>
								-->
		                    </div>
		                </div>
	</div>
	<div class="col-md-4"></div>
	<div class="col-md-4"></div>
</div>
