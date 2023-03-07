<?php
use yii\helpers\Url;
$session = Yii::$app->session;
// $session['sess_otp'] = ['polishp' => '089668473831','polisno' => 'PLS-V7YY','polisspaj' => 'SPAJ-2202-EBF9Q'];
// var_dump($session['sess_otp']['polishp']); die;
// var_dump( $session['sess_otp']['polisno']);
// var_dump( $session['sess_otp']['polisspaj']);
if(!@$session['sess_otp']['polishp']){ return Yii::$app->response->redirect(Yii::$app->urlManager->createAbsoluteUrl(['./index'])); }
// $limitnya = date("M d, Y 15:42:00");

		// $original_num = '1234567890';
		// $random_string = "";
		// $num_valid_chars = strlen($original_num);

		// for ($i = 0; $i < 6; $i++)
		// {
			// $random_pick = mt_rand(1, $num_valid_chars);
			// $random_char = $original_num[$random_pick-1];
			// $random_string .= $random_char;
		// }

// $generate_otp = $random_string;
// echo $generate_otp;

$minutes_to_add = 3;

// $time = new DateTime('2011-11-17 05:05');
$time = date("Y-m-d H:i:s");
$limitnya = date('Y-m-d H:i:s',strtotime('+3 minutes',strtotime($time)));
// $limitnya = date('Y-m-d H:i:s',strtotime('+5 seconds',strtotime($time)));

// echo $limitnya;
?>
<style>


.digit-group {
	border: solid red 0px;
	width: 100%;
	
	input {
		width: 30px;
		height: 50px;
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
	font-size: 18px;
	color: white;
	font-family:'Myriad Pro Regular';
	font-weight:normal;
}

.hanjungbre{
	height: 60px;
	width: 80px;
	font-size:36px;
	font-weight:bold;
	text-align:center;
	/*
	border-top: 0px;
	border-left: 0px;
	border-right: 0px;
	*/
	border: solid black 1px;
	border-radius:5px;
}


@media only screen and (max-width: 768px) {
	
.hanjungbre{
	height: 10%;
	width: 15%;
	font-size:36px;
	font-weight:bold;
	text-align:center;
	/*
	border-top: 0px;
	border-left: 0px;
	border-right: 0px;
	*/
	border: solid black 1px;
	border-radius:5px;
}
}

@media only screen and (max-width: 480px) {
	
	
.hanjungbre{
	height: 10%;
	width: 15%;
	font-size:36px;
	font-weight:bold;
	text-align:center;
	/*
	border-top: 0px;
	border-left: 0px;
	border-right: 0px;
	*/
	border: solid black 1px;
	border-radius:5px;
}

}
</style>
<div class="clearfix" style="margin-bottom:50px;"></div>

<div style="width:80%;margin-left:10%;min-height:300px;background-color:white;padding:50px;-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px;opacity:0.85;color:black;">
<div style="padding-top:20px;font-family:'Myriad Pro Regular';font-size:16px;font-weight:bold;">
	Mohon masukkan kode verifikasi OTP yang telah dikirimkan ke nomor ponsel anda :<br/><br/>
	<font color='red' style="font-size:16pt;font-weight:bold;"><?=$session['sess_otp']['polishp'];?></font>
</div>

<form method="get" class="digit-group" data-group-name="digits" data-autosubmit="true" autocomplete="off">
	<input type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  id="digit-1" name="digit-1" data-next="digit-2" maxlength="1" class="hanjungbre"  autocomplete="off" autofocus/>
	<input type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1"  maxlength="1" class="hanjungbre" disabled autocomplete="off"/>
	<input type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2"  maxlength="1" class="hanjungbre" disabled autocomplete="off"/>
	<input type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3"  maxlength="1" class="hanjungbre" disabled autocomplete="off"/>
	<input type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4"  maxlength="1" class="hanjungbre" disabled autocomplete="off"/>
	<input type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  id="digit-6" name="digit-6" data-previous="digit-5"  maxlength="1" class="hanjungbre" disabled autocomplete="off"/>
</form>

<br/>
<p id="demo" style="color:red;"></p>

<!-- // || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39 -->
</div>
<?php
$url_submit = \yii\helpers\Url::to(['verify-otp']);
$base_url = Yii::$app->request->baseUrl;
$script = <<< JS

	$(".digit-group").find("input").each(function() {
	$(this).attr("maxlength", 1);
	$(this).on("keyup", function(e) {
		var parent = $($(this).parent());
		
		// alert(e.keyCode);
		
		if(e.keyCode === 8 || e.keyCode === 37) {
			var prev = parent.find("input" + $(this).data("previous"));
			
			if(prev.length) {
				$(prev).select();
			}
		} else if((e.keyCode >= 48 && e.keyCode <= 57)||(e.keyCode >= 96 && e.keyCode <= 144)|| (e.keyCode >= 229) ) {
			// alert('di sini');
			var next = parent.find("input#" + $(this).data("next"));
			
			if(next.length) {
				// alert('here');
				$(next).prop("disabled", false);
				$(next).select();
			} else {
				if(parent.data("autosubmit")) {
					
					
					var otp = $("#digit-1").val() + $("#digit-2").val() + $("#digit-3").val() + $("#digit-4").val() + $("#digit-5").val() + $("#digit-6").val() ;
					
						$.ajax({
							type: 'POST',
							url: "$url_submit", 
							data: {data : otp},
							dataType:"json",
							success: function(resultData) {
								if(resultData.respcode == '1'){
									swal({
										html:true,
										title: 'IFG Life',
										text: 'Berhasil melakukan verifikasi!',
										type: 'success',
										timer: 5000,
										showCancelButton: false,
										showConfirmButton: true,
										},function () {
											//location.href = "/spaj/"+resultData.no_spaj;
											location.href = "/spaj/" + resultData.no_spaj;
										}
									);
								}else{
									$("#digit-1").val('');
									$("#digit-2").val('');
									$("#digit-3").val('');
									$("#digit-4").val('');
									$("#digit-5").val('');
									$("#digit-6").val('');
									
									$("#digit-1").focus();
									$("#digit-2").prop("disabled", true);
									$("#digit-3").prop("disabled", true);
									$("#digit-4").prop("disabled", true);
									$("#digit-5").prop("disabled", true);
									$("#digit-6").prop("disabled", true);
									
									swal({
										html:true,
										title: 'REGISTRASI GAGAL!',
										text: resultData.resp_msg,
										type: 'error',
										timer: 12000,
										showCancelButton: false,
										showConfirmButton: true
									});
									
									
								}
							}
						});
					
				}
			}
		}
	});
});
	
JS;
$this->registerJs($script);
?>
<script>
// Set the date we're counting down to
// var countDownDate = new Date("Mar 8, 2022 15:20:25").getTime();
var countDownDate = new Date("<?php echo $limitnya;?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  // document.getElementById("demo").innerHTML = days + "d " + hours + "h "  + minutes + "m " + seconds + "s ";
  if(minutes > 0){
	  if(seconds > 0){
		document.getElementById("demo").innerHTML = "Kirim Ulang " + minutes + " menit " + seconds + " detik ";
	  }else{
		document.getElementById("demo").innerHTML = "Kirim Ulang " + minutes + " menit ";
	  }
  }else{
	document.getElementById("demo").innerHTML = "Kirim Ulang " + seconds + " detik ";
  }

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "<a href='./resend-otp/<?php echo $session['sess_otp']['polishp'];?>/<?php echo $session['sess_otp']['polisno'];?>/<?php echo $session['sess_otp']['polisspaj'];?>' style='font-weight:bold;'>Kirim Ulang</a>";
  }
}, 1000);
</script>
