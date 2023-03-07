<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */

$data = json_decode(str_replace('""','"',$dataspaj), true);
$this->title = Yii::$app->generalFunction->getSetting('title');
$statusPengajuan = str_replace("CPP ","",$data['resp']['data']['resultList'][0]['statusSPAJ']);
$parts = preg_split('/\s+/', $statusPengajuan);


$premi_tambahan = \yii\helpers\Json::decode($premi_tambahan);
?>

<style type="text/css">
main{
	padding:40px;width:80%;font-size:14px;font-family:'Myriad Pro Regular';font-weight:normal;box-shadow: 0px 4px 16px 3px rgba(0,0,0,0.38);-webkit-box-shadow: 0px 4px 16px 3px rgba(0,0,0,0.38);-moz-box-shadow: 0px 4px 16px 3px rgba(0,0,0,0.38);
}


.row{
	font-size:14px;
	font-family:'Myriad Pro Regular';
	font-weight:normal;
}

#invoice{
    padding: 5px;
	min-width:100%;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 850px;
    padding: 35px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 0px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 30px
}

.invoice .invoice-to {
    text-align: left;
	width: 40%;
}

.logoprint{
	padding-left:30%;
	padding-top:5%;
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: left;
	padding-left:60px;
}

.invoice .invoice-details .invoice-id {
    margin-top: 20px;
    color: #000000
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 5px;

}

.invoice table td,.invoice table th {
    padding: 10px;
    background: #ffffff;
    border-bottom: 1px solid #000000
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #000000;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #000000;
    font-size: 1.6em;
    background: #ffffff
}

.invoice table .unit {
    background: #ffffff
}

.invoice table .total {
    background: #ffffff;
    color: #000000
}

.invoice table tbody tr:last-child{
    border-bottom-left-radius:30px;
}


.invoice table th:first-child {
	border-top-left-radius:30px;
}
.invoice table th:last-child {
	border-top-right-radius:30px;
}


.invoice table tfoot th:first-child {
	border-bottom-left-radius:40px;
	border-top-left-radius:0px;
}
.invoice table tfoot th:last-child {
	border-bottom-right-radius:40px;
	border-top-right-radius:0px;
	// box-shadow: 16px 12px 12px -1px rgba(194,4,9,0.89);
	// -webkit-box-shadow: 16px 12px 12px -1px rgba(194,4,9,0.89);
	// -moz-box-shadow: 16px 12px 12px -1px rgba(194,4,9,0.89);
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}




.toolbar-ekspor{
		display:none;
	}
	
tekscenter{
		width:100%;float:left;margin-top:90px;margin-left:70px;
	}

.baten{
	border: solid black 2px; 
	background-color:white;
	color:black;font-family:'Myriad Pro Regular';font-weight:bold;
	padding:10px 50px 10px 50px;border-radius:10px;
	box-shadow: 16px 12px 12px -1px rgba(194,4,9,0.89);
	-webkit-box-shadow: 16px 12px 12px -1px rgba(194,4,9,0.89);
	-moz-box-shadow: 16px 12px 12px -1px rgba(194,4,9,0.89);
}

.highlighter{
		margin-top:20px;width:700px;height:40px;
		background-color:#ed1c24;color:#ffffff;
		font-size:16px;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;
		margin-bottom:20px;box-shadow: 10px 10px 19px 0px rgba(0,0,0,0.24);
		-webkit-box-shadow: 10px 10px 19px 0px rgba(0,0,0,0.24);-moz-box-shadow: 10px 10px 19px 0px rgba(0,0,0,0.24);
	}

.batas{
		height:60px;
	}
	
.sisikiri{
	float:left;padding-left:40px;width:30%;margin-top:10px;font-size:1.4em;
}	
.sisikanan{
	float:right;padding-left:140px;width:70%;
}
.tengah{
	text-align:left;font-weight:bolder;font-size: 1.2em;
}
.kanan{
	text-align:right;font-weight:bolder;font-size: 1.2em;
}
.noticed{
	position:relative;float:left;margin-left:100px;margin-top:20px;width:80%;height:70px;background-color:#fce8e9;padding-left:20px;padding-top:10px;
}
.notice{
	font-size:13px;font-style:italic;text-align:left;
}
.tertanggung{
	font-size:15px;
	background-color:#fce8e9;
	font-family:'Myriad Pro Bold';
}

.gambarbawah{
	height: 320px;
}
	




	




@media only screen and (max-width: 768px) {
	.toolbar-ekspor{
		border:solid yellow 0px;position:absolute;top:220px;left:165px;z-index:9999;
	}
	
	main{
		padding:5px;width:100%;font-size:9px;font-family:'Myriad Pro Regular';font-weight:normal;box-shadow: 0px 4px 16px 3px rgba(0,0,0,0.38);-webkit-box-shadow: 0px 4px 16px 3px rgba(0,0,0,0.38);-moz-box-shadow: 0px 4px 16px 3px rgba(0,0,0,0.38);
	}
	
	.toolbar-ekspor{
		border:solid red 0px;position:absolute;top:430px;left:300px;z-index:9999;
	}
	
	.invoice-to{
		width: 50%;
		border:solid red 0px;
	}
	
	.invoice-details{
		margin-top:10px;
		width:350px;
		float:left;
		border:solid blue 0px;
		font-size:7px;
	}
	
	tekscenter{
		width:100%;float:center;
	}
	
	
	.baten{
		border: solid black 1px; 
		background-color:white;
		color:black;font-family:'Myriad Pro Regular';
		font-weight:bold;
		font-size:7px;
		padding:3px 3px 3px 3px;border-radius:7px;
		box-shadow: 3px 3px 3px -1px rgba(194,4,9,0.89);
		-webkit-box-shadow: 5px 3px 3px -1px rgba(194,4,9,0.89);
		-moz-box-shadow: 5px 3px 3px -1px rgba(194,4,9,0.89);
	}
	
	.highlighter{
		margin-top:20px;width:220px;height:20px;
		background-color:#ed1c24;color:#ffffff;
		font-size:9px;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;
		margin-bottom:5px;box-shadow: 10px 10px 19px 0px rgba(0,0,0,0.24);
		-webkit-box-shadow: 10px 10px 19px 0px rgba(0,0,0,0.24);-moz-box-shadow: 10px 10px 19px 0px rgba(0,0,0,0.24);
	}
	
	.tekskecil{
		font-size:8px;
	}
	
	.batas{
		height:20px;
	}
	
	
		
	.invoice table {
		width: 100%;
		border-collapse: collapse;
		border-spacing: 0;
		margin-bottom: 5px;

	}

	.invoice table td,.invoice table th {
		padding: 5px;
		background: #ffffff;
		border-bottom: 1px solid #000000
	}

	.invoice table th {
		white-space: nowrap;
		font-weight: 400;
		font-size: 8px
	}

	.invoice table td h3 {
		margin: 0;
		font-weight: 400;
		color: #000000;
		font-size: 1em
	}

	.invoice table .qty,.invoice table .total,.invoice table .unit {
		text-align: right;
		font-size: 1em
	}

	.invoice table .no {
		color: #000000;
		font-size: 1.6em;
		background: #ffffff
	}

	.invoice table .unit {
		background: #ffffff
	}

	.invoice table .total {
		background: #ffffff;
		color: #000000
	}

	.invoice table tbody tr:last-child{
		border-bottom-left-radius:10px;
	}


	.invoice table th:first-child {
		border-top-left-radius:10px;
	}
	.invoice table th:last-child {
		border-top-right-radius:10px;
	}


	.invoice table tfoot th:first-child {
		border-bottom-left-radius:10px;
		border-top-left-radius:0px;
	}
	.invoice table tfoot th:last-child {
		border-bottom-right-radius:10px;
		border-top-right-radius:0px;
	}
	
	.sisikiri{
		float:left;padding-left:40px;width:30%;margin-top:10px;font-size:10px;
	}
	.sisikanan{
		float:right;padding-left:40px;width:70%;
	}
	.tengah{
		text-align:left;font-weight:bolder;font-size: 8px;
	}
	.kanan{
		text-align:right;font-weight:bolder;font-size: 9px;
	}
	.noticed{
		position:relative;float:left;margin-left:40px;margin-top:10px;width:80%;height:50px;background-color:#fce8e9;padding-left:20px;padding-top:5px;font-size:8px;
	}
	.notice{
		font-size:7px;font-style:italic;text-align:left;
	}
	.tertanggung{
		font-size:15px;background-color:#fce8e9;font-family:'Myriad Pro Bold';
	}
	
	.gambarbawah{
		height: 120px;
	}
	
}










@media only screen and (max-width: 400px) {
	.toolbar-ekspor{
		border:solid yellow 0px;position:absolute;top:220px;left:165px;z-index:9999;
	}
	
	main{
		padding:5px;width:100%;font-size:9px;font-family:'Myriad Pro Regular';font-weight:normal;box-shadow: 0px 4px 16px 3px rgba(0,0,0,0.38);-webkit-box-shadow: 0px 4px 16px 3px rgba(0,0,0,0.38);-moz-box-shadow: 0px 4px 16px 3px rgba(0,0,0,0.38);
	}
	
	.toolbar-ekspor{
		border:solid red 0px;position:absolute;top:430px;left:300px;z-index:9999;
	}
	
	.invoice-to{
		border: solid blue 0px;
		width:100px; 
	}
	
	.logoprint{
		padding-left:50px;
		padding-top:20px;
		width:100px;
	}
	
	.invoice-details{
		margin-top:10px;
		width:350px;
		float:left;
		border:solid blue 0px;
		font-size:7px;
	}
	
	tekscenter{
		width:100%;float:center;
	}
	
	
	.baten{
		border: solid black 1px; 
		background-color:white;
		color:black;font-family:'Myriad Pro Regular';
		font-weight:bold;
		font-size:7px;
		padding:3px 3px 3px 3px;border-radius:7px;
		box-shadow: 3px 3px 3px -1px rgba(194,4,9,0.89);
		-webkit-box-shadow: 5px 3px 3px -1px rgba(194,4,9,0.89);
		-moz-box-shadow: 5px 3px 3px -1px rgba(194,4,9,0.89);
	}
	
	.highlighter{
		margin-top:20px;width:220px;height:20px;
		background-color:#ed1c24;color:#ffffff;
		font-size:9px;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;
		margin-bottom:5px;box-shadow: 10px 10px 19px 0px rgba(0,0,0,0.24);
		-webkit-box-shadow: 10px 10px 19px 0px rgba(0,0,0,0.24);-moz-box-shadow: 10px 10px 19px 0px rgba(0,0,0,0.24);
	}
	
	.tekskecil{
		font-size:8px;
	}
	
	.batas{
		height:20px;
	}
	
	
		
	.invoice table {
		width: 100%;
		border-collapse: collapse;
		border-spacing: 0;
		margin-bottom: 5px;

	}

	.invoice table td,.invoice table th {
		padding: 5px;
		background: #ffffff;
		border-bottom: 1px solid #000000
	}

	.invoice table th {
		white-space: nowrap;
		font-weight: 400;
		font-size: 8px
	}

	.invoice table td h3 {
		margin: 0;
		font-weight: 400;
		color: #000000;
		font-size: 1em
	}

	.invoice table .qty,.invoice table .total,.invoice table .unit {
		text-align: right;
		font-size: 1em
	}

	.invoice table .no {
		color: #000000;
		font-size: 1.6em;
		background: #ffffff
	}

	.invoice table .unit {
		background: #ffffff
	}

	.invoice table .total {
		background: #ffffff;
		color: #000000
	}

	.invoice table tbody tr:last-child{
		border-bottom-left-radius:10px;
	}


	.invoice table th:first-child {
		border-top-left-radius:10px;
	}
	.invoice table th:last-child {
		border-top-right-radius:10px;
	}


	.invoice table tfoot th:first-child {
		border-bottom-left-radius:10px;
		border-top-left-radius:0px;
	}
	.invoice table tfoot th:last-child {
		border-bottom-right-radius:10px;
		border-top-right-radius:0px;
	}
	
	.sisikiri{
		float:left;padding-left:40px;width:30%;margin-top:10px;font-size:10px;
	}
	.sisikanan{
		float:right;padding-left:40px;width:70%;
	}
	.tengah{
		text-align:left;font-weight:bolder;font-size: 8px;
	}
	.kanan{
		text-align:right;font-weight:bolder;font-size: 9px;
	}
	.noticed{
		position:relative;float:left;margin-left:40px;margin-top:10px;width:80%;height:50px;background-color:#fce8e9;padding-left:20px;padding-top:5px;font-size:8px;
	}
	.notice{
		font-size:7px;font-style:italic;text-align:left;
	}
	.tertanggung{
		font-size:15px;background-color:#fce8e9;font-family:'Myriad Pro Bold';
	}
	
	.gambarbawah{
		height: 120px;
	}
	
}

</style>


<div class="row">

				
	<div id="invoice">
		
		
		
		<div align="center">
		
				<div class="invoice" >
						<header>
							<div class="row">
								<div class="col company-details" >
									 <div class="col-md-12" style="margin-top:0px;text-align:center;">
										<img src="../images/backgrounds/duologos.png" alt="Image description" width="50%"/>
									</div>
								</div>
							</div>
						</header>
						<main>
							<div class="row contacts">
								<div class="invoice-to">
										<div class="logoprint">
											 <!-- <a href="../print/<?=$id;?>" class='baten'>EXPORT PDF</a> -->
										</div>
								</div>
								<div class="col invoice-details">
									<div style="float:left;position:relative;width:35%;"><b>Nomor SPAJ</b></div>
									<div style="float:left;position:relative;width:5%;">:</div>
									<div style="float:left;position:relative;width:55%;">
									<?=strtoupper($data['resp']['data']['resultList'][0]['nomorSPAJ']);?></b></div>
									<div style="float:left;position:relative;width:35%;"><b>Status Pengajuan</b></div>
									<div style="float:left;position:relative;width:5%;">:</div>
									<div style="float:left;position:relative;width:55%;"><?=strtoupper($parts[0]);?></b></div>
									<div style="float:left;position:relative;width:35%;"><b>Produk Asuransi</b></div>
									<div style="float:left;position:relative;width:5%;">:</div>
									<div style="float:left;position:relative;width:55%;"><?=strtoupper($data['req']['applicationList'][0]['dataAsuransi']['produk']);?></b></div>
									<!--
									<div style="float:left;position:relative;width:35%;"><b>Cara Bayar</b></div>
									<div style="float:left;position:relative;width:5%;">:</div>
									<div style="float:left;position:relative;width:55%;"><?php //echo strtoupper($data['req']['applicationList'][0]['pembayaranPremi']['sumberDana']['periodeBayarPremi']);?></b></div>
									-->
								</div>
							</div>
							
							
							
							<div class="highlighter">A. DATA CALON PEMEGANG POLIS</div>
							
							<div align="center" >
								<div style="width:75%;margin-top:10px;" class="tekskecil">
									<div style="width:100%;float:left;">
										<div style="width:45%;float:left;text-align:left;font-weight:bold;">Nama Lengkap (Sesuai Identitas)</div>
										<div style="width:5%;float:left;">:</div>
										<div style="width:50%;float:left;text-align:left;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['namaLengkap']);?></div>
									</div>
									<!--
									<div style="width:100%;float:left;">
										<div style="width:45%;float:left;text-align:left;font-weight:bold;">Jenis Identitas</div>
										<div style="width:5%;float:left;">:</div>
										<div style="width:50%;float:left;text-align:left;">EKTP</div>
									</div>
									<div style="width:100%;float:left;">
										<div style="width:45%;float:left;text-align:left;font-weight:bold;">Nomor Identitas</div>
										<div style="width:5%;float:left;">:</div>
										<div style="width:50%;float:left;text-align:left;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['nomorKartuIdentitas']);?></div>
									</div>
									<div style="width:100%;float:left;">
										<div style="width:45%;float:left;text-align:left;font-weight:bold;">Tempat & Tanggal Lahir (mm/dd/yyyy)</div>
										<div style="width:5%;float:left;">:</div>
										<div style="width:50%;float:left;text-align:left;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['tempatLahir']);?>, <?=date("d/m/Y", strtotime($data['req']['applicationList'][0]['pemegangPolis']['tanggalLahir']));?></div>
									</div>
									-->
									<div style="width:100%;float:left;">
										<div style="width:45%;float:left;text-align:left;font-weight:bold;">Jenis Kelamin</div>
										<div style="width:5%;float:left;">:</div>
										<div style="width:50%;float:left;text-align:left;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['jenisKelamin']);?></div>
									</div>
									<div style="width:100%;float:left;">
										<div style="width:45%;float:left;text-align:left;font-weight:bold;">Status Perkawinan</div>
										<div style="width:5%;float:left;">:</div>
										<div style="width:50%;float:left;text-align:left;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['statusPerkawinan']);?></div>
									</div>
									<div style="width:100%;float:left;">
										<div style="width:45%;float:left;text-align:left;font-weight:bold;">Alamat Sesuai Identitas</div>
										<div style="width:5%;float:left;">:</div>
										<div style="width:50%;float:left;text-align:justify;">
										<?php
											   echo 
													strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['alamat']). " RT/RW " . 
													strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['RT']). "/" . 
													strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['RW']). ", " . 
													strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kelurahan']). ", " . 
													strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kecamatan']). ", " . 
													strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kota']). ", " . 
													strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['provinsi']). ", " . 
													strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kodePos']);
											   ?>
										</div>
									</div>

									
								</div>
								
								<br/>
							</div>
							
							<div class="batas"></div>
							
							
							
							<br/>
							<table border="1" cellspacing="0" cellpadding="0" style="width:80%;margin-top:30px;">
								<thead>
									<tr>
										<th style="background-color:#ed1c24;color:white;border:solid white 1px;">#</th>
										<th class="text-left" style="background-color:#ed1c24;color:white;border:solid white 1px;">DESKRIPSI</th>
										<th class="text-right" style="background-color:#ed1c24;color:white;border:solid white 1px;">KURS</th>
										<th class="text-right" style="background-color:#ed1c24;color:white;border:solid white 1px;">TOTAL</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="no">01</td>
										<td class="text-left"><h3 style="color:#000000;font-weight:bolder;font-family:'Myriad Pro Bold';">Manfaat Utama</h3>
										   <?php
										   $no = 1;
										   $plan = $data['req']['applicationList'][0]['dataAsuransi']['plan'];
										   $kelas = $data['req']['applicationList'][0]['dataAsuransi']['kelas'];
										   if($plan=='P') $plan = "PLATINUM"; elseif($plan=='G') $plan = "GOLD"; else $plan = "SILVER";
										   if($kelas=='0') $kelas = "VIP"; elseif($kelas=='1') $kelas = "I"; elseif($kelas=='2') $kelas = "II"; else $kelas = "III";
										   echo "<b>". strtoupper($plan . " " . $kelas) . "</b>";
											if($premi_tambahan['nominal_extra']>0){
											echo "<br/><i>+".$premi_tambahan['remark_extra']."</i>";
											}
										   ?>
										   
										</td>
										<td class="unit">IDR</td>
										<td class="total"><?=number_format($premi_tambahan['total_tarif']-(
										$premi_tambahan['nominal_extra']+$premi_tambahan['nominal_kematian']+$premi_tambahan['nominal_extra_kematian']+$premi_tambahan['nominal_inap']+$premi_tambahan['nominal_extra_inap']
										),0,",",".");
										if($premi_tambahan['nominal_extra']>0){
											echo "<br/>".number_format($premi_tambahan['nominal_extra'],0,",",".");
											}
										?>
										</td>
									</tr>
									
									
									
									<?php
									if($premi_tambahan['nominal_kematian']>0){
									$no++;
									?>
									<tr>
										<td class="no"><?=sprintf("%02d",$no);?></td>
										<td class="text-left"><h3 style="color:#000000;font-weight:bolder;font-family:'Myriad Pro Bold';">Manfaat Tambahan</h3>
										   <i><?=$premi_tambahan['remark_kematian'];?></i>
										   
										   <?php
											if($premi_tambahan['nominal_extra_kematian']>0){
											?>
											<br/>
											<i>+<?=$premi_tambahan['remark_extra_kematian'];?></i>
											<?php } ?>
										</td>
										<td class="unit">IDR</td>
										<td class="total">
											<?=number_format($premi_tambahan['nominal_kematian'],0,",",".");?>
											<?php
											if($premi_tambahan['nominal_extra_kematian']>0){
											?>
											<br/>
											<?=number_format($premi_tambahan['nominal_extra_kematian'],0,",",".");?>
											<?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<?php
									if($premi_tambahan['nominal_inap']>0){
									$no++;
									?>
									<tr>
										<td class="no"><?=sprintf("%02d",$no);?></td>
										<td class="text-left"><h3 style="color:#000000;font-weight:bolder;font-family:'Myriad Pro Bold';">Manfaat Tambahan</h3>
										   <i><?=$premi_tambahan['remark_inap'];?></i>
										   
										   <?php
											if($premi_tambahan['nominal_extra_inap']>0){
											?>
											<br/>
											<i>+<?=$premi_tambahan['remark_extra_inap'];?></i>
											<?php } ?>
										</td>
										<td class="unit">IDR</td>
										<td class="total">
											<?=number_format($premi_tambahan['nominal_inap'],0,",",".");?>
											<?php
											if($premi_tambahan['nominal_extra_inap']>0){
											?>
											<br/>
											<?=number_format($premi_tambahan['nominal_extra_inap'],0,",",".");?>
											<?php } ?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
								<tfoot>
									<tr>
										<th style="background-color:#ed1c24;color:white;border:solid white 1px;"></th>
										<th class="text-left" style="background-color:#ed1c24;color:white;border:solid white 1px;"></th>
										<th class="text-right" style="background-color:#ed1c24;color:white;border:solid white 1px;"></th>
										<th class="text-right" style="background-color:#ed1c24;color:white;border:solid white 1px;"></th>
									</tr>
								</tfoot>
								</table>
								
								
								<div class="sisikiri">Terima Kasih!</div>
								
								<div class="sisikanan">
									<table border="0" cellspacing="0" cellpadding="0" style="width:60%;">
										<tfoot>
											<tr>
												<td colspan="2"></td>
												<td colspan="1" class="tengah">TOTAL PREMI</td>
												<td class="kanan"><?=number_format($premi_tambahan['total_tarif'],0,",",".");?></td>
											</tr>
											<tr>
												<td colspan="2"></td>
												<td colspan="1" class="tengah">BIAYA CETAK</td>
												<td class="kanan">
												<?php
												if($data['req']['applicationList'][0]['pencetakanPolis']===true)$pencetakanPolis="150000";else $pencetakanPolis="0";
												echo number_format($pencetakanPolis,0,",",".");
												?></td>
											</tr>
											<tr>
												<td colspan="2"></td>
												<td colspan="1" class="tengah">GRAND TOTAL</td>
												<td class="kanan"><?=number_format($premi_tambahan['total_tarif']+$pencetakanPolis,0,",",".");?></td>
											</tr>
										</tfoot>
									</table>
								</div>
								
							
							
							<div align="center">
								<div class="noticed" >
									<div  style="text-align:left;width:100%;"><b>Catatan</b>: </div>
									<div class="notice"> Anda harus melakukan pembayaran dalam batas waktu yang ditentukan untuk menyelesaikan pengajuan Anda. Batas waktu pembayaran max 1x24 jam</div>
								</div>
							</div>
							
							
							
							<div style="width:100%;height:20px;">&nbsp;</div>
							<div class="clearfix"></div>

							<div class="highlighter">B. INFORMASI PIHAK YANG DIASURANSIKAN</div>
							
							
							<table border="1" cellspacing="0" cellpadding="0" style="width:80%;border:solid 3px white;">
									<tr>
										<th style="background-color:#ed1c24;color:white;border:solid white 1px;">#</th>
										<th class="text-left" style="background-color:#ed1c24;color:white;border:solid white 1px;width:80%">&nbsp;</th>
									</tr>
								<tbody>
									
								
									<tr>
										<td  style="background-color:#fce8e9;font-family:'Myriad Pro Bold';" valign="top">TERTANGGUNG</td>
										<td class="text-left" style="background-color:#fce8e9;">
											<h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Nama Lengkap</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['namaLengkap']);?></i>
										   
											<h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Tempat Lahir</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['tempatLahir']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Tanggal Lahir</h3>
										   <i><?=date("d/m/Y", strtotime($data['req']['applicationList'][0]['tertanggung']['tanggalLahir']));?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Jenis Kelamin</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['jenisKelamin']);?></i>
										   
										   <!--
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Status Perkawinan</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['statusPerkawinan']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">No Kartu Identitas</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['nomorKartuIdentitas']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Handphone</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['handphone']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Email</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['email']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Alamat Sesuai Identitas</h3>
										   <i><?php
										   echo 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['alamat']). " RT/RW " . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['RT']). "/" . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['RW']). ", " . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kelurahan']). ", " . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kecamatan']). ", " . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kota']). ", " . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['provinsi']). ", " . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kodePos']);
										   ?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Alamat Domisili</h3>
										   <i><?php
										   echo 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['alamat']). " RT/RW " . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['RT']). "/" . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['RW']). ", " . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['kelurahan']). ", " . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['kecamatan']). ", " . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['kota']). ", " . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['provinsi']). ", " . 
												strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['kodePos']);
										   ?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Pekerjaan</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['pekerjaan']['pekerjaan']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Nama Institusi Tempat Kerja</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['pekerjaan']['namaInstitusiTempatKerja']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Telepon Institusi Tempat Kerja</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['pekerjaan']['telepon']);?></i>
										   -->
										   
										</td>
										
									</tr>
									
									<!--
									<tr>
										<td class="no" style="font-size:15px;background-color:#fce8e9;border-top:solid white 2px;font-family:'Myriad Pro Bold';" valign="top">PEMEGANG POLIS</td>
										<td class="text-left" style="background-color:#fce8e9;color:black;border-top:solid white 2px;">
											<h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Nama Lengkap</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['namaLengkap']);?></i>
										   
											<h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Tempat Lahir</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['tempatLahir']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Tanggal Lahir</h3>
										   <i><?=date("d/m/Y", strtotime($data['req']['applicationList'][0]['pemegangPolis']['tanggalLahir']));?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Jenis Kelamin</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['jenisKelamin']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Status Perkawinan</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['statusPerkawinan']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">No Kartu Identitas</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['nomorKartuIdentitas']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Handphone</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['handphone']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Email</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['email']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Alamat Sesuai Identitas</h3>
										   <i><?php
										   echo 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['alamat']). " RT/RW " . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['RT']). "/" . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['RW']). ", " . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kelurahan']). ", " . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kecamatan']). ", " . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kota']). ", " . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['provinsi']). ", " . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kodePos']);
										   ?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Alamat Domisili</h3>
										   <i><?php
										   echo 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['alamat']). " RT/RW " . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['RT']). "/" . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['RW']). ", " . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['kelurahan']). ", " . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['kecamatan']). ", " . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['kota']). ", " . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['provinsi']). ", " . 
												strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['kodePos']);
										   ?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Pekerjaan</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['pekerjaan']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Nama Institusi Tempat Kerja</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['namaInstitusiTempatKerja']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Telepon Institusi Tempat Kerja</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['telepon']);?></i>
										   
										   
										</td>
										
									</tr>
									
									
									<?php if(count($data['req']['applicationList'][0]['penerimaManfaat']) > 0) { ?>
									<tr>
										<td class="no" style="font-size:15px;background-color:#fce8e9;color:black;border-top:solid white 2px;font-family:'Myriad Pro Bold';" valign="top">PENERIMA MANFAAT</td>
										<td class="text-left" style="background-color:#fce8e9;border-top:solid white 2px;">
										<?php 
										for($no=0; $no<count($data['req']['applicationList'][0]['penerimaManfaat']); $no++){ ?>
										<div style="float:left;position:relative;width:30%;">
											<h3 style="font-weight:bolder;font-size:20px;color:#E27100;">#<?=$no+1;?></h3>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Nama Lengkap</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['namaLengkap']);?></i>
										   
											<h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">NIK</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['nomorIndukKependudukan']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Tanggal Lahir</h3>
										   <i><?=date("d/m/Y", strtotime($data['req']['applicationList'][0]['penerimaManfaat'][$no]['tanggalLahir']));?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Jenis Kelamin</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['jenisKelamin']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Jenis Kelamin</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['hubungan']);?></i>
										   
										   <h3 style="font-weight:bolder;font-family:'Myriad Pro Bold';">Persentase</h3>
										   <i><?=strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['persentase']);?></i>
										</div>
											
										<?php } ?>
											
										   
										</td>
										
									</tr>
									<?php } ?>
									
									
									
									-->
									
								</tbody>
								
							</table>
							
							
							<br/>
							
							<div align="center">
								<div style="float:center;position:relative;width:70%;font-family:'Myriad Pro Bold';">
									
									<div class="tekscenter" style="width:50%;float:left;margin-top:30px;">
										<a href="/scan" class='baten' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ajukan Lagi!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
									</div>
								
								<div class="tekscenter" style="width:50%;float:left;margin-top:30px;">
			                        <a href="<?=$doku;?>" class='baten' >Informasi Pembayaran</a>
			                    </div>
								
								</div>
							</div>
							
							<div style="height:60px;"></div>
							
						</main>
						<footer>
							<!--Invoice was created on a computer and is valid without the signature and seal.-->
						</footer>
					</div>
					<!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
					<div></div>
					
					
					
					
				</div>
		</div>
		
		
	</div>
</div>

<div class="bg-bottom" style="float:left;position:relative;">
	<img src="../images/backgrounds/batikbl.png" class="gambarbawah" style=" position: absolute;bottom: 0px;left: 0px; z-index: 20;">
</div>


<?php
$url_pdf = \yii\helpers\Url::to(['print']);
?>
<script>
 $('#printInvoice').click(function(){
            //Popup($('.invoice')[0].outerHTML);
            function Popup(data) 
            {
                window.print();
                return true;
            }
        });
		
 $('#pdfInvoice').click(function(){
            //Popup($('.invoice')[0].outerHTML);
            location.href = <?php echo $url_pdf;?>;
        });
</script>
