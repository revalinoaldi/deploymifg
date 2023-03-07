<?php

namespace api\modules\dev\controllers;

use Yii;
use yii\db\Query;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use api\components\ApiCompositeAuth;
use api\components\ApiHttpBearerAuth;
use common\helpers\Tool;
use linslin\yii2\curl;


class TestController extends Controller
{
    public function actionTestFinnet(){
        /*
		$data['trxid'] = '99999999';
		$data['merchant_id'] = '12345678';
		$data['product_id'] = '001001';
		$data['subscriber_id'] = '161601212110';
        

		$curl = new curl\Curl();
		$response = $curl->setPostParams($data)
		     ->post('http://192.168.5.35:8001/newyii/v1/finnet/inquiry');
        
        return $response;*/
        $saldo = 5555;
        $message = Yii::$app->mailer->compose()
                ->setTo('nnsulistyo117@gmail.com')
                ->setFrom(['nana.sulistyo@narindo.com' => 'Test'])
                ->setSubject('Test ' . date('Y-m-d'))
                ->setHtmlBody('Dear <b> ' . $saldo . ' </b><br> ' )
                ->send();
        return $saldo;
	}
    
	public function actionIndex(){
		$data['trxid'] = '80518094922081298298622';
		$data['trxid'] = '9241212121212121';
		$data['merchant_id'] = '92412345';
		$data['product_id'] = '001001';
		$data['subscriber_id'] = '02182621812';
		$data['trxid'] = '22609';
		$data['billNumber'] = '301010285750';

		// $data['trxid'] = '80518094922081298298622';
		// $data['trxid'] = '9241212121212121';
		// $data['merchant_id'] = '92412345';
		// $data['product_id'] = '001001';
		// $data['subscriber_id'] = '0354777123';
		// $data['subscriber_id'] = '401000023151';
		// $data['trxid'] = '22609';
		// $data['billNumber'] = '301010285750';

		// $data['trxid'] = '99999999';
        
  //       #PLN PREPAID
		// $data['product_id'] = '4070';
  //       $data['subscriber_id'] = '16012737';
        
        #TSEL POSTPAID
		#$data['product_id'] = '5003';
		#$data['subscriber_id'] = '081285136739';
        
        #PRABAYAR
		#$data['product_id'] = '6001';
		#$data['subscriber_id'] = '085293589722';
        
        #PLN POSTPAID
        #$data['product_id'] = '3008';
        #$data['subscriber_id'] = '172710073933';
		// $data['trxid'] = 'NSK00002';
		// $data['product_id'] = '2023';
		// $data['subscriber_id'] = '103111601135';

		// $data['traxId'] = $post['trxid'];
		// $data['terminal'] = $post['merchant_id'];
		// $data['productCode'] = $post['product_id'];
		// $data['bit61'] = $post['subscriber_id'];
		// $data['billNumber'] = $post['subscriber_id'];

				// var_dump(json_encode($dataPayment));die;
		$curl = new curl\Curl();
		$response = $curl->setPostParams($data)
		// http://wwwa.k-vision.tv/technician/get-order-list
		    #->post('http://localhost/v1/finnet/inquiry');
            ->post('http://192.168.5.35:8001/newyii/v1/finnet/inquiry');
		     // ->post('http://192.168.5.35:8001/finnet-multi/index.php/inquiry');
		     // ->post('http://localhost/dev/ptpos/inquiry');
		//https://staging.doku.com/api/payment/paymentMip
		     // ->post('https://staging.doku.com/api/payment/paymentMip');
		     // ->post('http://wwwa.k-vision.tv/doku/do-payment');
		     // var_dump($response);die;
        
        return json_decode($response);
		#return stripslashes(json_encode($response,JSON_UNESCAPED_SLASHES));
	}

	public function actionTrx(){
		$curl = new curl\Curl();
		$response = $curl->setPostParams([ 
			    'trxid' =>       '12345698',
			    'product_id' =>  '4049',
			    'billNumber' =>  'BN0000088',
			    'paymentCode' => 'PC0000088',
		     ])
		     ->post('http://192.168.5.35:8001/newyii/v1/ptpos/trx');
        return $response;
		#return Json::decode($response);
	}

	public function actionAdvice(){ 
		$curl = new curl\Curl();
		$response = $curl->setPostParams([
			    'trxid' => '811161418380618217315'
		     ])
		     ->post('http://192.168.5.35:8001/newyii/v1/finnet/advice');

		return $response;
	}

	public function actionPurchase(){
		$curl = new curl\Curl();
		$response = $curl->setPostParams([
				'product_id' => '30091',
			    'subscriber_id' => '543101327128',
			    'trxid' => 'NSK99958'
		     ])
		     ->post('http://192.168.5.35:8001/newyii/v1/ptpos/purchase');

		return Json::decode($response);
	}

	public function actionTestfile(){
        $nama_file = date('Ymd').".txt";
            $vaLog = '/var/lib/nskdev/api-services/logpos/'.$nama_file;
            $tipe = "INQ";
            
            if(file_exists($vaLog) == '1'){
                file_put_contents($vaLog, "\n".date('d-m-Y H:i:s').$tipe.'--'.json_encode($params), FILE_APPEND);
                file_put_contents($vaLog, "\n".date('d-m-Y H:i:s').$tipe.'--'.json_encode($respon), FILE_APPEND);
            }else{
                $createFile = fopen($vaLog, "w");
                
                file_put_contents($vaLog, "\n".date('d-m-Y H:i:s').$tipe.'--'.json_encode($params), FILE_APPEND);
                file_put_contents($vaLog, "\n".date('d-m-Y H:i:s').$tipe.'--'.json_encode($respon), FILE_APPEND);
            }
    }
    
    public function actionBalance(){

		$data['trxid'] = '12345698';
        
        #PLN PREPAID
		$data['product_id'] = '4049';
        $data['subscriber_id'] = '60136845';
        
		$curl = new curl\Curl();
		$response = $curl->setPostParams($data)
		     ->post('http://192.168.5.35:8001/newyii/v1/ptpos/balance-inquiry');
        
        return $response;
	}
}
