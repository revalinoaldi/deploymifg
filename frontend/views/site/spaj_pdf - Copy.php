<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */

$sql_spaj = "SELECT * FROM form_permintaan WHERE id = '".$_GET['id']."'";
$data_spaj = Yii::$app->db->createCommand($sql_spaj)->queryOne();
$dataspaj =  $data_spaj['api_response'];
$doku = $data_spaj['doku'];
$premi_tambahan = $data_spaj['premi_tambahan'];
// var_dump($dataspaj);die;	
$data = json_decode(str_replace('""','"',$dataspaj), true);
// var_dump($data);die;
$this->title = Yii::$app->generalFunction->getSetting('title');
// var_dump($data['resp']['data']['resultList'][0]['statusPengajuan']);
$statusPengajuan = str_replace("CPP ","",$data['resp']['data']['resultList'][0]['statusPengajuan']);
$parts = preg_split('/\s+/', $statusPengajuan);


$premi_tambahan = \yii\helpers\Json::decode($premi_tambahan);
?>



<div class="row">
	<div id="invoice">
		
		
		<div class="invoice overflow-auto">
			<div style="min-width: 880px">
					<div class="row">
						<div class="col company-details" >
							<img src="./images/logo/logo.png">
							<div style="color:#8D0000"><b>Kantor Pusat</b></div>
							<div>Graha CIMB Niaga Lt. 21, Jl. Jend. Sudirman Kav 58 Jakarta – 12190</div>
							<div>Telp: &#9742; 1500 176 | Email: asuransi@ifg-life.id</div>
						</div>
					<hr>
					</div>
				<main>
					<div class="row contacts">

						<div class="col invoice-details">
							<div style="width:700px;float:left;height:30px;margin-top:5px;font-weight:bold;">DATA CALON PEMEGANG POLIS</div>
						
						
							<div style="width:120px;float:left;">Nomor SPAJ</div>
							<div  style="float:left;width:580px;"><b>: <?=strtoupper($data['resp']['data']['resultList'][0]['nomorSPAJ']);?></b></div>
							
							<div style="width:120px;float:left;">Pemegang Polis</div>
							<div style="width:580px;float:left;"><b>: <?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['namaLengkap']);?></b></div>
							
							<div style="width:120px;float:left;">Alamat</div>
							<div style="width:580px;float:left;">: <b>
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
								?></b>
							</div>
							
							<div class="date" style="width:120px;float:left;">Email</div> 
							<div style="width:580px;float:left;">: <b><?=$data['req']['applicationList'][0]['pemegangPolis']['email'];?></b></div>
							
							<div class="date" style="width:120px;float:left;">Status Pengajuan</div> 
							<div style="width:580px;float:left;">: <b><?=strtoupper($parts[0]);?></b></div>
							
							<div class="date" style="width:120px;float:left;">Produk Asuransi</div>
							<div style="width:580px;float:left;">: <b><?=strtoupper($data['req']['applicationList'][0]['dataAsuransi']['produk']);?></b></div>
							
							<div class="date" style="width:120px;float:left;">Cara Bayar</div>
							<div style="width:580px;float:left;">: <b><?=strtoupper($data['req']['applicationList'][0]['pembayaranPremi']['sumberDana']['periodeBayarPremi']);?></b></div>
						</div>
					</div>
					
					
					<h2 class="to" style="text-transform:none;font-size:15px;font-weight:bold;">RINGKASAN MANFAAT DAN PENGAJUAN ASURANSI</h2>
					<table border="0" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th style="background-color:#989898;color:white;border:solid white 1px;float:left;width:80px;">#</th>
								<th class="text-left" style="background-color:#989898;color:white;border:solid white 1px;float:left;width:320px;">DESKRIPSI</th>
								<th class="text-left" style="background-color:#989898;color:white;border:solid white 1px;float:left;width:200px;">KURS</th>
								<th class="text-right" style="background-color:#989898;color:white;border:solid white 1px;float:left;width:100px;">TOTAL</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="no">01</td>
								<td class="text-left"><h4 style="color:#8D0000;font-weight:bolder;">Manfaat Utama</h4>
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
								<td class="total text-right"><?=number_format($premi_tambahan['total_tarif']-(
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
								<td class="text-left"><h4 style="color:#006A91;font-weight:bolder;">Manfaat Tambahan</h4>
								   <i><?=$premi_tambahan['remark_kematian'];?></i>
								   
								   <?php
									if($premi_tambahan['nominal_extra_kematian']>0){
									?>
									<br/>
									<i>+<?=$premi_tambahan['remark_extra_kematian'];?></i>
									<?php } ?>
								</td>
								<td class="unit">IDR</td>
								<td class="total text-right">
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
								<td class="text-left"><h4 style="color:#4F7964;font-weight:bolder;">Manfaat Tambahan</h4>
								   <i><?=$premi_tambahan['remark_inap'];?></i>
								   <?php
									if($premi_tambahan['nominal_extra_inap']>0){
									?>
									<br/>
									<i>+<?=$premi_tambahan['remark_extra_inap'];?></i>
									<?php } ?>
								</td>
								<td class="unit">IDR</td>
								<td class="total text-right">
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
								<td colspan="2"></td>
								<td colspan="1">TOTAL PREMI</td>
								<td class="text-right"><?=number_format($premi_tambahan['total_tarif'],0,",",".");?></td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td colspan="1">BIAYA CETAK</td>
								<td class="text-right">
								<?php
								if($data['req']['applicationList'][0]['pencetakanPolis']===true)$pencetakanPolis="150000";else $pencetakanPolis="0";
								echo number_format($pencetakanPolis,0,",",".");
								?></td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td colspan="1">GRAND TOTAL</td>
								<td class="text-right"><?=number_format($premi_tambahan['total_tarif']+$pencetakanPolis,0,",",".");?></td>
							</tr>
						</tfoot>
					</table>
					<div class="notices">
						<div>Catatan:</div>
						<div class="notice" style="font-size:13px;font-style:italic;"> Anda harus melakukan pembayaran dalam batas waktu yang ditentukan untuk menyelesaikan pengajuan Anda. Batas waktu pembayaran max 1x24 jam</div>
					</div>
					
					
					
					<hr>
					
										
					
					
					<div class="col invoice-details">
						<div style="width:800px;float:left;height:30px;margin-top:5px;font-weight:bold;">DATA CALON TERTANGGUNG</div>

						<div style="width:200px;float:left;">Nama Lengkap</div>
						<div  style="float:left;width:450px;"><b>: &nbsp;<?=strtoupper($data['req']['applicationList'][0]['tertanggung']['namaLengkap']);?></b></div>
						
						<div style="width:200px;float:left;">Tempat Lahir</div>
						<div  style="float:left;width:450px;"><b>: &nbsp;<?=strtoupper($data['req']['applicationList'][0]['tertanggung']['tempatLahir']);?></b></div>
						
						<div style="width:200px;float:left;">Tanggal Lahir</div>
						<div  style="float:left;width:450px;"><b>: &nbsp;<?=date("d/m/Y", strtotime($data['req']['applicationList'][0]['tertanggung']['tanggalLahir']));?></b></div>
						
						<div style="width:200px;float:left;">Jenis Kelamin</div>
						<div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['tertanggung']['jenisKelamin']);?></div>
								   
					   <div style="width:200px;float:left;">Status Perkawinan</div>
					   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['tertanggung']['statusPerkawinan']);?></div>
					   
					   <div style="width:200px;float:left;">No Kartu Identitas</div>
					   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['tertanggung']['nomorKartuIdentitas']);?></div>
					   
					   <div style="width:200px;float:left;">Handphone</div>
					   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['tertanggung']['handphone']);?></div>
					   
					   <div style="width:200px;float:left;">Email</div>
					   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['tertanggung']['email']);?></div>
					   
					   <div style="width:200px;float:left;">Alamat Sesuai Identitas</div>
					   <div  style="float:left;width:450px;"><b>:&nbsp;<?php
					   echo 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['alamat']). " RT/RW " . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['RT']). "/" . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['RW']). ", " . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kelurahan']). ", " . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kecamatan']). ", " . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kota']). ", " . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['provinsi']). ", " . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kodePos']);
					   ?></div>
					   
					   <div style="width:200px;float:left;">Alamat Domisili</div>
					   <div  style="float:left;width:450px;"><b>:&nbsp;<?php
					   echo 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['alamat']). " RT/RW " . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['RT']). "/" . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['RW']). ", " . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['kelurahan']). ", " . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['kecamatan']). ", " . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['kota']). ", " . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['provinsi']). ", " . 
							strtoupper($data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['kodePos']);
					   ?></div>
						   
					   <div style="width:200px;float:left;">Pekerjaan</div>
					   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['tertanggung']['pekerjaan']['pekerjaan']);?></div>
					   
					   <div style="width:200px;float:left;">Nama Institusi Tempat Kerja</div>
					   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['tertanggung']['pekerjaan']['namaInstitusiTempatKerja']);?></div>
					   
					   <div style="width:200px;float:left;">Telepon Institusi Tempat Kerja</div>
					   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['tertanggung']['pekerjaan']['telepon']);?></div>
					
					</div>
					
					<hr>
					
					<div class="col invoice-details">
					<div style="width:800px;float:left;height:30px;margin-top:5px;font-weight:bold;">PEMEGANG POLIS</div>
					
							<div style="width:200px;float:left;">Nama Lengkap</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['namaLengkap']);?></div>
						   
							<div style="width:200px;float:left;">Tempat Lahir</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['tempatLahir']);?></div>
						   
						   <div style="width:200px;float:left;">Tanggal Lahir</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?=date("d/m/Y", strtotime($data['req']['applicationList'][0]['pemegangPolis']['tanggalLahir']));?></div>
						   
						   <div style="width:200px;float:left;">Jenis Kelamin</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['jenisKelamin']);?></div>
						   
						   <div style="width:200px;float:left;">Status Perkawinan</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['statusPerkawinan']);?></div>
						   
						   <div style="width:200px;float:left;">No Kartu Identitas</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['nomorKartuIdentitas']);?></div>
						   
						   <div style="width:200px;float:left;">Handphone</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['handphone']);?></div>
						   
						   <div style="width:200px;float:left;">Email</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['email']);?></div>
						   
						   <div style="width:200px;float:left;">Alamat Sesuai Identitas</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?php
						   echo 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['alamat']). " RT/RW " . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['RT']). "/" . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['RW']). ", " . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kelurahan']). ", " . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kecamatan']). ", " . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kota']). ", " . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['provinsi']). ", " . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kodePos']);
						   ?></div>
						   
						   <div style="width:200px;float:left;">Alamat Domisili</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?php
						   echo 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['alamat']). " RT/RW " . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['RT']). "/" . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['RW']). ", " . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['kelurahan']). ", " . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['kecamatan']). ", " . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['kota']). ", " . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['provinsi']). ", " . 
								strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['kodePos']);
						   ?></div>
						   
						   <div style="width:200px;float:left;">Pekerjaan</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['pekerjaan']);?></div>
						   
						   <div style="width:200px;float:left;">Nama Institusi Tempat Kerja</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['namaInstitusiTempatKerja']);?></div>
						   
						   <div style="width:200px;float:left;">Telepon Institusi Tempat Kerja</div>
						   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['telepon']);?></div>
						   
					</div>
							
					<hr>
					
					<?php if(count($data['req']['applicationList'][0]['penerimaManfaat']) > 0) { ?>
					<div class="col invoice-details">
						<div style="width:800px;float:left;height:30px;margin-top:5px;font-weight:bold;">PENERIMA MANFAAT</div>
								<?php 
								for($no=0; $no<count($data['req']['applicationList'][0]['penerimaManfaat']); $no++){ ?>
									<div style="color:#006A91;font-weight:bolder;font-size:20px;color:#E27100;float:left;width:700px;margin-top:15px;">#<?=$no+1;?></div>
								   
								   <div style="width:200px;float:left;">Nama Lengkap</div>
								   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['namaLengkap']);?></div>
								   
									<div style="width:200px;float:left;">NIK</div>
								   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['nomorIndukKependudukan']);?></div>
								   
								   <div style="width:200px;float:left;">Tanggal Lahir</div>
								   <div  style="float:left;width:450px;"><b>:&nbsp;<?=date("d/m/Y", strtotime($data['req']['applicationList'][0]['penerimaManfaat'][$no]['tanggalLahir']));?></div>
								   
								   <div style="width:200px;float:left;">Jenis Kelamin</div>
								   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['jenisKelamin']);?></div>
								   
								   <div style="width:200px;float:left;">Jenis Kelamin</div>
								   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['hubungan']);?></div>
								   
								   <div style="width:200px;float:left;">Persentase</div>
								   <div  style="float:left;width:450px;"><b>:&nbsp;<?=strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['persentase']);?></div>
									
								<?php } ?>
									
								   
								</div>
								
							<?php } ?>
							
							
							
							
							
						</tbody>
						
					
				</main>
				<footer>
					<!--Invoice was created on a computer and is valid without the signature and seal.-->
				</footer>
			</div>
			<!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
			<div>
			</div>
		
			
		</div>
	</div>
</div>
