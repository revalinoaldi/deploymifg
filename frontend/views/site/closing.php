<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */

$this->title = 'Closing Statement Agent';



$sql_cs = "SELECT coalesce(count(id),0)as cs FROM closing_statement WHERE no_spaj = '".$no_spaj."'";
$data_cs = Yii::$app->db->createCommand($sql_cs)->queryOne();
$n_cs =  $data_cs['cs'];
if($n_cs > 0){
	echo "<script>location.href = 'https://mifg.ifg-life.id';</script>";
}
?>
<style>
.row{
	font-size:14px;
	font-family:'Myriad Pro Regular';
	font-weight:normal;
}

.form-control{
	font-size:14px;
	font-family:'Myriad Pro Regular';
	font-weight:normal;
	text-transform: uppercase;
	box-shadow: 10px 10px 5px -6px rgba(0,0,0,0.21);
-webkit-box-shadow: 10px 10px 5px -6px rgba(0,0,0,0.21);
-moz-box-shadow: 10px 10px 5px -6px rgba(0,0,0,0.21);
}

/* The container */
.containerss {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 14px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.containerss input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

.containerssc {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 14px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.containerssc input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #d54e21;
  content: "\2713";
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
 	top: 0px;
	left: 5px;
	width: 6px;
	height: 6px;
    content: "\2713";
    color: white;
    font-size:15px;
    font-weight:bold;
}



/* Create a custom checkbutton */
.checkmarkc {
  position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
  border-radius: 5%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmarkc {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmarkc {
  background-color: #d54e21;
  content: "\2713";
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmarkc:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmarkc:after {
  display: block;
}

.error{
	color: red;
	font-style: italic;
	font-family:'Myriad Pro Regular';
	font-size: 12px;
}
</style>
<body>
<!-- Form wizard with vertical tabs section start -->
<section id="vertical-tabs">
	<div class="row">
	<div align="center">
		<div class="col-12" style="padding:40px;">
			<div class="card">
				<div class="card-header">
					 <div style="font-size:26px;font-weight:bold;text-align:center;">PERNYATAAN/LAPORAN AGEN PENUTUP</div>
					<a class="heading-elements-toggle"><i class="fa fa-ellipsis-h font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
						
						</ul>
					</div>
				</div>
				<div align="center">
				<div class="card-content collapse show" style="width:70%;">
					<div class="card-body">
						<?php $form = ActiveForm::begin(['id' => 'questionaire-form', 'method' => 'post', 'options'=>['class'=>'vertical-tab-steps wizard-circle']]); ?>
							<input type="hidden" value="<?=$no_spaj?>" name="no_spaj" />
							<div class="row">
								<div class="col-md-6">
									<?= $form->field($model, 'no_agent')->textInput(['maxlength' => true, 'readonly' => true]) ?>
								</div>
								<div class="col-md-6">
									<?= $form->field($model, 'nama_agent')->textInput(['maxlength' => true, 'readonly' => true]) ?>
								</div>
								<div class="col-md-6">
									<?= $form->field($model, 'no_lisensi')->textInput(['maxlength' => true, 'readonly' => true]) ?>
								</div>
								<div class="col-md-6">
									<?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'readonly' => true]) ?>
								</div>
							</div>
							
								<div class="row">
									<div class="col-md-12" style="text-align:justify;padding-left:60px;"><b>Dengan ini, saya menyatakan bahwa :</b></div>
								</div>
								<div class="row">
									<div class="col-md-6" style="text-align:justify;padding-left:60px;">Saya mengenal Calon Pemegang Polis selama :</div>
								
									<div class="col-md-6" style="text-align:justify;padding-left:60px;">sebagai :</div>
								</div>
								<div class="row"  class="form-group">
									<div class="col-md-6" style="text-align:justify;padding-left:60px;">
										<?php echo $form->field($model, 'kenal_pp_selama')->inline(false)->radioList(array("< 1 Tahun" => "< 1 Tahun", "2-3 Tahun"=> "2-3 Tahun", "3-5 Tahun" => "3-5 Tahun", "> 5 Tahun"=>"> 5 Tahun"), ['inline' => false, 'unselect' => '< 1 Tahun'])->label(false); ?>
									</div>
								
									<div class="col-md-6" style="text-align:justify;padding-left:60px;">
										<?php echo $form->field($model, 'kenal_sebagai')->inline(false)->radioList(array("Keluarga" => "Keluarga", "Teman" => "Teman", "Referensi"=>"Referensi", "Lainnya"=>"Lainnya"), ['inline' => false, 'unselect' => 'Keluarga'])->label(false); ?>
										<input type="text" class="form-control d-none" placeholder="Lainnya" name="kenal_sebagai_lainnya" id="kenal_sebagai_lainnya"/>
										<br/>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6" style="text-align:justify;padding-left:60px;">Calon Tertanggung selama :</div>
									<div class="col-md-6" style="text-align:justify;padding-left:60px;">sebagai :</div>
									
								</div>
								<div class="row">
									
									<div class="col-md-6" style="text-align:justify;padding-left:60px;">
										<?php echo $form->field($model, 'kenal_tertanggung_selama')->inline(false)->radioList(array("< 1 Tahun" => "< 1 Tahun", "2-3 Tahun"=> "2-3 Tahun", "3-5 Tahun" => "3-5 Tahun", "> 5 Tahun"=>"> 5 Tahun"), ['inline' => false, 'unselect' => '1'])->label(false); ?>
									</div>
									<div class="col-md-6" style="text-align:justify;padding-left:60px;">
										<?php echo $form->field($model, 'kenal_tertanggung_sebagai')->inline(false)->radioList(array("Keluarga" => "Keluarga", "Teman" => "Teman", "Referensi"=>"Referensi", "Lainnya"=>"Lainnya"), ['inline' => false, 'unselect' => 'Keluarga'])->label(false); ?>
										<input type="text" class="form-control d-none" placeholder="Lainnya" name="kenal_tertanggung_lainnya" id="kenal_tertanggung_lainnya" />
										<br/>
									</div>
									
									
								</div>
								<div class="row">
									<div class="col-md-6" style="text-align:justify;padding-left:60px;">Calon Pembayar Premi selama :</div>
									<div class="col-md-6" style="text-align:justify;padding-left:60px;">sebagai :</div>
								</div>
								<div class="row">
									<div class="col-md-6" style="text-align:justify;padding-left:60px;">
										<?php echo $form->field($model, 'kenal_pembayar_premi_selama')->inline(false)->radioList(array("< 1 Tahun" => "< 1 Tahun", "2-3 Tahun"=> "2-3 Tahun", "3-5 Tahun" => "3-5 Tahun", "> 5 Tahun"=>"> 5 Tahun"), ['inline' => false, 'unselect' => '1'])->label(false); ?>
									</div>
									
									<div class="col-md-6" style="text-align:justify;padding-left:60px;">
									<?php echo $form->field($model, 'kenal_pembayar_premi_sebagai')->inline(false)->radioList(array("Keluarga" => "Keluarga", "Teman" => "Teman", "Referensi"=>"Referensi", "Lainnya"=>"Lainnya"), ['inline' => false, 'unselect' => '1'])->label(false); ?>
									<input type="text" class="form-control d-none" placeholder="Lainnya" name="kenal_pembayar_premi_lainnya" id="kenal_pembayar_premi_lainnya" />
									<br/>
									</div>
								</div>

							<div style="float:left;position:relative;width:100%;margin-top:30px;margin-bottom:20px;">
							<div class="row">
							
								<div style="width:60px;text-align:left;">1.</div>
								<div style="width:90%;text-align:justify;">
										Semua keterangan yang terdapat di SPAJ ini adalah semata-mata keterangan yang diberikan oleh Calon Pemegang Polis dan/ atau Calon Tertanggung dan/ atau Calon Pembayar Premi, saya tidak menyembunyikan informasi atau keterangan apapun yang telah diberikan oleh Calon Pemegang Polis dan/ atau Calon Tertanggung dan/ atau Calon Pembayar Premi yang dapat mempengaruhi penerimaan SPAJ ini.
								</div>
							</div>
							<div class="row">
								<div style="width:60px;text-align:left;">2.</div>
								<div style="width:90%;text-align:justify;">
									 Saya telah menerangkan semua isi butir pernyataan di SPAJ dengan jelas dan menjelaskan informasi/ keterangan mengenai produk asuransi dan manfaatnya sesuai dengan Syarat Umum Polis dan/atau Syarat-Syarat Umum Polis dan Ketentuan Khusus Polis Asuransi Dasar maupun Asuransi Tambahan, termasuk menjelaskan bahwa jawaban yang tidak benar pada pengisian SPAJ akan berakibat klaim tidak dibayarkan serta berakibat batalnya polis
								</div>
							</div>
							
							<div class="row">
								<div style="width:60px;text-align:left;">3.</div>
								<div style="width:90%;text-align:justify;">
									 Dalam hal saya membantu calon pemegang polis dan atau Calon tertanggung mengisi SPAJ dan SKK ini adalah semata-mata membantu berdasarkan keinginan dan permintaan calon pemegang polis dan atau Calon tertanggung untuk mempercepat proses penutupan asuransi, dimana seluruh isian yang tercantum didalamnya sudah saya konfirmasi kebenarannya kepada calon pemegang polis dan atau calon tertanggung sebelum SPAJ dan SKK ini ditandatangani oleh calon pemegang polis dan atau tertanggung.
								</div>
							</div>
							
							<div class="row">
								<div style="width:60px;text-align:left;">4.</div>
								<div style="width:90%;text-align:justify;">
									Calon Pemegang Polis, Calon Tertanggung, Calon Pembayar Premi adalah benar seorang yang berkepribadian baik dan jujur dalam segala urusan.
								</div>
							</div>
							
							<div class="row">
								<div style="width:60px;text-align:left;">5.</div>
								<div style="width:90%;text-align:justify;">
									Saya telah bertemu dan melihat secara langsung kondisi terakhir Calon Tertanggung pada saat SPAJ ini diisi dan ditandatangani serta mengecek kebenaran dan kelengkapan pengisiannya.
								</div>
							</div>
							
							<div class="row">
								<div style="width:60px;text-align:left;">6.</div>
								<div style="width:90%;text-align:justify;">
									Apakah Calon Tertanggung dalam keadaan sehat sewaktu mengisi SPAJ ini
								</div>
								<div class="col-md-12" style="text-align:justify;padding-left:80px;">
									<?php echo $form->field($model, 'kesehatan_tertanggung')->inline(false)->radioList(array("Ya" => "Ya", "Tidak" => "Tidak"), ['inline' => false], ['style' => 'margin-left:60px;'])->label(false); ?>
								</div>
							</div>
							
							<div class="row">
								<div style="width:60px;text-align:left;">7.</div>
								<div style="width:90%;text-align:justify;">Apakah premi yang dibayar sudah sesuai dengan kondisi keuangan Calon Pemegang Polis atau Calon Pembayar Premi untuk kelangsungan polis yang diajukan.
								</div>
								<div class="col-md-12" style="text-align:justify;padding-left:80px;">																	
									<?php echo $form->field($model, 'kondisi_keuangan_sesuai')->inline(false)->radioList(array("Ya" => "Ya", "Tidak" => "Tidak"), ['inline' => false])->label(false); ?>
								</div>
							</div>
							
							<div class="row">
								<div style="width:60px;text-align:left;">6.</div>
								<div style="width:90%;text-align:justify;">
									Pada awalnya yang memulai proses penutupan/ closing asuransi jiwa ini adalah
								</div>
								<div class="col-md-12" style="text-align:justify;padding-left:80px;">
									<?php echo $form->field($model, 'awal_penutupan_oleh')->inline(false)->radioList(array("Calon Pemegang Polis" => "Calon Pemegang Polis", "Calon Tertanggung Utama" => "Calon Tertanggung Utama", "Calon Pembayar Premi" => "Calon Pembayar Premi", "Agen Penutup"=>"Agen Penutup", "Lainnya"=>"Lainnya"), ['inline' => false])->label(false); ?>
									
								</div>
								<div class="col-md-6">
									<input type="text" class="form-control d-none" placeholder="Awal penutupan Lainnya" name="awal_penutupan_lainnya" id="awal_penutupan_lainnya" />
									<br/>
								</div>
							</div>
							
							<div class="row d-none">
								<div class="col-md-6 text-right">
									Ditandatangani Di
								</div>
								<div class="col-md-6">
									<?= $form->field($model, 'lokasi_closing')->textInput(['maxlength' => true])->label(false) ?>
								</div>
								<div class="col-md-6 text-right">
									Tanggal Closing
								</div>
								<div class="col-md-6">
									<?php 
									echo DatePicker::widget([
										'model' => $model, 
										'attribute' => 'tanggal_closing',
										'options'=>[
											'placeholder'=>'Tanggal Closing',
											'autocomplete'=>'off',
										],
										'pluginOptions' => [
											'autoclose'=>true,
											'format' => 'yyyy-mm-dd'
										],
									]);
				
									?>
								</div>
							</div>
							
							<div class="form-group">
								<?= Html::submitButton('SIMPAN DATA', ['class' => 'btn btn-success btnSubmit', 'style' => 'width:180px;color:white;font-weight:bold;font-size:15px;height:40px;']) ?>
								<?php //echo Html::submitButton('SIMPAN DATA', ['class' => 'btn btn-success btnSubmit', 'style' => 'width:180px;color:white;font-weight:bold;font-size:15px;height:40px;']) ?>
							</div> 
				

				<?php ActiveForm::end(); ?>
				
					</div>
				</div>
				</div>
			</div>
		</div>
		
	</div>
	</div>
</section>
</body>
        <!-- Form wizard with vertical tabs section end -->
<?php
$url_submit = \yii\helpers\Url::to(['closing-save']);
$base_url = Yii::$app->request->baseUrl;
$script = <<< JS
		
		$(".actions").addClass("d-none");
		
		
		
		$('input[type="radio"][name="ClosingStatement[kenal_sebagai]"]').click(function () {
			if ($(this).attr("value") == 'Lainnya'){
				$("#kenal_sebagai_lainnya").removeClass("d-none");
				$("#kenal_sebagai_lainnya").focus();
			}else{
				$("#kenal_sebagai_lainnya").addClass("d-none");
			}
		});
		
		
			
		
		
		$('input[type="radio"][name="ClosingStatement[kenal_tertanggung_sebagai]"]').click(function () {
			if ($(this).attr("value") == 'Lainnya'){
				$("#kenal_tertanggung_lainnya").removeClass("d-none");
				$("#kenal_tertanggung_lainnya").focus();
			}else{
				$("#kenal_tertanggung_lainnya").addClass("d-none");
			}
		});
		
		$('input[type="radio"][name="ClosingStatement[kenal_pembayar_premi_sebagai]"]').click(function () {
			if ($(this).attr("value") == 'Lainnya'){
				$("#kenal_pembayar_premi_lainnya").removeClass("d-none");
				$("#kenal_pembayar_premi_lainnya").focus();
			}else{
				$("#kenal_pembayar_premi_lainnya").addClass("d-none");
			}
		});
		
		$('input[type="radio"][name="ClosingStatement[awal_penutupan_oleh]"]').click(function () {
			if ($(this).attr("value") == 'Lainnya'){
				$("#awal_penutupan_lainnya").removeClass("d-none");
				$("#awal_penutupan_lainnya").focus();
			}else{
				$("#awal_penutupan_lainnya").addClass("d-none");
			}
		});
		
		
		

		
		
		
		$(".btnSubmit").on('click',function(){
			 event.preventDefault();
			 
			if($("input:radio[name='ClosingStatement[kenal_pp_selama]']").is(":checked")) {
				if($("input:radio[name='ClosingStatement[kenal_sebagai]']").is(":checked")) {
					if($("input:radio[name='ClosingStatement[kenal_tertanggung_selama]']").is(":checked")) {
						if($("input:radio[name='ClosingStatement[kenal_tertanggung_sebagai]']").is(":checked")) {
							if($("input:radio[name='ClosingStatement[kenal_pembayar_premi_selama]']").is(":checked")) {
								if($("input:radio[name='ClosingStatement[kenal_pembayar_premi_sebagai]']").is(":checked")) {
									if($("input:radio[name='ClosingStatement[kesehatan_tertanggung]']").is(":checked")) {
										if($("input:radio[name='ClosingStatement[kondisi_keuangan_sesuai]']").is(":checked")) {
											
											swal({
												title: "IFG Life",
												text: "Harap Menunggu... Data Sedang Diproses",
												type: false,
												showCancelButton: false,
												showConfirmButton: false,
												imageUrl: '$base_url'+'/images/loading.gif',
											});
											

											$.ajax({
												type: "POST",
												url: "$url_submit", 
												data:  $('form').serialize(),
												dataType:"json",
												success: function(resultData) {
													if(resultData.respcode == '00'){
														swal({
															html:true,
															title: 'IFG Life',
															text: 'Data berhasil disimpan',
															type: 'success',
															timer: 5000,
															showCancelButton: false,
															showConfirmButton: false,
															},function () {
																// location.reload();
																location.href = "https://mifg.ifg-life.id";
															}
														);
													}else{
														swal({
															html:true,
															title: 'IFG Life',
															text: resultData.resp_msg,
															type: 'error',
															timer: 5000,
															showCancelButton: false,
															showConfirmButton: true
														});
													}
												}
											});
											
										}else{
											swal({ title: "AGEN PENUTUP", text: "Kondisi Keuangan Belum Diisi!", icon: "error", button: "Aww yiss!"});
										}
									}else{
										swal({ title: "AGEN PENUTUP", text: "Kondisi Kesehatan Belum Diisi!", icon: "error", button: "Aww yiss!"});
									}
								}else{
									swal({ title: "AGEN PENUTUP", text: "Harap mengisi seluruh form yang disediakan!", icon: "error", button: "Aww yiss!"});
								}
							}else{
								swal({ title: "AGEN PENUTUP", text: "Harap mengisi seluruh form yang disediakan!", icon: "error", button: "Aww yiss!"});
							}
						}else{
							swal({ title: "AGEN PENUTUP", text: "Harap mengisi seluruh form yang disediakan!", icon: "error", button: "Aww yiss!"});
						}
					}else{
						swal({ title: "AGEN PENUTUP", text: "Harap mengisi seluruh form yang disediakan!", icon: "error", button: "Aww yiss!"});
					}
				}else{
					swal({ title: "AGEN PENUTUP", text: "Harap mengisi seluruh form yang disediakan!", icon: "error", button: "Aww yiss!"});
				}
			}else{
				swal({ title: "AGEN PENUTUP", text: "Harap mengisi seluruh form yang disediakan!", icon: "error", button: "Aww yiss!"});
			}


			
		});
		
		
		
JS;
$this->registerJs($script);
?>
<script>
	function pilih(a,b){
		// alert(a);
		if ($("#"+a).prop("checked")) {
			$("#"+a).prop('checked', true);
		}else{
			document.getElementById(b).value = "";
		}
	}
	
	
	
</script>
