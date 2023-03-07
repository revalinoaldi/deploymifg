<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */

$sql_spaj = "SELECT * FROM form_permintaan WHERE id = '".$id."'";
$data_spaj = Yii::$app->db->createCommand($sql_spaj)->queryOne();
$dataspaj =  $data_spaj['api_response'];
$datakesehatan =  $data_spaj['rumus_response'];
$doku = $data_spaj['doku'];
$premi_tambahan = $data_spaj['premi_tambahan'];
// var_dump($dataspaj);die;	
$data = json_decode(str_replace('""','"',$dataspaj), true);
// var_dump($data);die;
$this->title = Yii::$app->generalFunction->getSetting('title');
// var_dump($data['resp']['data']['resultList'][0]['statusPengajuan']);
$statusPengajuan = str_replace("CPP ","",$data['resp']['data']['resultList'][0]['statusSPAJ']);
$parts = preg_split('/\s+/', $statusPengajuan);


$premi_tambahan = \yii\helpers\Json::decode($premi_tambahan);

// if($data['req']['applicationList'][0]['kesehatanTertanggung'][2]['idPernyataan']=='L00003')
// echo $data['req']['applicationList'][0]['kesehatanTertanggung'][2]['textValue'][0];

function caripos($idPernyataan, $data)
{
	if($data!=null){
		$id = array_search($idPernyataan, array_column($data, 'idPernyataan'));
		return $data[$id]['textValue'][0];
	}return false;
}




// echo $id;


?>

<div class="row">
		<div class="invoice overflow-auto">
			<div style="min-width: 880px">
					&nbsp;
				<div style="margin-top:100px;width:880px;height:25px;background-color:#ffb500;color:#003b70;font-size:14pt;text-align:center;padding-top:5px;padding-bottom:5px;"><b>SURAT PERMOHONAN ASURANSI JIWA/ KESEHATAN</b></div>
				<main>
					<div class="row contacts">
					
						<div class="col company-details" style="float:center;width:800px;padding-top:20px;text-align:center;">
							<img src="./images/logo/mifg.png" height="130">
						</div>
						
						<div class="col company-details" style="font-family:'Myriad Pro Regular';font-size:8pt;color:#003b70;float:center;padding-left:30px;width:750px;padding-top:20px;text-align:left;height:20px;">
							1. Produk Asuransi ini merupakan Produk Asuransi Bersama antara PT Asuransi Jiwa Inhealth Indonesia & PT Asuransi Jiwa IFG, yang &nbsp;&nbsp;&nbsp;&nbsp;selanjutnya akan disebut sebagai Penanggung.
						</div>
						<div class="col company-details" style="font-family:'Myriad Pro Regular';font-size:8pt;color:#003b70;float:center;padding-left:30px;width:750px;padding-top:0px;text-align:left;height:20px;">
							2. Produk yang dipasarkan oleh Penanggung diawasi dan telah mendapatkan otorisasi dari Otoritas Jasa Keuangan.
						</div>
						<div class="col company-details" style="font-family:'Myriad Pro Regular';font-size:8pt;color:#003b70;float:center;padding-left:30px;width:750px;padding-top:0px;text-align:left;height:20px;">
							3. Mohon diisi secara akurat, jujur, jelas dan lengkap. 
						</div>
						<div class="col company-details" style="font-family:'Myriad Pro Regular';font-size:8pt;color:#003b70;float:center;padding-left:40px;width:750px;padding-top:0px;text-align:left;height:20px;">
							<b>KETIDAKLENGKAPAN PENGISIAN eSPAJ DAPAT MENYEBABKAN TERHAMBATNYA PROSES PENERBITAN POLIS.</b>
						</div>
						
						<div style="margin-top:20px;width:880px;height:15px;background-color:#003b70;color:#ffffff;font-size:8pt;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;"><b>A. DATA CALON PEMEGANG POLIS</b></div>
						
						<table style="width:880px;font-size:10pt;">
							<tr>
								<td width="280px" style="padding-top:10px;">1. Nama Lengkap (Sesuai Kartu Identitas)</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['namaLengkap']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:10px;">2. Jenis Kartu Identitas</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['jenisKartuIdentitas']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:10px;">3. Nomor Kartu Identitas</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['nomorKartuIdentitas']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:10px;">4. Tempat & Tanggal Lahir (tgl/bln/thn)</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['tempatLahir']) . ", " . date("d/m/Y", strtotime($data['req']['applicationList'][0]['pemegangPolis']['tanggalLahir']));?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:10px;">5. Jenis Kelamin</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['jenisKelamin']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:10px;">6. Status Perkawinan</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['statusPerkawinan']);?></td>
							</tr>
							<tr>
								<td width="280px" valign="top" style="padding-top:10px;">7. Alamat Sesuai Kartu Identitas</td>
								<td width="10px"  valign="top" style="padding-top:10px;">:</td>
								<td width="550px"  valign="top" style="padding-top:10px;">
								
											<?php 
												echo strtoupper(
												$data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['alamat'].
												"<br/> RT " . $data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['RT'] . "/RW " . $data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['RW']. " Kelurahan ".$data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kelurahan'] . 
												"<br/> Kec " . $data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kecamatan'] . " Kota " . $data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kota'].
												"<br/> Provinsi " . $data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kecamatan'] . " Kode Pos " .  $data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kodePos']
												);
											?>
										
										

								
								
								</td>
							</tr>
							<tr>
								<td width="280px" valign="top" style="padding-top:10px;">8. Alamat Domisili</td>
								<td width="10px"  valign="top" style="padding-top:10px;">:</td>
								<td width="550px"  valign="top" style="padding-top:10px;">
								
											<?php 
												echo strtoupper(
												$data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['alamat'].
												"<br/> RT " . $data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['RT'] . "/RW " . $data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['RW']. " Kelurahan ".$data['req']['applicationList'][0]['pemegangPolis']['alamatSesuaiIdentitas']['kelurahan'] . 
												"<br/> Kec " . $data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['kecamatan'] . " Kota " . $data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['kota'].
												"<br/> Provinsi " . $data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['kecamatan'] . " Kode Pos " .  $data['req']['applicationList'][0]['pemegangPolis']['alamatDomisili']['kodePos']
												);
											?>
										

								</td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:10px;">9. Pekerjaan</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['pekerjaan']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:10px;">10. Bidang Usaha</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['bidangUsaha']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:10px;">11. Jabatan</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['jabatan']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:10px;">12. Nama Institusi Tempat Kerja</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['namaInstitusiTempatKerja']);?></td>
							</tr>
							<tr>
								<td width="280px" valign="" style="padding-top:10px;">13. Alamat Institusi</td>
								<td width="10px"  valign="top" style="padding-top:10px;">:</td>
								<td width="550px"  valign="top" style="padding-top:10px;">
								
											<?php 
												echo strtoupper(
												$data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['alamat']['alamat'].
												"<br/> RT " . $data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['alamat']['RT'] . "/RW " . $data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['alamat']['RW']. " Kelurahan ".$data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['alamat']['kelurahan'] . 
												"<br/> Kec " . $data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['alamat']['kecamatan'] . " Kota " . $data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['alamat']['kota'].
												"<br/> Provinsi " . $data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['alamat']['kecamatan'] . " Kode Pos " .  $data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['alamat']['kodePos']
												);
											?>
										
							<tr>
								<td width="280px" style="padding-top:10px;">14. Informasi Kontak Tempat Kerja</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['pekerjaan']['telepon']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:10px;">15. Alamat Surat Menyurat</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['alamatSuratMenyurat']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:10px;">16. Hubungan dengan Calon Tertanggung</td>
								<td width="10px" style="padding-top:10px;">:</td>
								<td width="550px" style="padding-top:10px;"><?=strtoupper($data['req']['applicationList'][0]['pemegangPolis']['hubungan']);?></td>
							</tr>
								
								
								</td>
							</tr>
						</table>

						
						
						
						
						
						
						<pagebreak>
						&nbsp;
						<div style="margin-top:90px;width:880px;height:15px;background-color:#003b70;color:#ffffff;font-size:8pt;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;"><b>B. DATA CALON TERTANGGUNG</b></div>
						
						<table style="width:880px;font-size:10pt;">
							<tr>
								<td colspan="3"><b>Data otomatis terisi apabila Calon Tertanggung sama dengan Calon Pemegang Polis</b></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">1. Nama Lengkap (Sesuai Kartu Identitas)</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['namaLengkap']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">2. Jenis Kartu Identitas</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['jenisKartuIdentitas']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">3. Nomor Induk Kependudukan</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['nomorKartuIdentitas']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">4. Tempat & Tanggal Lahir (tgl/bln/thn)</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['tempatLahir']) . ", " . date("d/m/Y", strtotime($data['req']['applicationList'][0]['tertanggung']['tanggalLahir']));?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">5. Jenis Kelamin</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['jenisKelamin']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">6. Status Perkawinan</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['statusPerkawinan']);?></td>
							</tr>
							<tr>
								<td width="280px" valign="top" style="padding-top:15px;">7. Alamat Sesuai Kartu Identitas</td>
								<td width="10px"  valign="top" style="padding-top:15px;">:</td>
								<td width="550px"  valign="top" style="padding-top:15px;">
								
											<?php 
												echo strtoupper(
												$data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['alamat'].
												"<br/> RT " . $data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['RT'] . "/RW " . $data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['RW']. " Kelurahan ".$data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kelurahan'] . 
												"<br/> Kec " . $data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kecamatan'] . " Kota " . $data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kota'].
												"<br/> Provinsi " . $data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kecamatan'] . " Kode Pos " .  $data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kodePos']
												);
											?>
										
										

								
								
								</td>
							</tr>
							<tr>
								<td width="280px" valign="top" style="padding-top:15px;">8. Alamat Domisili</td>
								<td width="10px"  valign="top" style="padding-top:15px;">:</td>
								<td width="550px"  valign="top" style="padding-top:15px;">
								
											<?php 
												echo strtoupper(
												$data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['alamat'].
												"<br/> RT " . $data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['RT'] . "/RW " . $data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['RW']. " Kelurahan ".$data['req']['applicationList'][0]['tertanggung']['alamatSesuaiIdentitas']['kelurahan'] . 
												"<br/> Kec " . $data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['kecamatan'] . " Kota " . $data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['kota'].
												"<br/> Provinsi " . $data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['kecamatan'] . " Kode Pos " .  $data['req']['applicationList'][0]['tertanggung']['alamatDomisili']['kodePos']
												);
											?>
										

								</td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">9. Pekerjaan</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['pekerjaan']['pekerjaan']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">10. Bidang Usaha</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['pekerjaan']['bidangUsaha']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">11. Jabatan</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['pekerjaan']['jabatan']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">12. Nama Institusi Tempat Kerja</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['pekerjaan']['namaInstitusiTempatKerja']);?></td>
							</tr>
							<tr>
								<td width="280px" valign="" style="padding-top:15px;">13. Alamat Institusi</td>
								<td width="10px"  valign="top" style="padding-top:15px;">:</td>
								<td width="550px"  valign="top" style="padding-top:15px;">
								
											<?php 
												echo strtoupper(
												$data['req']['applicationList'][0]['tertanggung']['pekerjaan']['alamat']['alamat'].
												"<br/> RT " . $data['req']['applicationList'][0]['tertanggung']['pekerjaan']['alamat']['RT'] . "/RW " . $data['req']['applicationList'][0]['tertanggung']['pekerjaan']['alamat']['RW']. " Kelurahan ".$data['req']['applicationList'][0]['tertanggung']['pekerjaan']['alamat']['kelurahan'] . 
												"<br/> Kec " . $data['req']['applicationList'][0]['tertanggung']['pekerjaan']['alamat']['kecamatan'] . " Kota " . $data['req']['applicationList'][0]['tertanggung']['pekerjaan']['alamat']['kota'].
												"<br/> Provinsi " . $data['req']['applicationList'][0]['tertanggung']['pekerjaan']['alamat']['kecamatan'] . " Kode Pos " .  $data['req']['applicationList'][0]['tertanggung']['pekerjaan']['alamat']['kodePos']
												);
											?>
										
							<tr>
								<td width="280px" style="padding-top:15px;">14. Informasi Kontak Tempat Kerja</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['tertanggung']['pekerjaan']['telepon']);?></td>
							</tr>
								
								
								</td>
							</tr>
						</table>
						
						<pagebreak />
						
						
						
						&nbsp;
						<div style="margin-top:80px;width:880px;height:15px;background-color:#003b70;color:#ffffff;font-size:8pt;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;"><b>C. DATA PEMBAYARAN PREMI</b></div>
						<span style="font-size:8pt;">
							<b>Sehubungan dengan adanya Peraturan Otoritas Jasa Keuangan Nomor 12 / POJK.01 / 2017 Tentang Penerapan Program Anti Pencucian Uang dan Pencegahan Pendanaan Terorisme di Sektor Jasa Keuangan, Penanggung menerapkan kewajiban bagi calon Pembayar Premi untuk menjawab pertanyaan pertanyaan di bawah ini</b>
						</span>
						
						
						<table style="width:880px;font-size:10pt;border:solid black 1px;margin-top:10px;" border="1" cellpadding="0" cellspacing="0">
							<tr>
								<td colspan="2"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><b>Calon Pembayar Premi</b></td>
							</tr>
							<tr>
								<td width="350px" style="padding-left:8px;padding-top:10px;border-right:0px;border-bottom:0px;">Calon Pembayar Premi adalah Calon Pemegang Polis</td>
								<td width="450px" style="padding-left:8px;padding-top:10px;border-left:0px;border-bottom:0px;">: <?php if($data['req']['applicationList'][0]['pembayaranPremi']['pemegangPolis']) echo "Ya"; else echo "Tidak";?></td>
							</tr>
							<tr>
								<td colspan="2" style="padding-left:8px;padding-top:5px;border-right:0px;border-top:0px;padding-bottom:5px;">Jika Calon Pembayar Premi berbeda dengan Calon Pemegang Polis, mohon mengisi Formulir Tambahan Data Calon Pembayar Premi</td>
							</tr>
							<tr>
								<td colspan="2"  style="padding-left:8px;padding-top:5px;padding-bottom:5px;"><b>Sumber Dana Pembayaran Premi</b></td>
							</tr>
							<tr>
								<td width="450px" style="padding-left:8px;padding-top:10px;border-right:0px;padding-bottom:5px;">1. Tujuan pengajuan asuransi (Pilihan dapat lebih dari satu)</td>
								<td width="400px" valign="top"  style="padding-left:8px;padding-top:10px;border-left:0px;">: <?php echo strtoupper($data['req']['applicationList'][0]['pembayaranPremi']['sumberDana']['tujuanPengajuanAsuransi'][0]);?></td>
							</tr>
							<tr>
								<td width="450px" style="padding-left:8px;padding-top:10px;border-right:0px;padding-bottom:5px;">2. Sumber penghasilan per bulan dari Calon Pembayar Premi (Pilihan dapat lebih dari satu)</td>
								<td width="400px" valign="top" style="padding-left:8px;padding-top:10px;border-left:0px;">: <?php echo strtoupper($data['req']['applicationList'][0]['pembayaranPremi']['sumberDana']['sumberPenghasilanPerbulan'][0]);?></td>
							</tr>
							<tr>
								<td width="450px" style="padding-left:8px;padding-top:10px;border-right:0px;padding-bottom:5px;">3. Jumlah penghasilan kotor per tahun</td>
								<td width="400px" valign="top"  style="padding-left:8px;padding-top:10px;border-left:0px;">: <?php echo strtoupper($data['req']['applicationList'][0]['pembayaranPremi']['sumberDana']['jumlahPenghasilanKotorPertahun']);?></td>
							</tr>
							<tr>
								<td width="450px" style="padding-left:8px;padding-top:10px;border-right:0px;padding-bottom:5px;">4. Cara Bayar Premi Berkala</td>
								<td width="400px" valign="top"  style="padding-left:8px;padding-top:10px;border-left:0px;">: <?php if(isset($data['req']['applicationList'][0]['pembayaranPremi']['sumberDana']['caraBayarPremi'])) echo strtoupper($data['req']['applicationList'][0]['pembayaranPremi']['sumberDana']['caraBayarPremi']); else echo ""?></td>
							</tr>
							<tr>
								<td width="450px" style="padding-left:8px;padding-top:10px;border-right:0px;padding-bottom:5px;">5. Cara Bayar Premi</td>
								<td width="400px" valign="top"  style="padding-left:8px;padding-top:10px;border-left:0px;">: Auto Debit Kartu Debit / Kartu Kredit</td>
							</tr>
							
						</table>
						
						
						&nbsp;
						<div style="margin-top:5px;width:880px;height:15px;background-color:#003b70;color:#ffffff;font-size:8pt;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;"><b>D. DATA PENERIMA MANFAAT</b></div>
						<table style="width:880px;font-size:10pt;border:solid black 1px;margin-top:10px;" border="1" cellpadding="0" cellspacing="0">
							<tr>
								<td width="50px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><b>No</b></td>
								<td width="120px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><b>Nama Lengkap (Sesuai Kartu Identitas)</b></td>
								<td width="120px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><b>Nomor Induk Kependudukan</b></td>
								<td width="100px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><b>Tanggal Lahir</b></td>
								<td width="100px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><b>Pria/Wanita</b></td>
								<td width="120px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><b>Hubungan dengan Tertanggung</b></td>
								<td width="100px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><b>Persentase (%)</b></td>
							</tr>
							
							<?php
							// echo count(array($data['req']['applicationList'][0]['penerimaManfaat']));die;
								// if(!$data['req']['applicationList'][0]['penerimaManfaat']) {
								$nomor = 0;
								if(count(array($data['req']['applicationList'][0]['penerimaManfaat']))<>0) {
									for($no=0; $no<=count(array($data['req']['applicationList'][0]['penerimaManfaat'])); $no++){
										if(isset($data['req']['applicationList'][0]['penerimaManfaat'][$no])){
										$nomor = $no+1;
							?>
							<tr>
								<td width="50px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><?=$no+1;?></td>
								<td width="120px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><?php echo strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['namaLengkap']);?></td>
								<td width="120px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><?php  echo strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['nomorIndukKependudukan']);?></td>
								<td width="100px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><?php echo date("d/m/Y", strtotime($data['req']['applicationList'][0]['penerimaManfaat'][$no]['tanggalLahir']));?></td>
								<td width="100px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><?php echo $data['req']['applicationList'][0]['penerimaManfaat'][$no]['jenisKelamin'];?></td>
								<td width="120px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><?php echo strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['hubungan']);?></td>
								<td width="100px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><?php echo strtoupper($data['req']['applicationList'][0]['penerimaManfaat'][$no]['persentase']);?></td>
							</tr>
							
							<?php
										}
										$nomor += 0;
								}
								
								if($nomor<3){
									for($i =$nomor+1; $i <= 3; $i++){
							?>
							<tr>
								<td width="50px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><?=$i;?></td>
								<td width="120px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"></td>
								<td width="120px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"></td>
								<td width="100px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"></td>
								<td width="100px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"></td>
								<td width="120px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"></td>
								<td width="100px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"></td>
							</tr>
							<?php
									}
								}
							}else{
								for($i =1; $i <= 3; $i++){
							?>
							

							<tr>
								<td width="50px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"><?=$i;?></td>
								<td width="120px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"></td>
								<td width="120px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"></td>
								<td width="100px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"></td>
								<td width="100px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"></td>
								<td width="120px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"></td>
								<td width="100px"  style="padding-left:8px;padding-top:8px;padding-bottom:8px;"></td>
							</tr>
							<?php 
								}
							}
							?>
							
						</table>
						
						&nbsp;
						<div style="margin-top:5px;width:880px;height:15px;margin-bottom:8px;background-color:#003b70;color:#ffffff;font-size:8pt;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;"><b>E. DATA PERTANGGUNGAN</b></div>
						<span style="font-size:8pt;">
							<b>Manfaat Asuransi Utama</b>
						</span>
						<span style="font-size:8pt;">
							<br/>MIFG <?=ucwords($data['req']['applicationList'][0]['dataAsuransi']['produk']);?>
						</span>
						
						<table style="width:350px;font-size:8pt;border:solid black 1px;margin-top:5px;" border="1" cellpadding="0" cellspacing="0">
							<tr>
								<td width="150px"  style="padding-left:8px;padding-top:5px;padding-bottom:5px;">PLAN</td>
								<td width="200px" colspan="2"  style="padding-left:8px;padding-top:5px;padding-bottom:5px;text-align:center;">KELAS</td>
							</tr>
							<?php
							$plan = $data['req']['applicationList'][0]['dataAsuransi']['plan'];
							$kelas = $data['req']['applicationList'][0]['dataAsuransi']['kelas'];
							// if($plan=='P') $plan = "PLATINUM"; elseif($plan=='G') $plan = "GOLD"; else $plan = "SILVER";
							// if($kelas=='0') $kelas = "VIP"; elseif($kelas=='1') $kelas = "I"; elseif($kelas=='2') $kelas = "II"; else $kelas = "III";
							?>
							<tr>
								<td width="150px"  style="padding-left:8px;padding-top:5px;padding-bottom:5px;">Platinum</td>
								<td width="100px"  style="padding-left:8px;padding-top:5px;padding-bottom:5px;"><?php if($kelas=='0') echo "<img src='./images/icons/boxchecked.png' height='10px'>";else echo "<img src='./images/icons/box.png' height='10px'>";?> VIP</td>
								<td width="100px"  style="padding-left:8px;padding-top:5px;padding-bottom:5px;"><?php if($kelas=='1') echo "<img src='./images/icons/boxchecked.png' height='10px'>";else echo "<img src='./images/icons/box.png' height='10px'>";?> I</td>
							</tr>
						</table>
						
						<table style="width:880px;font-size:10pt;">
							<tr>
								<td width="150px" style="padding-top:5px;">Manfaat Asuransi Tambahan</td>
								<td width="10px" style="padding-top:5px;">:</td>
								<td width="550px" style="padding-top:5px;">
								<?php if($premi_tambahan['nominal_kematian']>0){ ?>
									<img src='./images/icons/boxchecked.png' height='10px'>
								<?php }else{ ?>
									<img src='./images/icons/box.png' height='10px'>
								<?php } ?>
								<b>Santunan Kematian</b>
								
								&nbsp;
								&nbsp;
								
								<?php if($premi_tambahan['nominal_inap']>0){ ?>
									<img src='./images/icons/boxchecked.png' height='10px'>
								<?php }else{ ?>
									<img src='./images/icons/box.png' height='10px'>
								<?php } ?>
								<b>Santunan Harian Rawat Inap</b>
								</td>
							</tr>
							<tr>
								<td width="150px" style="padding-top:5px;">Provider</td>
								<td width="10px" style="padding-top:5px;">:</td>
								<td width="550px" style="padding-top:5px;">Siloam Hospitals Group</td>
							</tr>
							<tr>
								<td width="150px" style="padding-top:5px;">Masa Asuransi</td>
								<td width="10px" style="padding-top:5px;">:</td>
								<td width="550px" style="padding-top:5px;"><?=ucwords($data['req']['applicationList'][0]['dataAsuransi']['masaAsuransi']);?></td>
							</tr>
							<tr>
								<td width="150px" style="padding-top:5px;">Mata Uang</td>
								<td width="10px" style="padding-top:5px;">:</td>
								<td width="550px" style="padding-top:5px;"><?=ucwords($data['req']['applicationList'][0]['dataAsuransi']['mataUang']);?></td>
							</tr>
						</table>
						
						&nbsp;
						<div style="margin-top:0px;width:880px;height:15px;margin-bottom:8px;background-color:#003b70;color:#ffffff;font-size:8pt;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;"><b>F. DATA KEPEMILIKAN ASURANSI</b></div>
						
						<table style="width:880px;font-size:10pt;">
							<tr>
								<td width="500px" colspan="2" valign="top" style="padding-top:5px;"><b>1. Apakah asuransi Anda pernah ditolak, ditunda, dikenakan ekstra premi, diubah/dihentikan oleh Perusahaan Asuransi?</b></td>
								<td width="200px" valign="top" style="padding-top:5px;"><b>Tertanggung</b></td>
							</tr>
							<tr>
								<td width="150px" valign="top" style="padding-top:5px;">Jika Ya, jelaskan alasannya :</td>
								<td width="350px" valign="top" style="padding-top:5px;"></td>
								<td width="200px" valign="top" style="padding-top:5px;">
								<?php if($data['req']['applicationList'][0]['kepemilikanAsuransi']['statusKepemilikan']){ ?>
									<img src='./images/icons/boxchecked.png' height='10px'><b>&nbsp;Ya</b>&nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='10px'>&nbsp;Tidak
								<?php }else{ ?>
									<img src='./images/icons/box.png' height='10px'><b>&nbsp;Ya</b>&nbsp;&nbsp;&nbsp;<img src='./images/icons/boxchecked.png' height='10px'>&nbsp;Tidak
								<?php } ?>
								
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" style="padding-top:5px;">
								<br/>
								<?=ucwords($data['req']['applicationList'][0]['kepemilikanAsuransi']['alasan']);?>
								</td>
								<td width="200px" valign="top" style="padding-top:5px;">&nbsp;</td>
							</tr>
						</table>
						
						<pagebreak />
						
						&nbsp;
						<div style="margin-top:90px;width:880px;height:15px;background-color:#003b70;color:#ffffff;font-size:8pt;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;"><b>G. DATA KESEHATAN CALON TERTANGGUNG</b></div>
						
						<?php
							$sql_label = "SELECT distinct(label) FROM questions WHERE category_id = 7 AND label IS NOT null ORDER BY id, sort_order";
							$data_label = Yii::$app->db->createCommand($sql_label)->queryAll();
							foreach ($data_label as $lab) {
								$labelnya = $lab['label'];
						?>
						<table style="width:880px;font-size:10pt;border:solid black 1px;margin-top:10px;" border="1" cellpadding="0" cellspacing="0">
							<tr>
								<td colspan="8" style="height:15px;margin-bottom:4px;background-color:#003b70;color:#ffffff;font-size:8pt;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;text-align:center;"><b><?=$labelnya;?></b></td>
							</tr>
							<?php if($labelnya=='MEDICAL HISTORY'){?>
							<tr>
								<td colspan="8" valign="top" style="padding-left:4px;padding-top:4px;padding-bottom:4px;font-weight:normal;font-size:9px;">Dalam 2 tahun terakhir apakah Anda pernah mengalami gejala-gejala, diperiksa, menderita, mendapat pengobatan, disarankan untuk rawat inap/rawat jalan, menjalani rawat inap/rawat jalan untuk kelainan yang disebutkan di bawah ini :</td>
							</tr>
							<?php } ?>
						<?php
							$sql_q = "SELECT id,question_text,sort_order,label,input_name FROM questions WHERE category_id = 7 AND label='$labelnya' and input_name !='' and id<136 and id not in(132)  ORDER BY id, sort_order";
							$data_q = Yii::$app->db->createCommand($sql_q)->queryAll();
							foreach ($data_q as $qs) {
						?>
							<tr>
								<td width="250px" valign="top"  style="padding-left:4px;padding-top:4px;padding-bottom:4px;font-weight:normal;font-size:9px;"><?=$qs['question_text'];?></td>
									<?php
									if($qs['id']<>94 && $qs['id']<>95){
									$sql_ans = "SELECT option_text FROM questions_option WHERE question_id = '".$qs['id']."' order by point_value";
									$data_ans = Yii::$app->db->createCommand($sql_ans)->queryAll();
									$nom = 1;
									foreach ($data_ans as $ans) {
										$cari_pos = caripos($qs['input_name'],$data['req']['applicationList'][0]['kesehatanTertanggung']);
										if($cari_pos==$ans['option_text']) $img = "<img src='./images/icons/boxchecked.png' height='10px'>"; else $img = "<img src='./images/icons/box.png' height='10px'>";
										echo "<td width='80px'  style='padding-left:5px;font-weight:normal;font-size:8px;min-width:90px;'>".$img . " " . $ans['option_text']."</td>";
										$nom++;
									}
									}else{
										$nom = 2;
										if($qs['id']==94){
											$cari_pos = caripos('L00001',$data['req']['applicationList'][0]['kesehatanTertanggung']);
											echo "<td width='80px'  style='padding-left:5px;font-weight:normal;font-size:8px;min-width:90px;'>".$cari_pos." cm</td>";
										}elseif($qs['id']==95){
											$cari_pos = caripos('L00002',$data['req']['applicationList'][0]['kesehatanTertanggung']);
											echo "<td width='80px'  style='padding-left:5px;font-weight:normal;font-size:8px;min-width:90px;'>".$cari_pos." Kg</td>";
										}
									}
									$tujuh = 7 - $nom;
										if($nom > 0){
											for($nn=0; $nn<=$tujuh; $nn++){
												echo "<td  width='80px'>&nbsp;</td>";
											}
										}
									
									?>
							</tr>
						<?php } ?>
						
						


						</table>
						
						
						<?php } ?>
						
						<pagebreak />
						&nbsp;
						<table style="margin-top:80px;width:880px;font-size:10pt;border:solid black 1px;" border="1" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="8" style="height:15px;margin-bottom:4px;background-color:#003b70;color:#ffffff;font-size:8pt;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;text-align:center;"><b>MEDICAL HISTORY</b></td>
						</tr>
						<?php
							$arr = array("132"=>"MH0017","143"=>"MH0021","144"=>"MH0022","145"=>"MH0023");
							foreach($arr as $idnya => $valnya){
							$sql_q = "SELECT id,question_text,sort_order,label,input_name FROM questions WHERE category_id = 7 AND id='$idnya' ";
							$data_q = Yii::$app->db->createCommand($sql_q)->queryAll();
							foreach ($data_q as $qs) {
							echo "<tr><td width='250px' valign='top'  style='padding-left:4px;padding-top:4px;padding-bottom:4px;font-weight:normal;font-size:9px;'>".$qs['question_text']."</td>";
							
							$sql_ans = "SELECT option_text FROM questions_option WHERE question_id = '$idnya' order by point_value";
							$data_ans = Yii::$app->db->createCommand($sql_ans)->queryAll();
							$cari_ppok = caripos('MH0017',$data['req']['applicationList'][0]['kesehatanTertanggung']);
							$trx = explode(",",$cari_ppok);
							$no = 0;
							foreach ($data_ans as $ans) {
								if($trx[$no]==$ans['option_text']) $img = "<img src='./images/icons/boxchecked.png' height='10px'>"; else $img = "<img src='./images/icons/box.png' height='10px'>";												
								echo "<td width='80px'  style='padding-left:5px;font-weight:normal;font-size:8px;min-width:90px;'>".$img . " " . $ans['option_text']."</td>";
								$no++;

							}
							for($nn=0; $nn<=4; $nn++){
								echo "<td  width='80px'>&nbsp;</td>";
							}
							echo "</tr>";
							}
							}
						?>
						</table>
						
						
						
						&nbsp;
						<div style="margin-top:10px;width:880px;height:15px;background-color:#003b70;color:#ffffff;font-size:8pt;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;"><b>H. PERNYATAAN CALON PEMEGANG POLIS DAN CALON TERTANGGUNG</b></div>
						
						<table style="margin-top:10px;width:880px;font-size:10pt;border:solid black 1px;" border="0" cellpadding="0" cellspacing="0">
							<tr><td colspan="2">Dengan ini Saya/Kami menyatakan, telah mendapatkan penjelasan dari Agen Asuransi mengenai produk, fitur, dan mafaat asuransi sepenuhnya dan selanjutnya menyatakan setuju :</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">1. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Telah membaca, mengerti, memahami, memberikan informasi dan menjawab seluruh pertanyaan pada Surat Permintaan Asuransi Jiwa beserta lampirannya dengan sebenar-benarnya, jujur dan lengkap. Saya/Kami memahami bahwa jawaban dan keterangan-keterangan tersebut merupakan dasar serta merupakan satu kesatuan bagian yang tidak terpisahkan dari pembuatan Polis. Apabila ternyata jawaban-jawaban yang Saya/Kami berikan itu tidak benar, maka Penanggung berhak untuk membatalkan pertanggungan asuransi yang dibuat atas dasar permohonan asuransi ini.</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">2. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Saya/Kami menyetujui untuk membayar premi yang besarnya tergantung dari Manfaat Utama dan Manfaat Tambahan (jika ada), Usia Tertanggung, Jenis Kelamin Tertanggung, gaya hidup dan kebiasaan Tertanggung, Pekerjaan Tertanggung dan Kesehatan Tertanggung.</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">3. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Saya/Kami menyetujui untuk membayar semua biaya-biaya yang timbul sehubungan dengan pertanggungan asuransi ini termasuk tetapi tidak terbatas pada biaya akuisisi.</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">4. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Menyetujui bahwa pertanggungan akan berlaku apabila Surat Permintaan Asuransi Jiwa ini telah disetujui dan premi pertama telah dibayarkan lunas sesuai dengan periode pembayaran.</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">5. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Saya/Kami menyatakan bahwa pembayaran premi untuk Polis yang Saya/Kami ajukan berdasarkan Surat Permintaan Asuransi Jiwa ini tidak<br />berasal dari dan/atau untuk tujuan pidana pencucian uang dan/atau tindak pidana lain yang dilarang berdasarkan peraturan dan perundang-undangan yang berlaku di Indonesia. Apabila ada indikasi pelanggaran atas peraturan dan perundang-undangan yang berlaku di Indonesia, maka Penanggung akan melaksanakan kewajibannya sesuai dengan ketentuan yang berlaku.</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">6. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Saya/Kami dengan ini mengizinkan Penanggung untuk menggunakan atau memberikan informasi atau keterangan mengenai Saya/Kami yang tersedia, diperoleh atau disimpan oleh Penanggung sesuai yang tercantum dalam Surat Permintaan Asuransi Jiwa ini atau sarana lain, kepada pihak - pihak lain (termasuk tetapi tidak terbatas pada perusahaan reasuransi, asuransi, lembaga, bank atau badan hukum lain) yang memiliki hubungan kerjasama dengan Penanggung dalam rangka pengajuan Surat Permintaan Asuransi Jiwa ini, pembayaran klaim, pelayanan nasabah, maupun penawaran produk lain kepada Saya/Kami.</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">7. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Telah memberikan dan melakukan verikasi atas seluruh salinan dari dokumen dan informasi atau data yang diberikan sehubungan dengan penutupan polis ini dan Saya/Kami menyatakan bahwa salinan dan informasi atau data tersebut adalah sesuai asli dan masih berlaku.</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">8. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Sesuai dengan Peraturan Otoritas Jasa Keuangan Nomor 12 / POJK.01 / 2017 Tentang Penerapan Program Anti Pencucian Uang dan Pencegahan Pendanaan Terorisme di Sektor Jasa Keuangan yang mensyaratkan dilakukannya pengkinian data, Saya/Kami memahami untuk melakukan pengkinian data dan menyetujui untuk menyerahkan salinan dokumen pendukung yang berlaku kepada Penanggung.</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">9. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Menyetujui bahwa Penanggung berhak menolak klaim yang diajukan apabila dikemudian hari terdapat kekeliruan data/informasi didalam Surat Permintaan Asuransi Jiwa ini.</td></tr>
							<tr><td width='18'></td><td style="text-align: justify; text-justify: inter-word;font-size:12px;font-style:italic;padding-top:10px;">*) Polis akan dikirimkan dalam format elekronik melalui alamat email dan dapat diunduh melalui aplikasi FitAja! dan Penanggung akan mengirimkan Ikhtisar Polis ke alamat sesuai korespondensi Pemegang Polis.</td></tr>
							<tr><td width='18'></td><td style="padding-top:5px;">Permintaan pencetakan Polis akan dikenakan biaya sebesar Rp150.000,- (Seratus Lima Puluh Ribu Rupiah)</td></tr>
							<tr>
								<td width='18'></td>
								<td style="padding-top:5px;">
									<table style="margin-top:10px;width:800px;font-size:10pt;border:solid black 1px;" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td style="width:250px;height:40px;" valign="top">Pencetakan Polis</td>
											<td style="width:20px;height:40px;" valign="top">:</td>
											
											<?php if($data['req']['applicationList'][0]['pencetakanPolis']){ ?>
												<td style="width:200px;height:40px;" valign="top">
													<img src='./images/icons/boxchecked.png' height='10px'>&nbsp;Ya
												</td>
												<td style="width:200px;height:40px;" valign="top">
													<img src='./images/icons/box.png' height='10px'>&nbsp;Tidak
												</td>
											<?php }else{ ?>
											<td style="width:200px;height:40px;" valign="top">
												<img src='./images/icons/box.png' height='10px'>&nbsp;Ya
											</td>
											<td style="width:200px;height:40px;" valign="top">
												<img src='./images/icons/boxchecked.png' height='10px'>&nbsp;Tidak
											</td>
											<?php } ?>
											
										</tr>
									<tr>
											<td style="width:250px;height:45px;" valign="top">Alamat Pengiriman Polis <br/>(hanya diisi jika Polis dicetak)</td>
											<td style="width:20px;height:45px;" valign="top">:</td>
											<?php if($data['req']['applicationList'][0]['alamatPengirimanPolis']=='Sesuai Identitas'){ ?>
											<td style="width:200px;height:45px;" valign="top">
												<img src='./images/icons/boxchecked.png' height='10px'>&nbsp;Sesuai Identitas
											</td>
											<td style="width:200px;height:40px;" valign="top">
												<img src='./images/icons/box.png' height='10px'>&nbsp;Sesuai Domisili
											</td>
											<?php }else{ ?>
											<td style="width:200px;height:40px;" valign="top">
												<img src='./images/icons/box.png' height='10px'>&nbsp;Sesuai Identitas
											</td>
											<td style="width:200px;height:40px;" valign="top">
												<img src='./images/icons/boxchecked.png' height='10px'>&nbsp;Sesuai Domisili
											</td>
											<?php } ?>
											
										</tr>
									<!--
									<tr>
											<td style="width:250px;height:40px;" valign="top">Ikhtisar Polis dalam bentuk cetakan</td>
											<td style="width:20px;height:40px;" valign="top">:</td>
											<?php if($data['req']['applicationList'][0]['ikhtisarCetakanPolis']<>'Dikirim ke alamat pemegang polis'){ ?>
											<td style="width:200px;height:40px;" valign="top">
												<img src='./images/icons/box.png' height='10px'>&nbsp;dititipkan kepada Penanggung
											</td>
											<td style="width:200px;height:40px;" valign="top">
												<img src='./images/icons/boxchecked.png' height='10px'>&nbsp;Dikirim ke alamat pemegang polis
											</td>
											<?php }else{ ?>
											<td style="width:200px;height:40px;" valign="top">
												<img src='./images/icons/box.png' height='10px'>&nbsp;Ya
											</td>
											<td style="width:400px;height:40px;" valign="top">
												<img src='./images/icons/boxchecked.png' height='10px'>&nbsp;Dikirim ke alamat pemegang polis
											</td>
											<?php } ?>
										</tr>
										-->
									</table>
							
								</td>
							</tr>
							<tr>
								<td width='18px'></td>
								<td style="text-align: justify; text-justify: inter-word;padding-top:5px;">
									Dengan ini Saya/Kami memberi persetujuan dan hak kepada Penanggung yang tidak dapat dicabut dengan sebab apapun juga untuk meminta keterangan mengenai data 
Saya/Kami kepada pihak terkait seperti dokter, rumah sakit, klinik, puskesmas, perusahaan asuransi, badan hukum, perorangan atau organisasi lainnya yang mempunyai 
keterangan kebiasaan, pekerjaan dan catatan medis dari Saya/Kami. Sehubungan dengan hal ini, Saya/Kami memberikan persetujuan kepada pihak terkait untuk memberikan 
keterangan yang diperlukan Penanggung. Dalam hal diperlukan suatu kuasa khusus maka pemberian persetujuan dan hak yang dimaksud dapat dianggap sebagai pemberian 
kuasa.
								</td>
							</tr>
							<tr>
								<td width='18px'></td>
								<td style="text-align: justify; text-justify: inter-word;padding-top:25px;">
								<img src='./images/icons/boxchecked.png' height='20px'>&nbsp; Saya setuju dan menerima segala risiko dari pernyataan diatas.
								</td>
							</tr>
						</table>
						
						
					</div>
					
					
						
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
