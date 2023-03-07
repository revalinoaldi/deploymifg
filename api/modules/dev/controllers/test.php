public function actionGetList()
	{
		$response 	= [
			'status' 	=> 'error',
			'message' 	=> Yii::t('app','Bad request'),
			'result' 	=> []
		];

		ini_set('upload_max_filesize', '60M');     
ini_set('max_execution_time', '999');
ini_set('memory_limit', '128M');
ini_set('post_max_size', '60M'); 
    	$url = "http://wwwa.k-vision.tv/site/login";
		$params = array(
		        'username' => 'DY000001',
		        'password' => '56054'
		        );
		        
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Type: technician", "content-type: multipart/form-data", "boundary: ----WebKitFormBoundary7MA4YWxkTrZu0gW"));
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		$result = curl_exec($ch);
		if(!$result){
		    $error = curl_error($ch);
		    if ($debug) {
		        echo "<br/> error <br/>";
		        var_dump($error);
		        echo "<br/>";
		        var_dump($result);
		    }
		}

		curl_close($ch);

		return \yii\helpers\Json::decode($result);
	}