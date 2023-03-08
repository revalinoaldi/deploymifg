<?php
	$buildid = $_GET['buildid'];
	$filepdf = $_GET['filepdf'];
	$kodeprospek = $_GET['kodeprospek'];

	$sql = "SELECT A.*, to_char(A.TGL_LAHIR, 'dd/mm/yyyy') as TANGGALLAHIR, 
				(SELECT NAMAPEKERJAAN FROM JAIM_400_JENIS_PEKERJAAN WHERE KDJENISPEKERJAAN= A.KDJNSPEKERJAAN) NAMA_PEKERJAAN_CPP,
				(SELECT namahobi FROM jaim_301_hobi WHERE kdhobi = A.kdhobi) NAMAHOBICPP,
				(SELECT LIFEEXTRA FROM JAIM_400_JENIS_PEKERJAAN WHERE KDJENISPEKERJAAN= A.KDJNSPEKERJAAN) EKSTRALIFE_CPP,
				(SELECT PAEXTRA FROM JAIM_400_JENIS_PEKERJAAN WHERE KDJENISPEKERJAAN= A.KDJNSPEKERJAAN) EKSTRAPA_CPP,
				(SELECT TPDEXTRA FROM JAIM_400_JENIS_PEKERJAAN WHERE KDJENISPEKERJAAN= A.KDJNSPEKERJAAN) EKSTRATPD_CPP	
			from PRO_PEMPOL A 
			where build_id = '".$buildid."'";
	$query = $this->db->query($sql);

	$sql2 = "SELECT B.*, to_char(B.TGL_LAHIR, 'dd/mm/yyyy') as TANGGALLAHIR, 
				(SELECT NAMAPEKERJAAN FROM JAIM_400_JENIS_PEKERJAAN WHERE KDJENISPEKERJAAN= B.KDJNSPEKERJAAN) NAMA_PEKERJAAN_CTT,
				(SELECT namahobi FROM jaim_301_hobi WHERE kdhobi = B.kdhobi) NAMAHOBICTT,
				(SELECT LIFEEXTRA FROM JAIM_400_JENIS_PEKERJAAN WHERE KDJENISPEKERJAAN= B.KDJNSPEKERJAAN) EKSTRALIFE_CTT,
				(SELECT PAEXTRA FROM JAIM_400_JENIS_PEKERJAAN WHERE KDJENISPEKERJAAN= B.KDJNSPEKERJAAN) EKSTRAPA_CTT,
				(SELECT TPDEXTRA FROM JAIM_400_JENIS_PEKERJAAN WHERE KDJENISPEKERJAAN= B.KDJNSPEKERJAAN) EKSTRATPD_CTT	
			from PRO_TERTANGGUNG B
			where build_id = '".$buildid."'";
	$query2 = $this->db->query($sql2);

	foreach ($query2->result_array() as $rows){
		$usiactt		= $rows['USIA_TH'];
		$usiawpdanspuse = min(65, (65-$usiactt));
		$usiapayor 		= max(0, (25-$usiactt));
	}

	$sqlrawpsp = 'SELECT * FROM JAIM_400_RESIKO_AWAL WHERE npert = '.$usiawpdanspuse;
	$queryrawpsp = $this->db->query($sqlrawpsp);
	foreach ($queryrawpsp->result_array() as $rows){
		$tarifwpdanspuse = str_replace(',', '.', $rows['TARIF']);
	}

	if($usiapayor==0){
		$tarifpayor = 0;
	}else{
		$sqlrapb = 'SELECT * FROM JAIM_400_RESIKO_AWAL WHERE npert = '.$usiapayor;
		$queryrapb = $this->db->query($sqlrapb);
		foreach ($queryrapb->result_array() as $rows){
			$tarifpayor = str_replace(',', '.', $rows['TARIF']);
		}	
	}

	$sql3 = "SELECT * from PRO_ASURANSI_POKOK where build_id = '".$buildid."'";
	$query3 = $this->db->query($sql3);

	$sql4 = "SELECT a.build_id, b.fundalocname nama_alokasi1, a.alokasi1, c.fundalocname nama_alokasi2, a.alokasi2,
				b.lowpercent bunga_rendah, b.mediumpercent bunga_sedang, b.highpercent bunga_tinggi,
				c.lowpercent bunga_rendah2, c.mediumpercent bunga_sedang2, c.highpercent bunga_tinggi2
			 FROM pro_alokasi_dana a
			 LEFT OUTER JOIN pro_alokasi_fund_new b ON a.nama_alokasi1 = b.fundalocid
			 LEFT OUTER JOIN pro_alokasi_fund_new c ON a.nama_alokasi2 = c.fundalocid
			 WHERE build_id = '$buildid'";
	$query4 = $this->db->query($sql4);

	$sql5 = "SELECT * from JAIM.PRO_DATA_RIDER_NEW where build_id = '".$buildid."'";
	$query5 = $this->db->query($sql5);
 
	$sql6 = "SELECT B.JENIS,NAMA,DESKRIPSI,URUT,SU,B.BUILD_ID,B.NILAI UA
            FROM PRO_REDAKSI A, PRO_JUA B
            WHERE a.jenis = b.jenis
            and b.build_id = '".$buildid."' 
            and b.nilai > 0
         order by urut";
    $query6 = $this->db->query($sql6);

	$sql11 = "SELECT *
	          FROM PRO_REDAKSI_PEMERIKSAAN
	          WHERE JENIS_PEMERIKSAAN = (select PEMERIKSAAN from PRO_ASURANSI_POKOK where build_id = '$buildid') ";
	$query11 = $this->db->query($sql11);

	//UNTUK MENGHAPUS DATA ILUSTRASI INVESTASI JIKA SEBELUMNYA ADA
	$sqlcek = "SELECT * FROM JAIM.PRO_TOTAL_INVESTASI1 WHERE build_id= '$buildid' ";
	$querycek = $this->db->query($sqlcek);
	$jml_row = $querycek->num_rows;
	if($jml_row == 0){
		
	}else{
		$sqldel = "DELETE FROM JAIM.PRO_TOTAL_INVESTASI1 WHERE build_id= '$buildid' ";
		$querydel = $this->db->query($sqldel);
	}

	//UNTUK MENGHAPUS DATA PRO JUA NEW JIKA SEBELUMNYA ADA
	$sqlcekprojua = "SELECT * FROM JAIM.PRO_JUA_NEW WHERE build_id= '$buildid' ";
	$querycekprojua = $this->db->query($sqlcekprojua);
	$jml_row_pro_jua = $querycekprojua->num_rows;
	if($jml_row_pro_jua == 0){

	}else{
		$sqldelprojua = "DELETE FROM JAIM.PRO_JUA_NEW WHERE build_id= '$buildid' ";
		$querydelprojua = $this->db->query($sqldelprojua);
	}

?>
<style>
	table, td, th {
	    border: 1px solid black;
	}

	table {
	    border-collapse: collapse;
	    width: 100%;
	}

	th {
	    height: 50px;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


<!-- BEGIN PAGE CONTENT-->
<div class="" id="Testis">
	<div class="row" align="center">
		<div class="col-xs-12">
			<div class="well">
				<address>
				Illustrasi ini hanya merupakan pendekatan/proyeksi dari jumlah dana yang diinvestasikan dan bukan merupakan bagian dari kontrak asuransi
				<address>
			</div>
		</div>
	 </div>
	<div class="row invoice-logo">
		<div class="col-xs-5" align="justify">
			<p>
				 <h4>PT. ASURANSI JIWA IFG LIFE</h4>
			</p>
		</div>
		Graha CIMB Niaga Lt. 6, Jl. Jend. Sudirman Kav 58 Jakarta - 12190
		<div class="col-xs-7 invoice-logo-space" align="right">
			<img src="<?php echo base_url(); ?>/assets/img/logo-js.png" alt=""/>
		</div>
	</div>
	&nbsp;
	<div class="row" align="center">
		<div class="col-xs-12">
			<input id="buildid" name="buildid" value="<?=$_GET['buildid'] ?>" style="display: none"></input>
			<div class="well" style="font-weight:bold;font-size:16px">
				
				<!--- Tambahan Produk LPP -->
				<?php

					$txt = '';

					if($kodeproduk == 'JL4BPRO'){
						$txt = 'IFG LIFE PROTECTION PLATINUM';
					} else {
						$txt = 'IFG LIFE PRIME PROTECTION';
					}  
				?>
				<?= $txt; ?>
				<!--- End Of Era -->

			</div>
		</div>
	 </div>
	<hr/>
	<div class="row">
		<div class="col-xs-12">			
			<?php
				foreach ($query->result_array() as $row)
				{
					$usia_cpp = $row['USIA_TH'];
					$jeniskelamincpp = $row['JENIS_KELAMIN'];
					$nilaiekstrapremilife_cpp = $row['EKSTRALIFE_CPP'];
					$nilaiekstrapremipa_cpp = $row['EKSTRAPA_CPP'];
					$nilaiekstrapremitpd_cpp = $row['EKSTRATPD_CPP'];
					if($nilaiekstrapremilife_cpp !=0){
						$tandaextrapremi_life_cpp = '*';
					}else{
						$tandaextrapremi_life_cpp = '';
					}
					if($nilaiekstrapremipa_cpp !=0){
						$tandaextrapremi_pa_cpp = '*';
					}else{
						$tandaextrapremi_pa_cpp = '';
					}
					if($nilaiekstrapremitpd_cpp !=0){
						$tandaextrapremi_tpd_cpp = '*';
					}else{
						$tandaextrapremi_tpd_cpp = '';
					}
			?>
			<div class="well" style="font-weight:bold;font-size:18px">
				CALON PEMEGANG POLIS
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover">			
					<tbody>
						<tr>
							<td align="justify" style="font-size:18px" width="180px">Nama Pemegang Polis </td>
							<td align="center" style="font-size:18px" width="10px">:</td>
							<td align="left" style="font-size:18px" width="60px"><?=$row['NAMA'];?></td>						
						</tr>
						<tr>
							<td align="justify" style="font-size:18px">Tanggal Lahir </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px"><?=date('d/m/Y',strtotime($row['TGL_LAHIR']));?></td>
						</tr>
						<tr>
							<td align="justify" style="font-size:18px">Jenis Kelamin </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px"><?=($row['JENIS_KELAMIN'] == 'M' ? 'Laki-Laki' : 'Perempuan');?></td>						
						</tr>
						<!-- <tr>
							<td align="justify" style="font-size:18px">Status Perokok </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px"><?=($row['IS_PEROKOK'] == 'T' ? 'Tidak' : 'Ya');?></td>						
						</tr> -->
						<tr>
							<td align="justify" style="font-size:18px">Jenis Pekerjaan </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px"><?=ucwords(strtolower($row['NAMA_PEKERJAAN_CPP']));?></td>						
						</tr>
						<tr>
							<td align="justify" style="font-size:18px">Hobi </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px"><?=ucwords(strtolower($row['NAMAHOBICPP']));?></td>						
						</tr>
					<tbody>
				</table>
			</div>			
			<?php
				}

				/* Fungsi untuk menyimpan extra resiko CPP - Teguh 24/03/2020 */
				$sqli_cpp= "INSERT INTO JAIM.PRO_EXTRA_RESIKO
									(BUILD_ID, STATUS, LIFEEXTRA, PAEXTRA, TPDEXTRA, TGLREKAM)
								VALUES
									('$buildid', 'CPP', '$nilaiekstrapremilife_cpp', '$nilaiekstrapremipa_cpp', '$nilaiekstrapremitpd_cpp', SYSDATE)";
				$queryinsert = $this->db->query($sqli_cpp);
				/* End */
			?>							
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-12">			
			<?php
				foreach ($query2->result_array() as $row)
				{
					$usia_ctt = $row['USIA_TH'];
					$jeniskelaminctt = $row['JENIS_KELAMIN'];
					$perokokcalontertanggung = $row['IS_PEROKOK'];
					$nilaiekstrapremilife_ctt = $row['EKSTRALIFE_CTT'];
					$nilaiekstrapremipa_ctt = $row['EKSTRAPA_CTT'];
					$nilaiekstrapremitpd_ctt = $row['EKSTRATPD_CTT'];
					if($nilaiekstrapremilife_ctt !=0){
						$tandaextrapremi_life = '*';
					}else{
						$tandaextrapremi_life = '';
					}
					if($nilaiekstrapremipa_ctt !=0){
						$tandaextrapremi_pa = '*';
					}else{
						$tandaextrapremi_pa = '';
					}
					if($nilaiekstrapremitpd_ctt !=0){
						$tandaextrapremi_tpd = '*';
					}else{
						$tandaextrapremi_tpd = '';
					}
			?>
			<div class="well" style="font-weight:bold;font-size:18px">
				CALON TERTANGGUNG
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover">			
					<tbody>
						<tr>
							<td align="justify" style="font-size:18px" width="180px">Nama Tertanggung </td>
							<td align="center" style="font-size:18px" width="10px">:</td>
							<td align="left" style="font-size:18px" width="60px"><?=$row['NAMA'];?></td>						
						</tr>
						<tr>
							<td align="justify" style="font-size:18px">Tanggal Lahir </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px"><?=date('d/m/Y',strtotime($row['TGL_LAHIR']));?></td>						
						</tr>
						<tr>
							<td align="justify" style="font-size:18px">Jenis Kelamin </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px"><?=($row['JENIS_KELAMIN'] == 'M' ? 'Laki-Laki' : 'Perempuan');?></td>						
						</tr>
						<!-- <tr>
							<td align="justify" style="font-size:18px">Status Perokok </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px"><?=($row['IS_PEROKOK'] == 'T' ? 'Tidak' : 'Ya');?></td>						
						</tr> -->
						<tr>
							<td align="justify" style="font-size:18px">Jenis Pekerjaan </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px"><?=ucwords(strtolower($row['NAMA_PEKERJAAN_CTT']));?></td>						
						</tr>
						<tr>
							<td align="justify" style="font-size:18px">Hobi </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px"><?=ucwords(strtolower($row['NAMAHOBICTT']));?></td>						
						</tr>
					<tbody>
				</table>
			</div>			
			<?php
				}

				/* Fungsi untuk menyimpan extra resiko CTT - Teguh 24/03/2020 */
				$sqli_ctt= "INSERT INTO JAIM.PRO_EXTRA_RESIKO
									(BUILD_ID, STATUS, LIFEEXTRA, PAEXTRA, TPDEXTRA, TGLREKAM)
								VALUES
									('$buildid', 'CTT', '$nilaiekstrapremilife_ctt', '$nilaiekstrapremipa_ctt', '$nilaiekstrapremitpd_ctt', SYSDATE)";
				$queryinsert = $this->db->query($sqli_ctt);
				/* End */
			?>							
		</div>
	</div>			
	<hr>
	<div class="row">
		<div class="col-xs-12">			
			<?php
				foreach ($query3->result_array() as $row)
				{
					$total_premi	= $row['PREMI_BERKALA'] + $row['TOPUP_BERKALA'];
					$premi_dasar_input    = $row['PREMI_BERKALA'];
					$premi_topup_input    = $row['TOPUP_BERKALA'];
					$carabayar 		= $row['CARA_BAYAR'];
					$topup_sekaligus= $row['TOPUP_SEKALIGUS'];
					$periode_topup_sekaligus = $row['PERIODE_TOPUP'];
					$makstopup		= $usia_ctt + $periode_topup_sekaligus;
			?>
			<div class="well" style="font-weight:bold;font-size:18px">
				DATA PERTANGGUNGAN
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover">			
					<tbody>
						<tr>
							<td align="justify" style="font-size:18px" width="180px">Cara Bayar </td>
							<td align="center" style="font-size:18px" width="10px">:</td>
							<?php 
                                echo '<br><br>1. CARA_BAYAR ' .$row['CARA_BAYAR'];
								if($row['CARA_BAYAR']=='1')
								{
									$row['CARA_BAYAR'] = 'Bulanan';
									$pembagi = 1;
								}
								else if ($row['CARA_BAYAR']=='2')
								{
									$row['CARA_BAYAR'] = 'Tahunan';
									$pembagi = 12;
								}
								else if ($row['CARA_BAYAR']=='3')
								{
									$row['CARA_BAYAR'] = 'Kuartalan';
									$pembagi = 3;
								}
								else if ($row['CARA_BAYAR']=='4')
								{
									$row['CARA_BAYAR'] = 'Semesteran';
									$pembagi = 6;
								}

                                echo '<br><br>2. CARA_BAYAR ' .$row['CARA_BAYAR'];
								
							?>					
							<td align="left" style="font-size:18px" width="60px">&nbsp;&nbsp;<?=$row['CARA_BAYAR'];?></td>						
						</tr>
						<tr>
							<td align="justify" style="font-size:18px">Uang Pertanggungan </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px">&nbsp;&nbsp;<?= number_format($row['UA'],0,',','.');?></td>						
						</tr>
						<tr>
							<td align="justify" style="font-size:18px">Premi Berkala </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px">&nbsp;&nbsp;<?= number_format($row['PREMI_BERKALA'],0,',','.');?></td>						
						</tr>
						<tr>
							<td align="justify" style="font-size:18px">Top Up Berkala </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px">&nbsp;&nbsp;<?= number_format($row['TOPUP_BERKALA'],0,',','.');?></td>						
						</tr>
						<tr>
							<td align="justify" style="font-size:18px">Top Up Sekaligus </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px">&nbsp;&nbsp;<?= number_format($row['TOPUP_SEKALIGUS'],0,',','.');?></td>						
						</tr>
						<tr>
							<td align="justify" style="font-size:18px">Total Premi yang dibayar </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px">&nbsp;&nbsp;<?= number_format($row['PREMI_BERKALA']+$row['TOPUP_BERKALA']+$row['TOPUP_SEKALIGUS'],0,',','.');?></td>						
						</tr>
						<tr>
							<td align="justify" style="font-size:18px">Medical </td>
							<td align="center" style="font-size:18px">:</td>
							<td align="left" style="font-size:18px">&nbsp;&nbsp;<?= ($row['PEMERIKSAAN'] == '' ? 'Tidak' : 'Ya') ;?></td>						
						</tr>							
					<tbody>
				</table>
			</div>			
			<?php
				}
			?>							
		</div>
	</div>
	
	<hr>
	<div class="row">
		<div class="col-xs-12">			
			<div class="well" style="font-weight:bold;font-size:18px">
				ALOKASI DANA INVESTASI (%)
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover">			
					<tbody>
					<?php
						foreach ($query4->result_array() as $row)
						{
						?>		
							<?php
								if ($row['NAMA_ALOKASI1'] != '')
								{
									$alokasi1 = str_replace(',','.',$row['ALOKASI1']);
									$bunga_rendah	= str_replace(',','.',$row['BUNGA_RENDAH']);
									$bunga_sedang	= str_replace(',','.',$row['BUNGA_SEDANG']);
									$bunga_tinggi	= str_replace(',','.',$row['BUNGA_TINGGI']);
							?>
							<tr>
								<td align="justify" style="font-size:18px" width="50px"><?=$row['NAMA_ALOKASI1'];?></td>
								<td align="center" style="font-size:18px" width="1px">:</td>
								<td align="left" style="font-size:18px" width="30px">
								
								<?php /*if (str_replace(',','.',$row['ALOKASI1'])<1) {
									echo str_replace(',','.',$row['ALOKASI1'])*10;
								}
								else
								{*/
									echo str_replace(',','.',$row['ALOKASI1'])*100;
								//}
								?>%
								</td>						
							</tr>
								<?php
									}
								?>	
								<?php
									if ($row['NAMA_ALOKASI2'] != '')
									{
										$alokasi2 = str_replace(',','.',$row['ALOKASI2']);
										$bunga_rendah2	= str_replace(',','.',$row['BUNGA_RENDAH2']);
										$bunga_sedang2	= str_replace(',','.',$row['BUNGA_SEDANG2']);
										$bunga_tinggi2	= str_replace(',','.',$row['BUNGA_TINGGI2']);
								?>	
							<tr>
								<td align="justify" style="font-size:18px" width="50px"><?=$row['NAMA_ALOKASI2'];?></td>
								<td align="center" style="font-size:18px" width="1px">:</td>
								<td align="left" style="font-size:18px" width="50px">
								<?php /*if ($row['ALOKASI2']<1) {
									echo str_replace(',','',$row['ALOKASI2'])*10;
								}
								else
								{*/
									echo str_replace(',','.',$row['ALOKASI2'])*100;
								//}
								?>%
								</td>						
							</tr>	
								<?php
									}
								?>	
						<?php
						}
						?>	
					</tbody>
				</table>
			</div>	
		</div>
	</div>	

	<hr>
	<div class="row">
		<div class="col-xs-12">			
			<div class="well" style="font-weight:bold;font-size:18px">
				BIAYA ASURANSI
			</div>
				<div class="table-responsive">
					<table class="table table-striped table-hover">			
						<tbody>
							<tr>
								<td align="center" style="font-size:18px;font-weight:bold; " width="280px">NAMA ASURANSI</td>
								<td align="center" style="font-size:18px;font-weight:bold; " width="280px">SAMPAI USIA TERTANGGUNG</td>
								<td align="center" style="font-size:18px;font-weight:bold; " width="280px">UANG ASURANSI</td>
								<td align="center" style="font-size:18px;font-weight:bold; " width="280px">BIAYA ASURANSI PER BULAN</td>
								<td align="center" style="font-size:18px;font-weight:bold; " width="280px">PENGAKUAN RESIKO AWAL</td>
								<td align="center" style="font-size:18px;font-weight:bold; " width="280px">RESIKO AWAL</td>
							</tr>
						<?php
						foreach ($query5->result_array() as $row)
						{
							$ua_dasar	= $row['UADASAR'];
							$ua_ci53	= $row['CI53'];
							$ua_addb	= $row['ADDB'];
							$ua_adb		= $row['ADB'];
							$ua_hcp		= $row['IS_HCP'];
							$ua_tpd		= $row['TPD'];
							$ua_tr		= $row['TR'];
							$ua_pbd		= $row['PBD'];
							$ua_pbci	= $row['PBCI'];
							$ua_pbtpd	= $row['PBTPD'];
							$ua_spd		= $row['SPD'];
							$ua_spci	= $row['SPCI'];
							$ua_sptpd	= $row['SPTPD'];
							$ua_wpci51	= $row['WPCI51'];
							$ua_wptpd	= $row['WPTPD'];

							if($row['IS_UADASAR']==1){
								echo "<tr>
										<td>Asuransi Dasar ".$tandaextrapremi_life."</td>
										<td align='center'>99</td>
										<td align='right'>".number_format($row['UADASAR'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_UADASAR'],0,',','.')."</td>
										<td align='center'>100%</td>
										<td align='right'>".number_format($row['UADASAR'],0,',','.')."</td>
									</tr>";
								$sqlinsertdasar = "
											INSERT ALL
												INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 					VALUES ('$buildid', 'JL4BLN', 'DEATHMA', $premi_dasar_input, ".$row['UADASAR'].", 'W')
							 					INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 					VALUES ('$buildid', 'JL4BLN', 'COSADMJL', '', '', 'W')
							 					INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 					VALUES ('$buildid', 'JL4BLN', 'COA', '', '', 'I')
							 					INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 					VALUES ('$buildid', 'JL4BLN', 'COI', '', '', 'I')
							 					INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 					VALUES ('$buildid', 'JL4BLN', 'BNFTOPUP', $premi_topup_input, '', 'T')
							 				SELECT * FROM DUAL";
								$queryinsertdasar = $this->db->query($sqlinsertdasar);
							}
							if($row['IS_CI53']!=0){
								echo "<tr>
										<td>IFG Critical Illness 53 (IFG CI 53)</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['CI53'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_CI53'],0,',','.')."</td>
										<td align='center'>50%</td>
										<td align='right'>".number_format($row['CI53']/2,0,',','.')."</td>
									</tr>";
								$sqlinsertriderci53 = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'CI53', ".$row['BIAYA_CI53'].", ".$row['CI53'].", 'R')";
								$queryinsertriderci53 = $this->db->query($sqlinsertriderci53);
							}
							if($row['IS_ADDB']!=0){
								echo "<tr>
										<td>IFG Accidental Death Dissmemberment Benefit (ADDB) ".$tandaextrapremi_pa."</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['ADDB'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_ADDB'],0,',','.')."</td>
										<td align='center'>0%</td>
										<td align='right'>0</td>
									</tr>";
								$sqlinsertrideraddb = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'ADDB', ".$row['BIAYA_ADDB'].", ".$row['ADDB'].", 'R')";
								$queryinsertrideraddb = $this->db->query($sqlinsertrideraddb);
							}
							if($row['IS_ADB']!=0){
								echo "<tr>
										<td>IFG Accident Death Benefit (IFG ADB) ".$tandaextrapremi_pa."</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['ADB'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_ADB'],0,',','.')."</td>
										<td align='center'>0%</td>
										<td align='right'>0</td>
									</tr>";
								$sqlinsertrideradb = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'ADB', ".$row['BIAYA_ADB'].", ".$row['ADB'].", 'R')";
								$queryinsertrideradb = $this->db->query($sqlinsertrideradb);
							}
							if($row['IS_HCP']!=0){
								echo "<tr>
										<td>IFG Hospital Cash Plan (IFG HCP)</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['HCP'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_HCP'],0,',','.')."</td>
										<td align='center'>0%</td>
										<td align='right'>0</td>
									</tr>";
								$jnshcp = $row['IS_HCP'];
								$uahcpb = $row['HCP'] * 10;
								$sqlinsertriderhcp = "INSERT ALL
												INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 					VALUES ('$buildid', 'JL4BLN', 'CPM".$jnshcp."00RWI', ".$row['BIAYA_HCP'].", ".$row['HCP'].", 'R')
							 					INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 					VALUES ('$buildid', 'JL4BLN', 'CPM".$jnshcp."00ICU', '', '', 'R')
							 					INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 					VALUES ('$buildid', 'JL4BLN', 'CPB".$jnshcp."000BDH', '', '$uahcpb', 'R')
							 				SELECT * FROM DUAL";
								$queryinsertriderhcp = $this->db->query($sqlinsertriderhcp);
							}
							if($row['IS_TPD']!=0){
								echo "<tr>
										<td>IFG Total Permanent Dissability (IFG TPD) ".$tandaextrapremi_tpd."</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['TPD'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_TPD'],0,',','.')."</td>
										<td align='center'>50%</td>
										<td align='right'>".number_format($row['TPD']/2,0,',','.')."</td>
									</tr>";
								$sqlinsertridertpd = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'TPD', ".$row['BIAYA_TPD'].", ".$row['TPD'].", 'R')";
								$queryinsertridertpd = $this->db->query($sqlinsertridertpd);
							}
							if($row['IS_TR']!=0){
								echo "<tr>
										<td>IFG Term Rider (IFG TR) ".$tandaextrapremi_life."</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['TR'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_TR'],0,',','.')."</td>
										<td align='center'>100%</td>
										<td align='right'>".number_format($row['TR'],0,',','.')."</td>
									</tr>";
								$sqlinsertridertr = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'TI', ".$row['BIAYA_TR'].", ".$row['TR'].", 'R')";
								$queryinsertridertr = $this->db->query($sqlinsertridertr);
							}
							if($row['IS_PBD']!=0){
								echo "<tr>
										<td>IFG Payor Death Benefit (IFG PB-D) ".$tandaextrapremi_life_cpp."</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['PBD'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_PBD'],0,',','.')."</td>
										<td align='center'>100%</td>
										<td align='right'>".number_format($row['PBD']*$tarifpayor/1000,0,',','.')."</td>
									</tr>";
								$sqlinsertriderpbd = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'PBD', ".$row['BIAYA_PBD'].", ".$row['PBD'].", 'R')";
								$queryinsertriderpbd = $this->db->query($sqlinsertriderpbd);
							}
							if($row['IS_PBCI']!=0){
								echo "<tr>
										<td>IFG Payor Benefit Critical Illness (IFG PB-CI)</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['PBCI'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_PBCI'],0,',','.')."</td>
										<td align='center'>100%</td>
										<td align='right'>".number_format($row['PBCI']*$tarifpayor/1000,0,',','.')."</td>
									</tr>";
								$sqlinsertriderpbci = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'PBCI', ".$row['BIAYA_PBCI'].", ".$row['PBCI'].", 'R')";
								$queryinsertriderpbci = $this->db->query($sqlinsertriderpbci);
							}
							if($row['IS_PBTPD']!=0){
								echo "<tr>
										<td>IFG Payor Total Permanent Dissability (IFG PB-TPD) ".$tandaextrapremi_tpd_cpp."</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['PBTPD'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_PBTPD'],0,',','.')."</td>
										<td align='center'>100%</td>
										<td align='right'>".number_format($row['PBTPD']*$tarifpayor/1000,0,',','.')."</td>
									</tr>";
								$sqlinsertriderpbtpd = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'PBTPD', ".$row['BIAYA_PBTPD'].", ".$row['PBTPD'].", 'R')";
								$queryinsertriderpbtpd = $this->db->query($sqlinsertriderpbtpd);
							}
							if($row['IS_SPD']!=0){
								echo "<tr>
										<td>IFG Spouse Payor Death Benefit (IFG SP-D) ".$tandaextrapremi_life_cpp."</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['SPD'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_SPD'],0,',','.')."</td>
										<td align='center'>100%</td>
										<td align='right'>".number_format($row['SPD']*$tarifwpdanspuse/1000,0,',','.')."</td>
									</tr>";
								$sqlinsertriderspd = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'SPBD', ".$row['BIAYA_SPD'].", ".$row['SPD'].", 'R')";
								$queryinsertriderspd = $this->db->query($sqlinsertriderspd);
							}
							if($row['IS_SPCI']!=0){
								echo "<tr>
										<td>IFG Spouse Payor Critical Illness (IFG SP-CI)</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['SPCI'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_SPCI'],0,',','.')."</td>
										<td align='center'>100%</td>
										<td align='right'>".number_format($row['SPCI']*$tarifwpdanspuse/1000,0,',','.')."</td>
									</tr>";
								$sqlinsertriderspci = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'SPBCI', ".$row['BIAYA_SPCI'].", ".$row['SPCI'].", 'R')";
								$queryinsertriderspci = $this->db->query($sqlinsertriderspci);
							}
							if($row['IS_SPTPD']!=0){
								echo "<tr>
										<td>IFG Spouse Payor Total Permanent Dissability (IFG SP-TPD) ".$tandaextrapremi_tpd_cpp."</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['SPTPD'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_SPTPD'],0,',','.')."</td>
										<td align='center'>100%</td>
										<td align='right'>".number_format($row['SPTPD']*$tarifwpdanspuse/1000,0,',','.')."</td>
									</tr>";
								$sqlinsertridersptpd = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'SPTPD', ".$row['BIAYA_SPTPD'].", ".$row['SPTPD'].", 'R')";
								$queryinsertridersptpd = $this->db->query($sqlinsertridersptpd);
							}
							if($row['IS_WPCI51']!=0){
								echo "<tr>
										<td>IFG Waiver of Premium Critical Illness 51 (IFG WP CI 51)</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['WPCI51'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_WPCI51'],0,',','.')."</td>
										<td align='center'>100%</td>
										<td align='right'>".number_format($row['WPCI51']*$tarifwpdanspuse/1000,0,',','.')."</td>
									</tr>";
								$sqlinsertriderwpci51 = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'WPCI51', ".$row['BIAYA_WPCI51'].", ".$row['WPCI51'].", 'R')";
								$queryinsertriderwpci51 = $this->db->query($sqlinsertriderwpci51);
							}
							if($row['IS_WPTPD']!=0){
								echo "<tr>
										<td>IFG Waiver of Premium Total Permanent Dissability (IFG WP-TPD) ".$tandaextrapremi_tpd."</td>
										<td align='center'>65</td>
										<td align='right'>".number_format($row['WPTPD'],0,',','.')."</td>
										<td align='right'>".number_format($row['BIAYA_WPTPD'],0,',','.')."</td>
										<td align='center'>100%</td>
										<td align='right'>".number_format($row['WPTPD']*$tarifwpdanspuse/1000,0,',','.')."</td>
									</tr>";
								$sqlinsertriderwptpd = "INSERT INTO JAIM.PRO_JUA_NEW (BUILD_ID, KDPRODUK, KDBENEFIT, PREMI, NILAIBENEFIT, KDJENISBENEFIT)
							 						VALUES ('$buildid', 'JL4BLN', 'WPTPD', ".$row['BIAYA_WPTPD'].", ".$row['WPTPD'].", 'R')";
								$queryinsertriderwptpd = $this->db->query($sqlinsertriderwptpd);
							}

							$total_ua = $row['UADASAR'] + $row['CI53'] + $row['ADDB'] + $row['ADB'] + $row['HCP'] + $row['TPD'] + $row['TR'] + $row['PBD'] + $row['PBCI'] + $row['PBTPD'] + $row['SPD'] + $row['SPCI'] + $row['SPTPD'] + $row['WPTPD'] + $row['WPCI51'];
							$total_biaya_new = $row['BIAYA_UADASAR'] + $row['BIAYA_CI53'] + $row['BIAYA_ADDB'] + $row['BIAYA_ADB'] + $row['BIAYA_HCP'] + $row['BIAYA_TPD'] + $row['BIAYA_TR'] + $row['BIAYA_PBD'] + $row['BIAYA_PBCI'] + $row['BIAYA_PBTPD'] + $row['BIAYA_SPD'] + $row['BIAYA_SPCI'] + $row['BIAYA_SPTPD'] + $row['BIAYA_WPTPD'] + $row['BIAYA_WPCI51'];
							$total_ra = $row['UADASAR'] + ($row['CI53']/2) + ($row['TPD']/2) + $row['TR'] + max(($row['PBD']*$tarifpayor/1000), ($row['PBCI']*$tarifpayor/1000), ($row['PBTPD']*$tarifpayor/1000), ($row['SPD']*$tarifwpdanspuse/1000), ($row['SPCI']*$tarifwpdanspuse/1000), ($row['SPTPD']*$tarifwpdanspuse/1000), ($row['WPTPD']*$tarifwpdanspuse/1000), ($row['WPCI51']*$tarifwpdanspuse/1000));
						?>	

						<?php
						}
						?>		
						<tr>
							<td align='center' colspan="2"><b>TOTAL</b></td>
							<td align='right'><?php echo number_format($total_ua,0,',','.');?></td>
							<td align='right'><?php echo number_format($total_biaya_new,0,',','.');?></td>
							<td align='center'></td>
							<td align='right'><?php echo number_format($total_ra,0,',','.');?></td>
						</tr>
					</tbody>
				</table>
			</div>	
		</div>
	</div>	
	
	<hr>
	<div class="row">
		<div class="col-xs-12">			
			<div class="well" style="font-weight:bold;font-size:18px">
				DATA PEMERIKSAAN MEDICAL
			</div>
				<div class="table-responsive">
					<table class="table table-striped table-hover">			
						<tbody>
							<tr>
<!--							<td align="center" style="font-size:18px;font-weight:bold; " width="30px">ID</td>-->
								<td align="center" style="font-size:18px;font-weight:bold; " width="30px">PEMERIKSAAN</td>								
							</tr>
						
							<tr>
								<?php
									foreach ($query11->result_array() as $row)
								{	
								?>	
	<!--							<td align="center" style="font-size:18px" width="30px"><?=$row['ID'];?></td>-->
									<td style="font-size:18px" align="justify">
										<?php
										echo $row['REDAKSI'];
										if ($row['SUBID'] <> ''){
											$sqlsub = "SELECT *
													  FROM PRO_SUB_REDAKSI_PEMERIKSAAN 
													  WHERE ID = '".$row['ID']."' ";
											$querysub = $this->db->query($sqlsub);
											echo '<ol>';
												foreach ($querysub->result_array() as $rowx)
												{
													echo '<li>'.$rowx['REDAKSI'].'</li>';
												}
											echo '</ol>';
											echo "<i>HbsAg*) Langsung dilakukan pemeriksaan HbeAg apabila hasil HbsAg adalah positif</i>";
										}
								?>
									</td>
							</tr>	
						<?php								
						}
						?>									
					</tbody>
				</table>
			</div>	
		</div>
	</div>
	
	<hr>
	<div class="row" align="center">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
					<br>
					<tr>
						<th>

						</th>
						<th>
							 KETERANGAN MANFAAT ASURANSI 
						</th>
					</tr>
					</thead>
					<tbody>
						<?php
							foreach ($query6->result_array() as $row)
								{	
									$desc = '';
									if($row['NAMA'] == 'Asuransi Dasar'){
										if($kodeproduk == 'JL4BPRO'){
											$desc = substr($row['DESKRIPSI'], 0, -26)."IFG Life Protection Platinum";
										}else{
											$desc = $row['DESKRIPSI'];
										}
									}else{
										$desc = $row['DESKRIPSI'];
									}

									echo "<tr>
											<td align='justify'>".$row['NAMA']."</td>
											<td align='justify'>".$desc."</td>
										</tr>";
								}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<br><br><br><hr>
			
		<!-- Fungsi Untuk Menghitung Ilustasi -->
			<?php
				$coa = 27500;
				$usia= $usia_ctt;
				$premi_dasar=0.7*$total_premi;
				$topup_dasar=0.3*$total_premi;
				$tahun_ke = 1;
                /* tracing 6/3/23            
                echo '<br><br>init '.$y;

                        echo 
                        "<br>ua_dasar $ua_dasar ".
                        "<br>total_premi $total_premi ".
                        "<br>premi_dasar $premi_dasar ".
                        "<br>topup_dasar $topup_dasar ".
                        "<br>usia_ctt $usia_ctt ";
                */            
                while($usia <= 99) {

					$sqltarif = "SELECT * 
								FROM JAIM.JAIM_300_TARIF_PREMI 
								WHERE kdproduk = 'JL4BIFG' 
								AND usia = ".$usia;
					// echo $sqltarif;
					$querytarif = $this->db->query($sqltarif);
					foreach ($querytarif->result_array() as $tarif){
						if($jeniskelaminctt == 'M'){
							$tariftermlife = str_replace(',', '.', $tarif['TERMLIFE_L']);
						}else{
							$tariftermlife = str_replace(',', '.', $tarif['TERMLIFE_P']);
						}


						// Mencari tarif untuk UA DASAR dan RIDER TERM
						if($perokokcalontertanggung == 'T'){
							// $tariftermlife = str_replace(',', '.', $tarif['TERMLIFE_NONSMOKER']);
							$tariftermrider = str_replace(',', '.', $tarif['TERMRIDER_NONSMOKER']);
						}else{
							// $tariftermlife = str_replace(',', '.', $tarif['TERMLIFE_SMOKER']);
							$tariftermrider = str_replace(',', '.', $tarif['TERMRIDER_SMOKER']);
						}
						//Mencari tarif HCP
						if($ua_hcp == 1 && $jeniskelaminctt == 'M'){
							$tarifriderjshcp = $tarif['HCP_L_100'];
						}else if($ua_hcp == 2 && $jeniskelaminctt == 'M'){
							$tarifriderjshcp = $tarif['HCP_L_200'];
						}else if($ua_hcp == 3 && $jeniskelaminctt == 'M'){
							$tarifriderjshcp = $tarif['HCP_L_300'];
						}else if($ua_hcp == 4 && $jeniskelaminctt == 'M'){
							$tarifriderjshcp = $tarif['HCP_L_400'];
						}else if($ua_hcp == 5 && $jeniskelaminctt == 'M'){
							$tarifriderjshcp = $tarif['HCP_L_500'];
						}else if($ua_hcp == 6 && $jeniskelaminctt == 'M'){
							$tarifriderjshcp = $tarif['HCP_L_600'];
						}else if($ua_hcp == 7 && $jeniskelaminctt == 'M'){
							$tarifriderjshcp = $tarif['HCP_L_700'];
						}else if($ua_hcp == 8 && $jeniskelaminctt == 'M'){
							$tarifriderjshcp = $tarif['HCP_L_800'];
						}else if($ua_hcp == 9 && $jeniskelaminctt == 'M'){
							$tarifriderjshcp = $tarif['HCP_L_900'];
						}else if($ua_hcp == 10 && $jeniskelaminctt == 'M'){
							$tarifriderjshcp = $tarif['HCP_L_1000'];
						}else if($ua_hcp == 1 && $jeniskelaminctt == 'F'){
							$tarifriderjshcp = $tarif['HCP_P_100'];
						}else if($ua_hcp == 2 && $jeniskelaminctt == 'F'){
							$tarifriderjshcp = $tarif['HCP_P_200'];
						}else if($ua_hcp == 3 && $jeniskelaminctt == 'F'){
							$tarifriderjshcp = $tarif['HCP_P_300'];
						}else if($ua_hcp == 4 && $jeniskelaminctt == 'F'){
							$tarifriderjshcp = $tarif['HCP_P_400'];
						}else if($ua_hcp == 5 && $jeniskelaminctt == 'F'){
							$tarifriderjshcp = $tarif['HCP_P_500'];
						}else if($ua_hcp == 6 && $jeniskelaminctt == 'F'){
							$tarifriderjshcp = $tarif['HCP_P_600'];
						}else if($ua_hcp == 7 && $jeniskelaminctt == 'F'){
							$tarifriderjshcp = $tarif['HCP_P_700'];
						}else if($ua_hcp == 8 && $jeniskelaminctt == 'F'){
							$tarifriderjshcp = $tarif['HCP_P_800'];
						}else if($ua_hcp == 9 && $jeniskelaminctt == 'F'){
							$tarifriderjshcp = $tarif['HCP_P_900'];
						}else if($ua_hcp == 10 && $jeniskelaminctt == 'F'){
							$tarifriderjshcp = $tarif['HCP_P_1000'];
						}else if($ua_hcp == 0){
							$tarifriderjshcp = "0,0";
						}
						$tarifriderjshcp_	= str_replace(',', '.', $tarifriderjshcp);
						$tarifriderjsadb 	= str_replace(',', '.', $tarif['ADB']);
						$tarifriderjsci53	= str_replace(',', '.', $tarif['CI53']);
						$tarifriderjswpci51 = str_replace(',', '.', $tarif['WPCI']);
						$tarifriderjstpd 	= str_replace(',', '.', $tarif['TPD']);
						$tarifriderjswptpd 	= str_replace(',', '.', $tarif['WPTPD']);
						$tarifriderjsaddb 	= str_replace(',', '.', $tarif['ADDB']);
					}
					$sqltarif_cpp = "SELECT * 
									FROM JAIM.JAIM_300_TARIF_PREMI 
									WHERE kdproduk = 'JL4BIFG' 
									AND usia = ".$usia_cpp;
					$querytarif_cpp = $this->db->query($sqltarif_cpp);
					foreach ($querytarif_cpp->result_array() as $tarif_cpp){
						if($usia_cpp > 64 || $usia > 24){
							$tarifriderjspbd 	= 0;
							$tarifriderjspbci 	= 0;
							$tarifriderjspbtpd 	= 0;
						}else{
							$tarifriderjspbd 	= str_replace(',', '.', $tarif_cpp['PBDEATH']);
							$tarifriderjspbci 	= str_replace(',', '.', $tarif_cpp['PBCI']);
							$tarifriderjspbtpd 	= str_replace(',', '.', $tarif_cpp['PBTPD']);
						}
						$tarifriderjsspd 	= str_replace(',', '.', $tarif_cpp['SPDEATH']);
						$tarifriderjsspci 	= str_replace(',', '.', $tarif_cpp['SPCI']);
						$tarifriderjssptpd 	= str_replace(',', '.', $tarif_cpp['SPTPD']);
					}
                    /* tracing 6/3/23 
                    echo 
                        "<br>kedua premi_dasar $premi_dasar ".
                        "<br>topup_dasar $topup_dasar ".
                        "<br>ua_dasar $ua_dasar ".
                        "<br>usia_ctt $usia_ctt ".

                        "<br>nilaiekstrapremilife_ctt $nilaiekstrapremilife_ctt ".

                        "<br>nilaiekstrapremipa_ctt $nilaiekstrapremilife_ctt ".
                        
                        "<br>tariftermlife $tariftermlife ";
                        */        
					for ($y = 1; $y <= 12; $y++) {

							$biaya_coa 		= $coa;
							$biaya_dasar	= ($ua_dasar*($nilaiekstrapremilife_ctt+$tariftermlife)/12/1000);
							$biaya_ci53		= $ua_ci53*$tarifriderjsci53/1/1000;	
							$biaya_adb		= $ua_adb*$tarifriderjsadb/1/1000*(1+($nilaiekstrapremipa_ctt/100));
							$biaya_addb 	= $ua_addb*$tarifriderjsaddb/1/1000*(1+($nilaiekstrapremipa_ctt/100));
							$biaya_hcp		= $tarifriderjshcp_ / 1;
							$biaya_tpd		= $ua_tpd*$tarifriderjstpd/1/1000*(1+($nilaiekstrapremitpd_ctt/100));
							$biaya_jstr		= $ua_tr*($nilaiekstrapremilife_ctt+$tariftermrider)/1/1000;
							$biaya_pbd		= $ua_pbd*($nilaiekstrapremilife_cpp+$tarifriderjspbd)/1/100;
							$biaya_pbci 	= $ua_pbci*$tarifriderjspbci/1/100;
							$biaya_pbtpd	= $ua_pbtpd*$tarifriderjspbtpd/1/100*(1+($nilaiekstrapremitpd_cpp/100));
							$biaya_spd		= $ua_spd*($nilaiekstrapremilife_cpp+$tarifriderjsspd)/1/100;
							$biaya_spci		= $ua_spci*$tarifriderjsspci/1/100;
							$biaya_sptpd	= $ua_sptpd*$tarifriderjssptpd/1/100*(1+($nilaiekstrapremitpd_cpp/100));
							$biaya_wpci51	= $ua_wpci51*$tarifriderjswpci51/1/100;
							$biaya_wptpd	= $ua_wptpd*$tarifriderjswptpd/1/100*(1+($nilaiekstrapremitpd_ctt/100));
							$total_biaya	= $biaya_coa + $biaya_dasar + $biaya_ci53 + $biaya_adb + $biaya_addb + $biaya_hcp + $biaya_tpd + $biaya_jstr + $biaya_pbd + $biaya_pbci + $biaya_pbtpd + $biaya_spd + $biaya_spci + $biaya_sptpd + $biaya_wpci51 + $biaya_wptpd;
						//}

                        /* tracing 6/3/23 
                        echo '<br><br>tracing bulan '.$y;
                        echo 
                        "<br>biaya_dasar $biaya_dasar ".
                        "<br>biaya_ci53 $biaya_ci53 ".
                        "<br>biaya_adb $biaya_adb ".
                        "<br>biaya_addb $biaya_addb ".
                        "<br>biaya_hcp $biaya_hcp ".
                        "<br>biaya_jstr $biaya_jstr ".
                        "<br>biaya_pbd $biaya_pbd ".
                        "<br>biaya_pbci $biaya_pbci ".
                        "<br>biaya_pbtpd $biaya_pbtpd ".
                        
                        
                        "<br>biaya_spd $biaya_spd ".
                        "<br>biaya_spci $biaya_spci ".
                        "<br>biaya_sptpd $biaya_sptpd ".
                        
                        
                        "<br>biaya_wpci51 $biaya_wpci51 ".
                        "<br>biaya_wptpd $biaya_wptpd ".
                        "<br>total_biaya $total_biaya ";
 
                        echo '<br><br>pembagi '.$pembagi;
                        echo '<br><br>makstopup '.$makstopup;
                       */
						if($y==12){
							if($carabayar==1){
								$iuran = 12*$total_premi;
							}else{
								$iuran = $total_premi;
							}
							//$background = "style='background-color: yellow'";
							if($usia < $makstopup){
								$topup_x= $topup_sekaligus;
							}else{
								$topup_x = 0;
							}
						}else{
							$iuran = 0;
							$topup_x = 0;
							//$background = "";
						}

                        /* tracing 6/3/23 
                        echo '<br><br>carabayar '.$carabayar;
                        */
						if($carabayar ==1){
                            //echo '<br><br>masuk carabayar == 1';
							//$akuisisi_topup = 0.05*$topup_dasar;
							//$alokasi_topup = 0.95*$topup_dasar;

							/* Salman 6/3/23
                            $akuisisi_topup = 0*$topup_dasar;
							$alokasi_topup = 1*$topup_dasar;
							*/ 

                            $akuisisi_topup = 0.05*$topup_dasar;
							$alokasi_topup = 0.95*$topup_dasar;

                            /* tracing 6/3/23 */
                            echo '<br><br>k alokasi_topup '.$alokasi_topup;
                            

							if($y==1){
								if($usia < $makstopup){
									//$akuisisi_topup_x = 0.05*$topup_sekaligus;
									//$alokasi_topup_x = 0.95*$topup_sekaligus;
                                    /* -- Salman 6/3/23
									$akuisisi_topup = 0*$topup_sekaligus;
									$alokasi_topup = 1*$topup_sekaligus;
                                    */
                                    $akuisisi_topup_x = 0*$topup_sekaligus;
									$alokasi_topup_x = 1*$topup_sekaligus;
								}else{
									$akuisisi_topup_x = 0;
									$alokasi_topup_x = 0;
								}
							}else{
								$akuisisi_topup_x = 0;
								$alokasi_topup_x = 0;
							}

                            /* tracing 6/3/23 */
                            echo '<br><br>kedua alokasi_topup '.$alokasi_topup;
                            

							// if($tahun_ke == 1){
							// 	$akuisisi_premi_dasar = 0.4*$premi_dasar;
							// 	$alokasi_premi_dasar = 0.6*$premi_dasar;
							// }else if($tahun_ke == 2){
							// 	$akuisisi_premi_dasar = 0.4*$premi_dasar;
							// 	$alokasi_premi_dasar = 0.6*$premi_dasar;
							// }

							if($tahun_ke == 1){
								$akuisisi_premi_dasar = 0.4*$premi_dasar;
								$alokasi_premi_dasar = 0.6*$premi_dasar;
							}
							else if($tahun_ke == 2){
								$akuisisi_premi_dasar = 0.4*$premi_dasar;
								$alokasi_premi_dasar = 0.6*$premi_dasar;
							}else if($tahun_ke == 3){
								$akuisisi_premi_dasar = 0.4*$premi_dasar;
								$alokasi_premi_dasar = 0.6*$premi_dasar;
							}else if($tahun_ke == 4){
								$akuisisi_premi_dasar = 0.2*$premi_dasar;
								$alokasi_premi_dasar = 0.8*$premi_dasar;
							}else if($tahun_ke == 5){
								$akuisisi_premi_dasar = 0.2*$premi_dasar;
								$alokasi_premi_dasar = 0.8*$premi_dasar;
							}else{
								$akuisisi_premi_dasar = 0*$premi_dasar;
								$alokasi_premi_dasar = 1*$premi_dasar;
							}

							$alokasi_total = $alokasi_premi_dasar + $alokasi_topup + $alokasi_topup_x;
							/* tracing 6/3/23 */
                            echo 
                            "<br><br>tracing alokasi_premi_dasar $alokasi_premi_dasar".
                            "<br><br>tracing alokasi_topup $alokasi_topup".
                            "<br><br>tracing alokasi_topup_x $alokasi_topup_x".
                            "<br><br>tracing alokasi_total $alokasi_total";
                            
							if($tahun_ke == 1 && $y==1){
								$akumulasi = 0;
								$akumulasi_total = $akumulasi + $alokasi_total;
								$akumulasi = $akumulasi_total;
								//$investasi_rendah = $alokasi_total * (1+($bunga_rendah/12));
								//$investasi_sedang = $alokasi_total * (1+($bunga_sedang/12));
								//$investasi_tinggi = $alokasi_total * (1+($bunga_tinggi/12));

                                //$investasi_rendah = (($alokasi_total+$hasil_invetasi_rendah_old-$total_biaya) * (1+($bunga_rendah/12)) * $alokasi1) + (($alokasi_total+$hasil_invetasi_rendah_old-$total_biaya) * (1+($bunga_rendah2/12)) * $alokasi2);
								
                                /* Salman 6/3/23
								$investasi_rendah = ($alokasi_total * (1+($bunga_rendah/12)) * $alokasi1) + ($alokasi_total * (1+($bunga_rendah2/12)) * $alokasi2);
								$investasi_sedang = ($alokasi_total * (1+($bunga_sedang/12)) * $alokasi1) + ($alokasi_total * (1+($bunga_sedang2/12)) * $alokasi2);
								$investasi_tinggi = ($alokasi_total * (1+($bunga_tinggi/12)) * $alokasi1) + ($alokasi_total * (1+($bunga_tinggi2/12)) * $alokasi2);
								*/

                                $investasi_rendah = (($alokasi_total-$total_biaya) * (1+($bunga_rendah/12)) * $alokasi1) + (($alokasi_total-$total_biaya) * (1+($bunga_rendah2/12)) * $alokasi2);
                                /* tracing 6/3/23
                                echo 
                                "<br><br>tracing investasi_rendah oke $investasi_rendah".
                                "<br><br>tracing alokasi_total ".($alokasi_total).
                                "<br><br>tracing total_biaya ".($total_biaya).
                                "<br><br>tracing pokok ".($alokasi_total-$total_biaya).
                                "<br><br>tracing bunga ".(1+($bunga_rendah/12));
                                */

								$investasi_sedang = (($alokasi_total-$total_biaya) * (1+($bunga_sedang/12)) * $alokasi1) + (($alokasi_total-$total_biaya) * (1+($bunga_sedang2/12)) * $alokasi2);
								$investasi_tinggi = (($alokasi_total-$total_biaya) * (1+($bunga_tinggi/12)) * $alokasi1) + (($alokasi_total-$total_biaya) * (1+($bunga_tinggi2/12)) * $alokasi2);
								
								$hasil_invetasi_rendah_old = $investasi_rendah;
								$hasil_invetasi_sedang_old = $investasi_sedang;
								$hasil_invetasi_tinggi_old = $investasi_tinggi;
								
								//Pengecekan ilustrasi SAJA
								$investasi_rendah01 = ($alokasi_total-$total_biaya) * (1+($bunga_rendah/12)) * $alokasi1;
								$investasi_sedang01 = ($alokasi_total-$total_biaya) * (1+($bunga_sedang/12)) * $alokasi1;
								$investasi_tinggi01 = ($alokasi_total-$total_biaya) * (1+($bunga_tinggi/12)) * $alokasi1;
								$investasi_rendah02 = ($alokasi_total-$total_biaya) * (1+($bunga_rendah2/12)) * $alokasi2;
								$investasi_sedang02 = ($alokasi_total-$total_biaya) * (1+($bunga_sedang2/12)) * $alokasi2;
								$investasi_tinggi02 = ($alokasi_total-$total_biaya) * (1+($bunga_tinggi2/12)) * $alokasi2;
								
								$hasil_invetasi_rendah_old01 = $investasi_rendah01;
								$hasil_invetasi_sedang_old01 = $investasi_sedang01;
								$hasil_invetasi_tinggi_old01 = $investasi_tinggi01;
								$hasil_invetasi_rendah_old02 = $investasi_rendah02;
								$hasil_invetasi_sedang_old02 = $investasi_sedang02;
								$hasil_invetasi_tinggi_old02 = $investasi_tinggi02;

                                /* tracing 6/3/23 */
                                echo 
                                "<br><br>tracing hasil_invetasi_rendah_old01 $hasil_invetasi_rendah_old01".
                                "<br><br>tracing hasil_invetasi_sedang_old01 ".($hasil_invetasi_sedang_old01).
                                "<br><br>tracing hasil_invetasi_tinggi_old01 $hasil_invetasi_tinggi_old01".
                                "<br><br>tracing hasil_invetasi_rendah_old02 $hasil_invetasi_rendah_old02".
                                "<br><br>tracing hasil_invetasi_sedang_old02 ".($hasil_invetasi_sedang_old02).
                                "<br><br>tracing hasil_invetasi_tinggi_old03 $hasil_invetasi_tinggi_old02";
								
                                //End Pengecekan
								
								if($investasi_rendah < 0){
									$meninggal_rendah = 0;
								}else{
									$meninggal_rendah = $ua_dasar + $investasi_rendah;	
								}
								if($investasi_sedang < 0){
									$meninggal_sedang =0;
								}else{
									$meninggal_sedang = $ua_dasar + $investasi_sedang;
								}
								if($investasi_tinggi < 0){
									$meninggal_tinggi = 0;
								}else{
									$meninggal_tinggi = $ua_dasar + $investasi_tinggi;
								}
							}else{
								$akumulasi_total = $akumulasi + $alokasi_total;
								$akumulasi = $akumulasi_total;
								//$investasi_rendah = ($alokasi_total+$hasil_invetasi_rendah_old-$total_biaya) * (1+($bunga_rendah/12));
								//$investasi_sedang = ($alokasi_total+$hasil_invetasi_sedang_old-$total_biaya) * (1+($bunga_sedang/12));
								//$investasi_tinggi = ($alokasi_total+$hasil_invetasi_tinggi_old-$total_biaya) * (1+($bunga_tinggi/12));
								$investasi_rendah = ($hasil_invetasi_rendah_old01 + (($alokasi_total-$total_biaya) * $alokasi1)) * (1+($bunga_rendah/12)) + ($hasil_invetasi_rendah_old02 + (($alokasi_total-$total_biaya) * $alokasi2)) * (1+($bunga_rendah2/12));
								$investasi_sedang = ($hasil_invetasi_sedang_old01 + (($alokasi_total-$total_biaya) * $alokasi1)) * (1+($bunga_sedang/12)) + ($hasil_invetasi_sedang_old02 + (($alokasi_total-$total_biaya) * $alokasi2)) * (1+($bunga_sedang2/12));
								$investasi_tinggi = ($hasil_invetasi_tinggi_old01 + (($alokasi_total-$total_biaya) * $alokasi1)) * (1+($bunga_tinggi/12)) + ($hasil_invetasi_tinggi_old02 + (($alokasi_total-$total_biaya) * $alokasi2)) * (1+($bunga_tinggi2/12));
								
								$hasil_invetasi_rendah_old = $investasi_rendah;
								$hasil_invetasi_sedang_old = $investasi_sedang;
								$hasil_invetasi_tinggi_old = $investasi_tinggi;
								
								//Pengecekan ilustrasi SAJA
								$investasi_rendah01 = ($hasil_invetasi_rendah_old01 + (($alokasi_total-$total_biaya) * $alokasi1)) * (1+($bunga_rendah/12));
								$investasi_sedang01 = ($hasil_invetasi_sedang_old01 + (($alokasi_total-$total_biaya) * $alokasi1)) * (1+($bunga_sedang/12));
								$investasi_tinggi01 = ($hasil_invetasi_tinggi_old01 + (($alokasi_total-$total_biaya) * $alokasi1)) * (1+($bunga_tinggi/12));
								$investasi_rendah02 = ($hasil_invetasi_rendah_old02 + (($alokasi_total-$total_biaya) * $alokasi2)) * (1+($bunga_rendah2/12));
								$investasi_sedang02 = ($hasil_invetasi_sedang_old02 + (($alokasi_total-$total_biaya) * $alokasi2)) * (1+($bunga_sedang2/12));
								$investasi_tinggi02 = ($hasil_invetasi_tinggi_old02 + (($alokasi_total-$total_biaya) * $alokasi2)) * (1+($bunga_tinggi2/12));

								$hasil_invetasi_rendah_old01 = $investasi_rendah01;
								$hasil_invetasi_sedang_old01 = $investasi_sedang01;
								$hasil_invetasi_tinggi_old01 = $investasi_tinggi01;
								$hasil_invetasi_rendah_old02 = $investasi_rendah02;
								$hasil_invetasi_sedang_old02 = $investasi_sedang02;
								$hasil_invetasi_tinggi_old02 = $investasi_tinggi02;

                                /* tracing 6/3/23 */
                                echo 
                                "<br><br>tracing hasil_invetasi_rendah_old01 $hasil_invetasi_rendah_old01".
                                "<br><br>tracing hasil_invetasi_sedang_old01 ".($hasil_invetasi_sedang_old01).
                                "<br><br>tracing hasil_invetasi_tinggi_old01 $hasil_invetasi_tinggi_old01".
                                "<br><br>tracing hasil_invetasi_rendah_old02 $hasil_invetasi_rendah_old02".
                                "<br><br>tracing hasil_invetasi_sedang_old02 ".($hasil_invetasi_sedang_old02).
                                "<br><br>tracing hasil_invetasi_tinggi_old03 $hasil_invetasi_tinggi_old02";
								
                                //End Pengecekan 
								
								if($investasi_rendah < 0){
									$meninggal_rendah = 0;
								}else{
									$meninggal_rendah = $ua_dasar + $investasi_rendah;	
								}
								if($investasi_sedang < 0){
									$meninggal_sedang =0;
								}else{
									$meninggal_sedang = $ua_dasar + $investasi_sedang;
								}
								if($investasi_tinggi < 0){
									$meninggal_tinggi = 0;
								}else{
									$meninggal_tinggi = $ua_dasar + $investasi_tinggi;
								}
							}
						}else if($carabayar !=1 && ($y % $pembagi) == 1){ //Akan menambahkan nilai premi dan topup berdarkan cara bayar
							//echo 'masuk cara bayar bukan bulanan';
                            $akuisisi_topup = 0.05*$topup_dasar;
							$alokasi_topup = 0.95*$topup_dasar;
							//$akuisisi_topup = 0*$topup_dasar;
							//$alokasi_topup = 1*$topup_dasar;
							if($usia < $makstopup){
								$akuisisi_topup_x = 0.05*$topup_sekaligus;
								$alokasi_topup_x = 0.95*$topup_sekaligus;
								//$akuisisi_topup = 0*$topup_sekaligus;
								//$alokasi_topup = 1*$topup_sekaligus;
							}else{
								$akuisisi_topup_x = 0;
								$alokasi_topup_x = 0;
							}

							// if($tahun_ke == 1){
							// 	$akuisisi_premi_dasar = 0.4*$premi_dasar;
							// 	$alokasi_premi_dasar = 0.6*$premi_dasar;
							// }else if($tahun_ke == 2){
							// 	$akuisisi_premi_dasar = 0.4*$premi_dasar;
							// 	$alokasi_premi_dasar = 0.6*$premi_dasar;
							// }

							if($tahun_ke == 1){
								$akuisisi_premi_dasar = 0.4*$premi_dasar;
								$alokasi_premi_dasar = 0.6*$premi_dasar;
							}
							else if($tahun_ke == 2){
								$akuisisi_premi_dasar = 0.4*$premi_dasar;
								$alokasi_premi_dasar = 0.6*$premi_dasar;      
							}else if($tahun_ke == 3){
								$akuisisi_premi_dasar = 0.4*$premi_dasar;
								$alokasi_premi_dasar = 0.6*$premi_dasar;  
							}else if($tahun_ke == 4){
								$akuisisi_premi_dasar = 0.2*$premi_dasar;
								$alokasi_premi_dasar = 0.8*$premi_dasar;
							}else if($tahun_ke == 5){
								$akuisisi_premi_dasar = 0.2*$premi_dasar;
								$alokasi_premi_dasar = 0.8*$premi_dasar;
							}
							else{
								$akuisisi_premi_dasar = 0*$premi_dasar;
								$alokasi_premi_dasar = 1*$premi_dasar;
							}

							$alokasi_total = $alokasi_premi_dasar + $alokasi_topup + $alokasi_topup_x;
							if($tahun_ke == 1 && $y==1){
								$akumulasi = 0;
								$akumulasi_total = $akumulasi + $alokasi_total;
								$akumulasi = $akumulasi_total;
								//$investasi_rendah = $alokasi_total * (1+($bunga_rendah/12));
								//$investasi_sedang = $alokasi_total * (1+($bunga_sedang/12));
								//$investasi_tinggi = $alokasi_total * (1+($bunga_tinggi/12));
								$investasi_rendah = (($alokasi_total - $total_biaya) * (1+($bunga_rendah/12)) * $alokasi1) + (($alokasi_total - $total_biaya) * (1+($bunga_rendah2/12)) * $alokasi2);
								$investasi_sedang = (($alokasi_total - $total_biaya) * (1+($bunga_sedang/12)) * $alokasi1) + (($alokasi_total - $total_biaya) * (1+($bunga_rendah2/12)) * $alokasi2);
								$investasi_tinggi = (($alokasi_total - $total_biaya) * (1+($bunga_tinggi/12)) * $alokasi1) + (($alokasi_total - $total_biaya) * (1+($bunga_tinggi2/12)) * $alokasi2);
								$hasil_invetasi_rendah_old = $investasi_rendah;
								$hasil_invetasi_sedang_old = $investasi_sedang;
								$hasil_invetasi_tinggi_old = $investasi_tinggi;
								/*
                                echo 
                                "<br><br>init tahunan<br><br>tracing alokasi_premi_dasar $alokasi_premi_dasar".
                                "<br><br>tracing alokasi_topup $alokasi_topup".
                                "<br><br>tracing alokasi_topup_x $alokasi_topup_x".

                                "<br><br>tracing total_biaya $total_biaya".
                                "<br><br>tracing alokasi_total $alokasi_total"; 
                                */
								//Pengecekan ilustrasi SAJA
								$investasi_rendah01 = ($alokasi_total - $total_biaya) * (1+($bunga_rendah/12)) * $alokasi1;
								$investasi_sedang01 = ($alokasi_total - $total_biaya) * (1+($bunga_sedang/12)) * $alokasi1;
								$investasi_tinggi01 = ($alokasi_total - $total_biaya) * (1+($bunga_tinggi/12)) * $alokasi1;
								$investasi_rendah02 = ($alokasi_total - $total_biaya) * (1+($bunga_rendah2/12)) * $alokasi2;
								$investasi_sedang02 = ($alokasi_total - $total_biaya) * (1+($bunga_sedang2/12)) * $alokasi2;
								$investasi_tinggi02 = ($alokasi_total - $total_biaya) * (1+($bunga_tinggi2/12)) * $alokasi2;
								
								$hasil_invetasi_rendah_old01 = $investasi_rendah01;
								$hasil_invetasi_sedang_old01 = $investasi_sedang01;
								$hasil_invetasi_tinggi_old01 = $investasi_tinggi01;
								$hasil_invetasi_rendah_old02 = $investasi_rendah02;
								$hasil_invetasi_sedang_old02 = $investasi_sedang02;
								$hasil_invetasi_tinggi_old02 = $investasi_tinggi02;

                                /* tracing 6/3/23
                                echo 
                                "<br><br>tracing hasil_invetasi_rendah_old01 $hasil_invetasi_rendah_old01".
                                "<br><br>tracing hasil_invetasi_sedang_old01 ".($hasil_invetasi_sedang_old01).
                                "<br><br>tracing hasil_invetasi_tinggi_old01 $hasil_invetasi_tinggi_old01".
                                "<br><br>tracing hasil_invetasi_rendah_old02 $hasil_invetasi_rendah_old02".
                                "<br><br>tracing hasil_invetasi_sedang_old02 ".($hasil_invetasi_sedang_old02).
                                "<br><br>tracing hasil_invetasi_tinggi_old03 $hasil_invetasi_tinggi_old02";
								*/
                                //End Pengecekan 
								
								if($investasi_rendah < 0){
									$meninggal_rendah = 0;
								}else{
									$meninggal_rendah = $ua_dasar + $investasi_rendah;	
								}
								if($investasi_sedang < 0){
									$meninggal_sedang =0;
								}else{
									$meninggal_sedang = $ua_dasar + $investasi_sedang;
								}
								if($investasi_tinggi < 0){
									$meninggal_tinggi = 0;
								}else{
									$meninggal_tinggi = $ua_dasar + $investasi_tinggi;
								}
								// $meninggal_rendah = $ua_dasar + $investasi_rendah;
								// $meninggal_sedang = $ua_dasar + $investasi_sedang;
								// $meninggal_tinggi = $ua_dasar + $investasi_tinggi;
							}else{
                                //echo '<br><br>kesatu masuk tahunan';

                                /* tracing 6/3/23 
                                echo 
                                "<br><br>tracing alokasi_premi_dasar $alokasi_premi_dasar".
                                "<br><br>tracing alokasi_topup $alokasi_topup".
                                "<br><br>tracing alokasi_topup_x $alokasi_topup_x".
                                "<br><br>tracing alokasi_total $alokasi_total";
                                */    
								$akumulasi_total = $akumulasi + $alokasi_total;
								$akumulasi = $akumulasi_total;
								
								//$investasi_rendah = ($alokasi_total+$hasil_invetasi_rendah_old-$total_biaya) * (1+($bunga_rendah/12));
								//$investasi_sedang = ($alokasi_total+$hasil_invetasi_sedang_old-$total_biaya) * (1+($bunga_sedang/12));
								//$investasi_tinggi = ($alokasi_total+$hasil_invetasi_tinggi_old-$total_biaya) * (1+($bunga_tinggi/12));
								$investasi_rendah = (($alokasi_total+$hasil_invetasi_rendah_old-$total_biaya) * (1+($bunga_rendah/12)) * $alokasi1) + (($alokasi_total+$hasil_invetasi_rendah_old-$total_biaya) * (1+($bunga_rendah2/12)) * $alokasi2);
								$investasi_sedang = (($alokasi_total+$hasil_invetasi_sedang_old-$total_biaya) * (1+($bunga_sedang/12)) * $alokasi1) + (($alokasi_total+$hasil_invetasi_sedang_old-$total_biaya) * (1+($bunga_sedang2/12)) * $alokasi2);
								$investasi_tinggi = (($alokasi_total+$hasil_invetasi_tinggi_old-$total_biaya) * (1+($bunga_tinggi/12)) * $alokasi1) + (($alokasi_total+$hasil_invetasi_tinggi_old-$total_biaya) * (1+($bunga_tinggi2/12)) * $alokasi2);
								$hasil_invetasi_rendah_old = $investasi_rendah;
								$hasil_invetasi_sedang_old = $investasi_sedang;
								$hasil_invetasi_tinggi_old = $investasi_tinggi;
								
								//Pengecekan ilustrasi SAJA
								$investasi_rendah01 = ($alokasi_total+$hasil_invetasi_rendah_old01-$total_biaya) * (1+($bunga_rendah/12)) * $alokasi1;
								$investasi_sedang01 = ($alokasi_total+$hasil_invetasi_sedang_old01-$total_biaya) * (1+($bunga_sedang/12)) * $alokasi1;
								$investasi_tinggi01 = ($alokasi_total+$hasil_invetasi_tinggi_old01-$total_biaya) * (1+($bunga_tinggi/12)) * $alokasi1;
								$investasi_rendah02 = ($alokasi_total+$hasil_invetasi_rendah_old02-$total_biaya) * (1+($bunga_rendah2/12)) * $alokasi2;
								$investasi_sedang02 = ($alokasi_total+$hasil_invetasi_sedang_old02-$total_biaya) * (1+($bunga_sedang2/12)) * $alokasi2;
								$investasi_tinggi02 = ($alokasi_total+$hasil_invetasi_tinggi_old02-$total_biaya) * (1+($bunga_tinggi2/12)) * $alokasi2;

								$hasil_invetasi_rendah_old01 = $investasi_rendah01;
								$hasil_invetasi_sedang_old01 = $investasi_sedang01;
								$hasil_invetasi_tinggi_old01 = $investasi_tinggi01;
								$hasil_invetasi_rendah_old02 = $investasi_rendah02;
								$hasil_invetasi_sedang_old02 = $investasi_sedang02;
								$hasil_invetasi_tinggi_old02 = $investasi_tinggi02;

                                /* tracing 6/3/23 
                                echo 
                                "<br><br>tracing hasil_invetasi_rendah_old01 $hasil_invetasi_rendah_old01".
                                "<br><br>tracing hasil_invetasi_sedang_old01 ".($hasil_invetasi_sedang_old01).
                                "<br><br>tracing hasil_invetasi_tinggi_old01 $hasil_invetasi_tinggi_old01".
                                "<br><br>tracing hasil_invetasi_rendah_old02 $hasil_invetasi_rendah_old02".
                                "<br><br>tracing hasil_invetasi_sedang_old02 ".($hasil_invetasi_sedang_old02).
                                "<br><br>tracing hasil_invetasi_tinggi_old03 $hasil_invetasi_tinggi_old02";
								*/
                                //End Pengecekan
								
								if($investasi_rendah < 0){
									$meninggal_rendah = 0;
								}else{
									$meninggal_rendah = $ua_dasar + $investasi_rendah;	
								}
								if($investasi_sedang < 0){
									$meninggal_sedang =0;
								}else{
									$meninggal_sedang = $ua_dasar + $investasi_sedang;
								}
								if($investasi_tinggi < 0){
									$meninggal_tinggi = 0;
								}else{
									$meninggal_tinggi = $ua_dasar + $investasi_tinggi;
								}
								// $meninggal_rendah = $ua_dasar + $investasi_rendah;
								// $meninggal_sedang = $ua_dasar + $investasi_sedang;
								// $meninggal_tinggi = $ua_dasar + $investasi_tinggi;
							}
						}else{
                            //echo '<br><br>kedua masuk tahunan';
							$akuisisi_topup = 0;
							$alokasi_topup = 0;
							$akuisisi_premi_dasar = 0;
							$alokasi_premi_dasar = 0;
							$akuisisi_topup_x = 0;
                            $alokasi_topup_x = 0;
							$alokasi_total = $alokasi_premi_dasar + $alokasi_topup + $alokasi_topup_x;
							if($tahun_ke == 1 && $y==1){
								$akumulasi = 0;
								$akumulasi_total = $akumulasi + $alokasi_total;
								$akumulasi = $akumulasi_total;
								$investasi_rendah = ($alokasi_total * (1+($bunga_rendah/12)) * $alokasi1) + ($alokasi_total * (1+($bunga_rendah2/12)) * $alokasi2);
								$investasi_sedang = ($alokasi_total * (1+($bunga_sedang/12)) * $alokasi1) + ($alokasi_total * (1+($bunga_rendah2/12)) * $alokasi2);
								$investasi_tinggi = ($alokasi_total * (1+($bunga_tinggi/12)) * $alokasi1) + ($alokasi_total * (1+($bunga_tinggi2/12)) * $alokasi2);
								$hasil_invetasi_rendah_old = $investasi_rendah;
								$hasil_invetasi_sedang_old = $investasi_sedang;
								$hasil_invetasi_tinggi_old = $investasi_tinggi;
								
								//Pengecekan ilustrasi SAJA
								$investasi_rendah01 = ($alokasi_total - $total_biaya) * (1+($bunga_rendah/12)) * $alokasi1;
								$investasi_sedang01 = ($alokasi_total - $total_biaya) * (1+($bunga_sedang/12)) * $alokasi1;
								$investasi_tinggi01 = ($alokasi_total - $total_biaya) * (1+($bunga_tinggi/12)) * $alokasi1;
								$investasi_rendah02 = ($alokasi_total - $total_biaya) * (1+($bunga_rendah2/12)) * $alokasi2;
								$investasi_sedang02 = ($alokasi_total - $total_biaya) * (1+($bunga_sedang2/12)) * $alokasi2;
								$investasi_tinggi02 = ($alokasi_total - $total_biaya) * (1+($bunga_tinggi2/12)) * $alokasi2;

								$hasil_invetasi_rendah_old01 = $investasi_rendah01;
								$hasil_invetasi_sedang_old01 = $investasi_sedang01;
								$hasil_invetasi_tinggi_old01 = $investasi_tinggi01;
								$hasil_invetasi_rendah_old02 = $investasi_rendah02;
								$hasil_invetasi_sedang_old02 = $investasi_sedang02;
								$hasil_invetasi_tinggi_old02 = $investasi_tinggi02;

                                /* tracing 6/3/23 
                                echo 
                                "<br><br>tracing hasil_invetasi_rendah_old01 $hasil_invetasi_rendah_old01".
                                "<br><br>tracing hasil_invetasi_sedang_old01 ".($hasil_invetasi_sedang_old01).
                                "<br><br>tracing hasil_invetasi_tinggi_old01 $hasil_invetasi_tinggi_old01".
                                "<br><br>tracing hasil_invetasi_rendah_old02 $hasil_invetasi_rendah_old02".
                                "<br><br>tracing hasil_invetasi_sedang_old02 ".($hasil_invetasi_sedang_old02).
                                "<br><br>tracing hasil_invetasi_tinggi_old03 $hasil_invetasi_tinggi_old02";
								*/
                                //End Pengecekan
								
								if($investasi_rendah < 0){
									$meninggal_rendah = 0;
								}else{
									$meninggal_rendah = $ua_dasar + $investasi_rendah;	
								}
								if($investasi_sedang < 0){
									$meninggal_sedang =0;
								}else{
									$meninggal_sedang = $ua_dasar + $investasi_sedang;
								}
								if($investasi_tinggi < 0){
									$meninggal_tinggi = 0;
								}else{
									$meninggal_tinggi = $ua_dasar + $investasi_tinggi;
								}
								// $meninggal_rendah = $ua_dasar + $investasi_rendah;
								// $meninggal_sedang = $ua_dasar + $investasi_sedang;
								// $meninggal_tinggi = $ua_dasar + $investasi_tinggi;
							}else{
								$akumulasi_total = $akumulasi + $alokasi_total;
								$akumulasi = $akumulasi_total;
								
								//$investasi_rendah = ($alokasi_total+$hasil_invetasi_rendah_old-$total_biaya) * (1+($bunga_rendah/12));
								//$investasi_sedang = ($alokasi_total+$hasil_invetasi_sedang_old-$total_biaya) * (1+($bunga_sedang/12));
								//$investasi_tinggi = ($alokasi_total+$hasil_invetasi_tinggi_old-$total_biaya) * (1+($bunga_tinggi/12));
								$investasi_rendah = (($alokasi_total+$hasil_invetasi_rendah_old-$total_biaya) * (1+($bunga_rendah/12)) * $alokasi1) + (($alokasi_total+$hasil_invetasi_rendah_old-$total_biaya) * (1+($bunga_rendah2/12)) * $alokasi2);
								$investasi_sedang = (($alokasi_total+$hasil_invetasi_sedang_old-$total_biaya) * (1+($bunga_sedang/12)) * $alokasi1) + (($alokasi_total+$hasil_invetasi_sedang_old-$total_biaya) * (1+($bunga_sedang2/12)) * $alokasi2);
								$investasi_tinggi = (($alokasi_total+$hasil_invetasi_tinggi_old-$total_biaya) * (1+($bunga_tinggi/12)) * $alokasi1) + (($alokasi_total+$hasil_invetasi_tinggi_old-$total_biaya) * (1+($bunga_tinggi2/12)) * $alokasi2);
								$hasil_invetasi_rendah_old = $investasi_rendah;
								$hasil_invetasi_sedang_old = $investasi_sedang;
								$hasil_invetasi_tinggi_old = $investasi_tinggi;
								
								//Pengecekan ilustrasi SAJA
								$investasi_rendah01 = ($alokasi_total+$hasil_invetasi_rendah_old01-$total_biaya) * (1+($bunga_rendah/12)) * $alokasi1;
								$investasi_sedang01 = ($alokasi_total+$hasil_invetasi_sedang_old01-$total_biaya) * (1+($bunga_sedang/12)) * $alokasi1;
								$investasi_tinggi01 = ($alokasi_total+$hasil_invetasi_tinggi_old01-$total_biaya) * (1+($bunga_tinggi/12)) * $alokasi1;
								$investasi_rendah02 = ($alokasi_total+$hasil_invetasi_rendah_old02-$total_biaya) * (1+($bunga_rendah2/12)) * $alokasi2;
								$investasi_sedang02 = ($alokasi_total+$hasil_invetasi_sedang_old02-$total_biaya) * (1+($bunga_sedang2/12)) * $alokasi2;
								$investasi_tinggi02 = ($alokasi_total+$hasil_invetasi_tinggi_old02-$total_biaya) * (1+($bunga_tinggi2/12)) * $alokasi2;

								$hasil_invetasi_rendah_old01 = $investasi_rendah01;
								$hasil_invetasi_sedang_old01 = $investasi_sedang01;
								$hasil_invetasi_tinggi_old01 = $investasi_tinggi01;
								$hasil_invetasi_rendah_old02 = $investasi_rendah02;
								$hasil_invetasi_sedang_old02 = $investasi_sedang02;
								$hasil_invetasi_tinggi_old02 = $investasi_tinggi02;
                                /* tracing 6/3/23 
                                echo 
                                "<br><br>tracing hasil_invetasi_rendah_old01 $hasil_invetasi_rendah_old01".
                                "<br><br>tracing hasil_invetasi_sedang_old01 ".($hasil_invetasi_sedang_old01).
                                "<br><br>tracing hasil_invetasi_tinggi_old01 $hasil_invetasi_tinggi_old01".
                                "<br><br>tracing hasil_invetasi_rendah_old02 $hasil_invetasi_rendah_old02".
                                "<br><br>tracing hasil_invetasi_sedang_old02 ".($hasil_invetasi_sedang_old02).
                                "<br><br>tracing hasil_invetasi_tinggi_old03 $hasil_invetasi_tinggi_old02";
                                */
								//End Pengecekan
								
								if($investasi_rendah < 0){
									$meninggal_rendah = 0;
								}else{
									$meninggal_rendah = $ua_dasar + $investasi_rendah;	
								}
								if($investasi_sedang < 0){
									$meninggal_sedang =0;
								}else{
									$meninggal_sedang = $ua_dasar + $investasi_sedang;
								}
								if($investasi_tinggi < 0){
									$meninggal_tinggi = 0;
								}else{
									$meninggal_tinggi = $ua_dasar + $investasi_tinggi;
								}
								// $meninggal_rendah = $ua_dasar + $investasi_rendah;
								// $meninggal_sedang = $ua_dasar + $investasi_sedang;
								// $meninggal_tinggi = $ua_dasar + $investasi_tinggi;
							}
						}
								 
                        /* 
                        echo '<br><br>tracing bulan '.$y;
                        echo 
                        "<br>bunga_rendah $bunga_rendah ".
                        "<br>bunga_sedang $bunga_sedang ".
                        "<br>bunga_tinggi $bunga_tinggi ".
                        "<br>premi_dasar $premi_dasar ".
                        "<br>topup_dasar $topup_dasar ".
                        "<br>topup_x $topup_x ".
                        "<br>investasi_rendah $investasi_rendah ".
                        "<br>investasi_sedang $investasi_sedang ".
                        "<br>investasi_tinggi $investasi_tinggi ".
                        "<br>meninggal_rendah $meninggal_rendah ".
                        "<br>meninggal_sedang $meninggal_sedang ".
                        "<br>meninggal_tinggi $meninggal_tinggi ";

                        echo '<br><br>tracing bulan '.($alokasi_total * (1+($bunga_rendah/12)) * $alokasi1);
								
                        echo 
                        "<br>alokasi_total $alokasi_total ".
                        "<br>bunga_rendah $bunga_rendah ".
                        "<br>alokasi1 $alokasi1 ";
                        */
                        
						if($y==12){
                            //echo 'di bulan 12';
							$premi_dasar_insert = $premi_dasar/1000;
							$topup_dasar_insert = $topup_dasar/1000;
							$topup_sekaligus_insert = $topup_x/1000;
							$invlow 	= $investasi_rendah/1000;
							$invmed 	= $investasi_sedang/1000;
							$invhigh 	= $investasi_tinggi/1000;
							$juainvlow 	= $meninggal_rendah/1000;
							$juainvmed 	= $meninggal_sedang/1000;
							$juainvhigh = $meninggal_tinggi/1000;
							$sqlinsert = "insert into JAIM.PRO_TOTAL_INVESTASI1
											(BUILD_ID, TAHUN, PREMI, TOPUPB, TOPUPX, INVLOW, INVMED, INVHIGH, JUAINVLOW, JUAINVMED, JUAINVHIGH, USIA_TT)
							 				Values
							 				('$buildid', $tahun_ke, $premi_dasar_insert, $topup_dasar_insert, $topup_sekaligus_insert, $invlow, $invmed, $invhigh, $juainvlow, $juainvmed, $juainvhigh, $usia) ";
							//echo $sqlinsert;  echo "</br>";
							$queryinsert = $this->db->query($sqlinsert);
						}else{

						}
								  
					}
					$usia++;
					$usia_cpp++;
					$tahun_ke++;
				} 
			?>
			
	<div class="row">
		<div class="col-md-12">
			<span style="margin-left:2em">
				<a href='#' onClick="popitup('<?=base_url('jspromapannew_2019/CetakPDFIFG?build_id='.$buildid.'&filepdf='.$filepdf.'&kodeprospek='.$kodeprospek);?>')">
				 Cetak PDF <i class="m-icon-swapright m-icon-white"></i>
				</a>
			</span>
				
			<br><br>
			<span style="margin-left:2em">
				<a href="<?=str_replace('simulasi/','',base_url("prospek/proposal?id=$prospek[NO_KTP]"));?>" />
				<!--					<a target="_blank" href="<?= base_url().'files/pdf/'.$hasil['filepdf'].'.pdf'; ?>" class="btn green button-submit">-->
				Buat Proposal Kembali  <i class="m-icon-swapright m-icon-white"></i>
				</a>
			</span>
		</div>
	</div>

</div>
<!-- END PAGE CONTENT-->
</div>
</div>
<!-- END CONTENT -->

<script>


function popitup(url) {
	newwindow=window.open(url,'name','height=850,width=1200, menubar=no, scrollbars=no, resizable=yes, copyhistory=no,');
	if (window.focus) {newwindow.focus()}
	return false;
}


function CetakPDF(){
	
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById('Testis').innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
	

}

</script>