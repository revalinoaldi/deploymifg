<?php
use yii\helpers\Url;
?>
<style>




.digit-group {
	input {
		width: 30px;
		height: 50px;
		border: none;
		line-height: 50px;
		text-align: center;
		font-size: 24px;
		font-family: Tahoma;
		font-weight: 200;
		color: white;
		margin: 0 2px;
	}

	.splitter {
		padding: 0 5px;
		color: white;
		font-size: 24px;
	}
}

.prompt {
	margin-bottom: 20px;
	font-size: 20px;
	color: white;
}

.hanjungbre{
	height: 60px;
	width: 350px;
	font-size:36px;
	font-weight:bold;
	text-align:center;
	border: solid #cdcdcd 1px;
	border-radius:5px;
}

.masukkan{
	width:60%;float:center;font-family:'Myriad Pro Regular';font-weight:normal;font-size:20px;-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px;height:200px;opacity:0.85;color:black;padding-top:40px;
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

@media only screen and (max-width: 768px) {
body, html {
	height: 70%;
	margin: 0;
	font-family:'Myriad Pro Regular';
	font-weight: 200;
}
.masukkan{
	width:70%;float:center;font-family:'Myriad Pro Regular';font-weight:normal;font-size:11px;-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px;height:200px;opacity:0.85;color:black;padding-top:40px;
}

.hanjungbre{
	height: 40px;
	width: 250px;
	font-size:12px;
	font-weight:bold;
	text-align:center;
	border: solid #cdcdcd 1px;
	border-radius:5px;
}

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
<body>

<div class="row" align="center">
	<div class="col-md-12" style="margin-top:20px;">
		<div class="masukkan">
			Mohon masukkan kode agen pada kolom di bawah ini :<br/><br/>
				<input type="text" id="kodeagen" name="kodeagen"  class="hanjungbre" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"   autocomplete="off" autofocus/>
				<br/>
				<br/>
				<button title="Cari Agen" class="baten" id="cari" type="button" data-toggle="tooltip" ><span class="glyphicon glyphicon-search"></span> Cari Agen</button>
		</div>
	</div>
</div>

	
</body>
<?php
$url_submit = \yii\helpers\Url::to(['verify-agent']);
$base_url = Yii::$app->request->baseUrl;
$script = <<< JS

				$('#cari').click( function() {
					var kodeagen = $("#kodeagen").val() ;
					
						$.ajax({
							type: 'POST',
							url: "$url_submit", 
							data: {data : kodeagen},
							dataType:"json",
							success: function(resultData) {
								if(resultData.respcode == '1'){
									swal({
										html:true,
										title: 'IFG Life',
										text: 'Verifikasi Agen Berhasil!',
										type: 'success',
										timer: 5000,
										showCancelButton: false,
										showConfirmButton: true,
										},function () {
											 location.href = "./form-permintaan/" + resultData.agen;
										}
									);
								}else{
									swal({
										html:true,
										title: 'TIDAK DITEMUKAN!',
										text: 'Periksa kembali kode agen yang anda masukkan..',
										type: 'error',
										timer: 12000,
										showCancelButton: false,
										showConfirmButton: true
									});
								}
							}
						});
				});
				
				
				
				
				
	
JS;
$this->registerJs($script);
?>
