<?php

namespace api\modules\dev\controllers;

use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use api\components\ApiCompositeAuth;
use api\components\ApiHttpBearerAuth;
use linslin\yii2\curl;
use conquer\helpers\Array2Xml;


class MolController extends Controller
{
	// private $_verbs = ['POST'];
	private $_verbs = ['POST','GET','OPTIONS'];
	protected $clientAuth;
	protected $molMsg, $requestXML, $requeryXML;

	/**
	 * @inheritdoc
	 */
	public function beforeAction($action)
    {
        // $this->clientAuth = base64_encode(Yii::$app->params['ptpost_client_id'].':'.Yii::$app->params['ptpost_client_secreet']);
        $this->requestXML = 'Request XML';
        $this->requeryXML = 'Requery XML';
        return parent::beforeAction($action);
    }

	public function behaviors()
	{
		$this->cors();

		$behaviors = parent::behaviors();
		unset($behaviors['authenticator']);

		return ArrayHelper::merge(parent::behaviors(), [
			'verbs'         => [
				'class'   => VerbFilter::className(),
				'actions' => [
					// '*' => ['POST'],
					'*' => ['GET', 'POST', 'OPTIONS'],
				],
			],
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
				'cors'  => [
					'Origin'                           => ['*'], // ['%.%.%.%'],
					// 'Access-Control-Request-Method'    => ['POST'],
					'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
					'Access-Control-Request-Headers'   => ['Origin', 'X-Requested-With', 'Content-Type', 'Accept', 'Authorization', 'User-Type'],
					'Access-Control-Allow-Credentials' => true,
					'Access-Control-Max-Age'           => 86400,
					'Access-Control-Expose-Headers'    => ['X-Pagination-Current-Page'],
				],
			],
			'authenticator' => [
				'class'       => ApiCompositeAuth::className(),
				'except'      => ['inquiry', 'trx', 'purchase', 'advice', 'balance-inquiry'],
				'authMethods' => [
					ApiHttpBearerAuth::className(),
				],
			],
		]);
	}

	protected function cors()
	{
		// Allow from any origin
		if(isset($_SERVER['HTTP_ORIGIN']))
		{
			// header("Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN']);
			header("Access-Control-Allow-Origin: *");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}

		// Access-Control headers are received during OPTIONS requests
		if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
		{
			if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				// header("Access-Control-Allow-Methods: POST");         
				header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS");         

			if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, User-Type");
		}
	}

	public function actions()
	{
		$actions = parent::actions();

		$actions['options'] = [
			'class' => '\yii\rest\OptionsAction',
			'collectionOptions' =>  $this->_verbs,
			'resourceOptions' =>  $this->_verbs
		];

		return $actions;
	}

	public function actionOptions()
	{
		Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization, User-Type');
	}


	public function actionTrx(){
		$curl = new curl\Curl();
		$post = Yii::$app->request->post();
		$profit = '100';
		// $trxid = $post['trxid'];
		// $prodcode = $post['productcode'];
		// $profit = $post['profit'];
		$prodcode = 'AYT-V10';
		$trxid = rand(10,100);
		$uid = Yii::$app->params['mol_userid'];
		// var_dump($uid);die();
		$params = [
		    'function' => $this->requestXML,
		    'id' => $uid,
		    'trx' => $trxid,
		    'pwd' => sha1($trxid.$uid.Yii::$app->params['mol_msg_key']),
		    'productcode' => $prodcode,
		    
		];
		// $params['sign'] = $this->generateSign($params);

		$xml = Array2Xml::encodeXml($params, 'ayopay');
		
		// echo $xml;die();
		$response = $curl->setRawPostData($xml)
		     ->setHeaders([
		        'Content-Type' => 'text/xml',
		     ])
		     ->post(Yii::$app->params['mol_voucher_game_endpoint']);
		     $res = json_encode(simplexml_load_string($response));
		     
		// var_dump($res['trx_ayopay']);die();
		if ($curl->errorCode === null) {
			$sn = '';
			$notify = '';
			$status = 25;
			$data = Json::decode($res);

	     	if($data['status'] == '100'){
	     		$voucher = explode(',', $data['voucher']);
		    	$vcode = explode('=', $voucher[1]);
		    	$sn = $vcode[1];
		    	$status = 3;
		    	$notify = $voucher[1];
	     	} elseif ($data['status'] == '0' || $data['status'] == '12' || $data['status'] == '10') {
	     		# failed
	     		$sn = '';
		    	$status = 25;
		    	$notify = '';
	     	} elseif ($data['status'] == '96' || $data['status'] == '99') {
	     		# biller error
	     		$sn = '';
		    	$status = 26;
		    	$notify = '';
	     	} elseif ($data['status'] == '88') {
	     		# biller error
	     		$sn = '';
		    	$status = 21;
		    	$notify = '';
	     	}
			$resp = [];
			$resp['method'] = 'mol';
			$resp['transaction_id'] = $trxid;
			$resp['notify'] = $notify;
			$resp['references'] = $sn;
			$resp['profit'] = $profit;
			$resp['status'] = $status;
			$resp['request'] = $params;
			$resp['log']['params'] = $post;
			$resp['log']['response'] = Json::decode($res);
			Yii::$app->cache->set('mol_'.$params['trx'], Json::encode($resp));
		   	return $resp;
		} else {
			$sn = '';
			$notify = '';
			$status = 2;
			$resp = [];
			$resp['method'] = 'mol';
			$resp['transaction_id'] = $trxid;
			$resp['notify'] = $notify;
			$resp['references'] = $sn;
			$resp['profit'] = $profit;
			$resp['status'] = $status;
			$resp['request'] = $params;
			$resp['log']['params'] = $post;
			$resp['log']['response'] = $curl->errorCode;
			Yii::$app->cache->set('mol_'.$params['trx'], Json::encode($resp));
			return $curl->errorCode;
		} 
	}


	public function actionAdvice(){
		$curl = new curl\Curl();
		$post = Yii::$app->request->post();
		// $trxid = $post['trxid'];
		$trxid = '55';
		$data = Json::decode(Yii::$app->cache->get('mol_'.$trxid));
		$trxReq = $data['request'];
		$uid = Yii::$app->params['mol_userid'];
		$params = [
		    'function' => $this->requeryXML,
		    'id' => $uid,
		    'trx' => $trxReq['trx'],
		    'pwd' => sha1($trxReq['trx'].$uid.Yii::$app->params['mol_msg_key']),
		    'productcode' => $trxReq['productcode'],
		    
		];
		// $params['sign'] = $this->generateSign($params);

		$xml = Array2Xml::encodeXml($params, 'ayopay');

		$response = $curl->setRequestBody(json_encode($params))
		     ->setHeaders([
		        'Content-Type' => 'text/xml',
		     ])
		     ->post(Yii::$app->params['ptpost_endpoit']);
		     $res = json_encode(simplexml_load_string($response));
		if ($curl->errorCode === null) {
			$sn = '';
			$status = 25;
			$data = Json::decode($res);
	     	if($data['status'] == '100'){
	     		$voucher = explode(',', $data['voucher']);
		    	$vcode = explode('=', $voucher[1]);
		    	$sn = $vcode[1];
		    	$status = 3;
		    	$notify = $voucher[1];
	     	} elseif ($data['status'] == '0' || $data['status'] == '12' || $data['status'] == '10') {
	     		# failed
	     		$sn = '';
		    	$status = 25;
		    	$notify = '';
	     	} elseif ($data['status'] == '96' || $data['status'] == '99') {
	     		# biller error
	     		$sn = '';
		    	$status = 26;
		    	$notify = '';
	     	} elseif ($data['status'] == '88') {
	     		# biller error
	     		$sn = '';
		    	$status = 21;
		    	$notify = '';
	     	} 
			$resp = [];
			$resp['method'] = 'mol';
			$resp['transaction_id'] = $trxid;
			$resp['notify'] = $notify;
			$resp['references'] = $sn;
			$resp['profit'] = $profit;
			$resp['status'] = $status;
			$resp['request'] = $params;
			$resp['log']['params'] = $post;
			$resp['log']['response'] = Json::decode($res);
			Yii::$app->cache->set('mol_'.'advice_'.$params['trxId'], Json::encode($resp));
		   	return $resp;
		} else {
			return $curl->errorCode;
		} 
	}

	
}
