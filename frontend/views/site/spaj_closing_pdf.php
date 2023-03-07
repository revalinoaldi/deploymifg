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
				<main>
					<div class="row contacts">

						
						<?php
						$sql_cs = "SELECT coalesce(count(id),0)as cs FROM closing_statement WHERE no_spaj = '".$data_spaj['no_spaj']."'";
						$data_cs = Yii::$app->db->createCommand($sql_cs)->queryOne();
						$n_cs =  $data_cs['cs'];
						if($n_cs > 0){
						?>
						
						&nbsp;
						<div style="margin-top:70px;width:880px;height:15px;background-color:#003b70;color:#ffffff;font-size:8pt;text-align:left;padding-top:5px;padding-bottom:5px;padding-left:10px;"><b>PERNYATAAN/LAPORAN AGEN PENUTUP</b></div>
						
						
						<table style="width:880px;font-size:10pt;">
							
							<tr>
								<td width="280px" style="padding-top:15px;">1. No Agen Penutup</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['agenPenutup']['noAgen']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">2. No Lisensi</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['agenPenutup']['noLisensiAgen']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">3. Nama Agen Pentutup</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['agenPenutup']['namaAgen']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;">4. No. Telp./ HP Agen Penutup</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;"><?=strtoupper($data['req']['applicationList'][0]['agenPenutup']['teleponAgen']);?></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;" valign="top">Dengan ini, saya menyatakan bahwa</td>
								<td width="10px" style="padding-top:15px;" valign="top">:</td>
								<td width="550px" style="padding-top:15px;" valign="top"></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;padding-left:20px;">Saya mengenal</td>
								<td width="10px" style="padding-top:15px;"></td>
								<td width="550px" style="padding-top:15px;"></td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;padding-left:20px;">* Calon Pemegang Polis Selama</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;">
									<table style="margin-top:0px;width:880px;font-size:10pt;border:solid black 1px;" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td width="100px" style="padding-top:0px;">
											<?php 
											if(isset($modelagent->kenal_pp_selama) && $modelagent->kenal_pp_selama == '< 1 Tahun')
												echo "<img src='./images/icons/boxchecked.png' height='20px' /> < 1 Tahun";
											else
												echo "<img src='./images/icons/box.png' height='20px' /> < 1 Tahun"; 
											?>
											</td>
											<td width="100px" style="padding-top:0px;">
											<?php 
											if(isset($modelagent->kenal_pp_selama) && $modelagent->kenal_pp_selama == '2-3 Tahun')
												echo "<img src='./images/icons/boxchecked.png' height='20px'> 2-3 Tahun";
											else 
												echo "<img src='./images/icons/box.png' height='20px'> < 2-3 Tahun";
											?>
											</td>
											<td width="100px" style="padding-top:0px;">
											<?php
											if(isset($modelagent->kenal_pp_selama) && $modelagent->kenal_pp_selama == '3-5 Tahun')
												echo "<img src='./images/icons/boxchecked.png' height='20px'> &nbsp; 3-5 Tahun";
											else
												echo "<img src='./images/icons/box.png' height='20px'> &nbsp; 3-5 Tahun";
											?>
											</td>
											<td width="100px" style="padding-top:0px;">
											<?php 
											if(isset($modelagent->kenal_pp_selama) && $modelagent->kenal_pp_selama == '> 5 Tahun')
												echo "<img src='./images/icons/boxchecked.png' height='20px'> &nbsp; > 5 Tahun";
											else 
												echo "<img src='./images/icons/box.png' height='20px'> &nbsp; > 5 Tahun";
											?>
											</td>
										</tr>
									</table>
									
									
									
								</td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;padding-left:20px;">sebagai</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;">
									<table style="margin-top:0px;width:880px;font-size:10pt;border:solid black 1px;" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td width="100px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_sebagai) && $modelagent->kenal_sebagai == 'Keluarga')
													echo "<img src='./images/icons/boxchecked.png' height='20px' /> Keluarga";
												else
													echo "<img src='./images/icons/box.png' height='20px' /> Keluarga"; 
												?>
												</td>
												<td width="100px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_sebagai) && $modelagent->kenal_sebagai == 'Teman')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> Teman";
												else 
													echo "<img src='./images/icons/box.png' height='20px'> Teman";
												?>
												</td>
												<td width="100px" style="padding-top:0px;">
												<?php
												if(isset($modelagent->kenal_sebagai) && $modelagent->kenal_sebagai == 'Referensi')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> Referensi";
												else
													echo "<img src='./images/icons/box.png' height='20px'> &nbsp; Referensi";
												?>
												</td>
												<td width="160px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_sebagai) && $modelagent->kenal_sebagai == 'Lainnya')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> Lainnya: <u>".$modelagent->kenal_sebagai . "</u>";
												else 
													echo "<img src='./images/icons/box.png' height='20px'> Lainnya: __________";
												?>
												</td>
											</tr>
										</table>
										
									
									
								</td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;padding-left:20px;">* Calon Tertanggung selama</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;">
								
								<table style="margin-top:0px;width:880px;font-size:10pt;border:solid black 1px;" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td width="100px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_tertanggung_selama) && $modelagent->kenal_tertanggung_selama == '< 1 Tahun')
													echo "<img src='./images/icons/boxchecked.png' height='20px' /> < 1 Tahun";
												else
													echo "<img src='./images/icons/box.png' height='20px' /> < 1 Tahun"; 
												?>
												</td>
												<td width="100px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_tertanggung_selama) && $modelagent->kenal_tertanggung_selama == '2-3 Tahun')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> 2-3 Tahun";
												else 
													echo "<img src='./images/icons/box.png' height='20px'> 2-3 Tahun";
												?>
												</td>
												<td width="100px" style="padding-top:0px;">
												<?php
												if(isset($modelagent->kenal_tertanggung_selama) && $modelagent->kenal_tertanggung_selama == '3-5 Tahun')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> 3-5 Tahun";
												else
													echo "<img src='./images/icons/box.png' height='20px'> &nbsp; 3-5 Tahun";
												?>
												</td>
												<td width="100px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_tertanggung_selama) && $modelagent->kenal_tertanggung_selama == '> 5 Tahun')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> > 5 Tahun";
												else 
													echo "<img src='./images/icons/box.png' height='20px'> > 5 Tahun";
												?>
												</td>
											</tr>
										</table>
										
									
								</td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;padding-left:20px;">sebagai</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;">
								<table style="margin-top:0px;width:880px;font-size:10pt;border:solid black 1px;" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td width="100px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_tertanggung_sebagai) && $modelagent->kenal_tertanggung_sebagai == 'Keluarga')
													echo "<img src='./images/icons/boxchecked.png' height='20px' /> Keluarga";
												else
													echo "<img src='./images/icons/box.png' height='20px' /> Keluarga"; 
												?>
												</td>
												<td width="100px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_tertanggung_sebagai) && $modelagent->kenal_tertanggung_sebagai == 'Teman')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> Teman";
												else 
													echo "<img src='./images/icons/box.png' height='20px'> Teman";
												?>
												</td>
												<td width="100px" style="padding-top:0px;">
												<?php
												if(isset($modelagent->kenal_tertanggung_sebagai) && $modelagent->kenal_tertanggung_sebagai == 'Referensi')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> Referensi";
												else
													echo "<img src='./images/icons/box.png' height='20px'> &nbsp; Referensi";
												?>
												</td>
												<td width="160px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_tertanggung_sebagai) && $modelagent->kenal_tertanggung_sebagai == 'Lainnya')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> Lainnya: <u>".$modelagent->kenal_tertanggung_sebagai . "</u>";
												else 
													echo "<img src='./images/icons/box.png' height='20px'> Lainnya: __________";
												?>
												</td>
											</tr>
										</table>
										
									
								</td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;padding-left:20px;">* Calon Pembayar Premi selama</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;">
								
									<table style="margin-top:0px;width:880px;font-size:10pt;border:solid black 1px;" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td width="100px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_pembayar_premi_selama) && $modelagent->kenal_pembayar_premi_selama == '< 1 Tahun')
													echo "<img src='./images/icons/boxchecked.png' height='20px' /> < 1 Tahun";
												else
													echo "<img src='./images/icons/box.png' height='20px' /> < 1 Tahun"; 
												?>
												</td>
												<td width="100px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_pembayar_premi_selama) && $modelagent->kenal_pembayar_premi_selama == '2-3 Tahun')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> 2-3 Tahun";
												else 
													echo "<img src='./images/icons/box.png' height='20px'> 2-3 Tahun";
												?>
												</td>
												<td width="100px" style="padding-top:0px;">
												<?php
												if(isset($modelagent->kenal_pembayar_premi_selama) && $modelagent->kenal_pembayar_premi_selama == '3-5 Tahun')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> 3-5 Tahun";
												else
													echo "<img src='./images/icons/box.png' height='20px'> &nbsp; 3-5 Tahun";
												?>
												</td>
												<td width="100px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_pembayar_premi_selama) && $modelagent->kenal_pembayar_premi_selama == '> 5 Tahun')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> > 5 Tahun";
												else 
													echo "<img src='./images/icons/box.png' height='20px'> > 5 Tahun";
												?>
												</td>
											</tr>
										</table>
										
									
								</td>
							</tr>
							<tr>
								<td width="280px" style="padding-top:15px;padding-left:20px;">sebagai</td>
								<td width="10px" style="padding-top:15px;">:</td>
								<td width="550px" style="padding-top:15px;">
										<table style="margin-top:0px;width:880px;font-size:10pt;border:solid black 1px;" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td width="100px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_pembayar_premi_sebagai) && $modelagent->kenal_pembayar_premi_sebagai == 'Keluarga')
													echo "<img src='./images/icons/boxchecked.png' height='20px' /> Keluarga";
												else
													echo "<img src='./images/icons/box.png' height='20px' /> Keluarga"; 
												?>
												</td>
												<td width="100px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_pembayar_premi_sebagai) && $modelagent->kenal_pembayar_premi_sebagai == 'Teman')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> Teman";
												else 
													echo "<img src='./images/icons/box.png' height='20px'> Teman";
												?>
												</td>
												<td width="100px" style="padding-top:0px;">
												<?php
												if(isset($modelagent->kenal_pembayar_premi_sebagai) && $modelagent->kenal_pembayar_premi_sebagai == 'Referensi')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> Referensi";
												else
													echo "<img src='./images/icons/box.png' height='20px'> &nbsp; Referensi";
												?>
												</td>
												<td width="160px" style="padding-top:0px;">
												<?php 
												if(isset($modelagent->kenal_pembayar_premi_sebagai) && $modelagent->kenal_pembayar_premi_sebagai == 'Lainnya')
													echo "<img src='./images/icons/boxchecked.png' height='20px'> Lainnya: <u>".$modelagent->kenal_pembayar_premi_sebagai . "</u>";
												else 
													echo "<img src='./images/icons/box.png' height='20px'> Lainnya: __________";
												?>
												</td>
											</tr>
										</table>
									
								</td>
							</tr>
						</table>
						
						<table style="margin-top:10px;margin-left:20px;width:800px;font-size:10pt;border:solid black 1px;" border="0" cellpadding="0" cellspacing="0">
							<tr><td width='18' valign="top" style="padding-top:5px;">1. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Semua keterangan yang terdapat di SPAJ ini adalah semata-mata keterangan yang diberikan oleh Calon Pemegang Polis dan/ atau Calon Tertanggung Utama dan/ atau Calon Tertanggung Tambahan dan/ atau Calon Pembayar Premi, saya tidak menyembunyikan informasi atau keterangan apapun yang telah diberikan oleh Calon Pemegang Polis dan/ atau Calon Tertanggung Utama dan/ atau Calon Tertanggung Tambahan dan/ atau Calon Pembayar Premi yang dapat mempengaruhi penerimaan SPAJ ini</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">2. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Saya telah menerangkan semua isi butir pernyataan di SPAJ dengan jelas dan menjelaskan informasi/ keterangan mengenai produk asuransi dan manfaatnya sesuai dengan Syarat Umum Polis dan/atau Syarat-Syarat Umum Polis dan Ketentuan Khusus Polis Asuransi Dasar maupun Asuransi Tambahan, termasuk menjelaskan bahwa jawaban yang tidak benar pada pengisian SPAJ akan berakibat klaim tidak dibayarkan serta berakibat batalnya polis</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">3. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Dalam hal saya membantu calon Pemegang Polis dan atau Calon Tertanggung mengisi SPAJ dan SKK ini adalah semata-mata membantu berdasarkan keinginan, permintaan dan persetujuan Calon Pemegang Polis dan atau Calon Tertanggung untuk mempercepat proses penutupan asuransi, dimana seluruh isian yang tercantum didalamnya sudah saya konrmasi kebenarannya kepada Calon Pemegang Polis dan atau Calon Tertanggung sebelum SPAJ dan SKK ini ditandatangani oleh Calon Pemegang Polis dan atau Calon Tertanggung.</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">4. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Calon Pemegang Polis, Calon Tertanggung, Calon Pembayar Premi adalah benar seorang yang berkepribadian baik dan jujur dalam segala urusan.</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">5. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Saya telah bertemu dan melihat secara langsung kondisi terakhir Calon Tertanggung Utama dan/ atau Calon Tertanggung Tambahan pada saat SPAJ ini diisi dan ditandatangani serta mengecek kebenaran dan kelengkapan pengisiannya.</td></tr>
							<tr><td width='18' valign="top" style="padding-top:5px;">6. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Apakah Calon Tertanggung dalam keadaan sehat sewaktu mengisi SPAJ ini</td></tr>
							<tr>
								<td width='18' valign="top" style="padding-top:5px;">&nbsp;</td>
								
											
								<td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> 
									<?php if(isset($modelagent->kesehatan_tertanggung) && $modelagent->kesehatan_tertanggung == 'Ya'){ ?>
										<img src='./images/icons/boxchecked.png' height='20px'> &nbsp; Ya 
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Tidak  
									<?php }else{ ?>
										<img src='./images/icons/box.png' height='20px'> &nbsp; Ya 
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/boxchecked.png' height='20px'> &nbsp; Tidak  
									<?php } ?>
								</td>
							</tr>
							
							
							<tr><td width='18' valign="top" style="padding-top:5px;">7. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Apakah premi yang dibayar sudah sesuai dengan kondisi keuangan Calon Pemegang Polis atau Calon Pembayar Premi untuk kelangsungan polis yang diajukan.</td></tr>
							
							<tr>
								<td width='18' valign="top" style="padding-top:5px;">&nbsp;</td>
								
											
								<td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> 
								<?php if(isset($modelagent->kondisi_keuangan_sesuai) && $modelagent->kondisi_keuangan_sesuai == 'Ya'){ ?>
									<img src='./images/icons/boxchecked.png' height='20px'> &nbsp; Ya 
									&nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Tidak  
								<?php }else{ ?>
									<img src='./images/icons/box.png' height='20px'> &nbsp; Ya 
									&nbsp;&nbsp;&nbsp;<img src='./images/icons/boxchecked.png' height='20px'> &nbsp; Tidak  
								<?php } ?>
								</td>
							</tr>
							
							<tr><td width='18' valign="top" style="padding-top:5px;">8. </td><td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> Pada awalnya yang memulai proses penutupan/ closing asuransi jiwa ini adalah</td></tr>
							<tr>
								<td width='18' valign="top" style="padding-top:5px;">&nbsp;</td>
								
											
								<td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> 
									
									<?php if(isset($modelagent->awal_penutupan_oleh) && $modelagent->awal_penutupan_oleh == 'Calon Pemegang Polis'){ ?>
										<img src='./images/icons/boxchecked.png' height='20px'> &nbsp; Calon Pemegang Polis 
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Calon Tertanggung Utama
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Calon Pembayar Premi
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Agen Penutup  
										<!-- &nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Lainnya  -->
									<?php }else if(isset($modelagent->awal_penutupan_oleh) && $modelagent->awal_penutupan_oleh == 'Calon Tertanggung Utama'){ ?>
										<img src='./images/icons/box.png' height='20px'> &nbsp; Calon Pemegang Polis 
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/boxchecked.png' height='20px'> &nbsp; Calon Tertanggung Utama
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Calon Pembayar Premi
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Agen Penutup  
										<!-- &nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Lainnya  -->
									<?php }else if(isset($modelagent->awal_penutupan_oleh) && $modelagent->awal_penutupan_oleh == 'Calon Pembayar Premi'){ ?>
										<img src='./images/icons/box.png' height='20px'> &nbsp; Calon Pemegang Polis 
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Calon Tertanggung Utama
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/boxchecked.png' height='20px'> &nbsp; Calon Pembayar Premi
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Agen Penutup  
										<!-- &nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Lainnya -->
									<?php }else if(isset($modelagent->awal_penutupan_oleh) && $modelagent->awal_penutupan_oleh == 'Agen Penutup'){ ?>
										<img src='./images/icons/box.png' height='20px'> &nbsp; Calon Pemegang Polis 
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Calon Tertanggung Utama
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Calon Pembayar Premi
										&nbsp;&nbsp;&nbsp;<img src='./images/icons/boxchecked.png' height='20px'> &nbsp; Agen Penutup  
										<!-- &nbsp;&nbsp;&nbsp;<img src='./images/icons/box.png' height='20px'> &nbsp; Lainnya  -->
									<?php } ?> 
									
									
								</td>
							</tr>
							<tr>
								<td width='18' valign="top" style="padding-top:5px;">&nbsp;</td>
								
											
								<td  style="text-align: justify; text-justify: inter-word;padding-top:5px;"> 
									<?php if($modelagent->awal_penutupan_oleh == 'Lainnya'){ ?>
									<img src='./images/icons/boxchecked.png' height='20px'> &nbsp; Lainnya : <u><?=$modelagent->awal_penutupan_oleh?></u>  
									<?php }else{ ?>
									<img src='./images/icons/box.png' height='20px'> &nbsp; Lainnya  __________
									<?php } ?>
								</td>
							</tr>
						</table>
						<?php } ?>
						
						
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
