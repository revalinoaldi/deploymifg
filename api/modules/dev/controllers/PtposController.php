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


class PtposController extends Controller
{
	private $_verbs = ['POST'];
	protected $clientAuth;

	/**
	 * @inheritdoc
	 */
	public function beforeAction($action)
    {
        $this->clientAuth = base64_encode(Yii::$app->params['ptpost_client_id'].':'.Yii::$app->params['ptpost_client_secreet']);
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
					'*' => ['POST'],
					// '*' => ['GET', 'POST', 'OPTIONS'],
				],
			],
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
				'cors'  => [
					'Origin'                           => ['*'], // ['%.%.%.%'],
					'Access-Control-Request-Method'    => ['POST'],
					// 'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
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
				header("Access-Control-Allow-Methods: POST");         
				// header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS");         

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

	public function generateSign($data){
		$param='';
		$param .= $data['type'];
		$param .= $data['account'];
		$param .= $data['institutionCode'];
		$param .= $data['product'];
		$param .= $data['billNumber'];
		$param .= $data['trxId'];
		$param .= Yii::$app->params['ptpost_password'];
		$param .= date('Y-m-d');
		$param .= Yii::$app->params['ptpost_key'];
		return md5($param);
	}

	public function actionInquiry(){
		$curl = new curl\Curl();
		$post = Yii::$app->request->post();
		$params = [
		    'type' => 'inquiry',
		    'accountType' => 'B2B',
		    'account' => Yii::$app->params['ptpost_account'],
		    'institutionCode' => Yii::$app->params['ptpost_institutionCode'],
		    'product' => $post['product_id'],
		    'billNumber' => $post['subscriber_id'],
		    'trxId' => $post['trxid'],
		    'retrieval' => date('YmdHisz'),
		];
		$params['sign'] = $this->generateSign($params);

		$response = $curl->setRequestBody(json_encode($params))
		     ->setHeaders([
		     	'Authorization' => $this->clientAuth,
		        'Content-Type' => 'application/json',
		        'Origin' => 'narindo.com',
		        'Content-Length' => strlen(json_encode($params))
		     ])
		     ->post(Yii::$app->params['ptpost_endpoit']);

		$up = 1100;
		if(isset(Yii::$app->params["p".$post['product_id']])){
			$up = Yii::$app->params["p".$post['product_id']];
		}

		if ($curl->errorCode === null) {
			$resp = [];
			$resp['request'] = $params;
			$resp['params'] = $post;
			$resp['response'] = Json::decode($response);
			$resp['response']['mod_price'] = $up;
			Yii::$app->cache->set('ptpos_'.$params['trxId'], Json::encode($resp));
		   	return $resp;
		} else {
			return $curl->errorCode;
		} 
	}

	public function actionTrx(){
		$curl = new curl\Curl();
		$post = Yii::$app->request->post();
		$data = Json::decode(Yii::$app->cache->get('ptpos_'.$post['trxid']));
		$inqResp = $data['response'];
		$params = [
		    'type' => 'payment',
		    'accountType' => 'B2B',
		    'account' => Yii::$app->params['ptpost_account'],
		    'institutionCode' => Yii::$app->params['ptpost_institutionCode'],
		    'product' => $inqResp['product'],
		    'billNumber' => $inqResp['billNumber'],
		    'trxId' => $inqResp['trxId'],
		    'retrieval' => date('YmdHisz'),
		    'paymentCode' => $inqResp['paymentCode']
		];
		$params['sign'] = $this->generateSign($params);

		$response = $curl->setRequestBody(json_encode($params))
		     ->setHeaders([
		     	'Authorization' => $this->clientAuth,
		        'Content-Type' => 'application/json',
		        'Origin' => 'narindo.com',
		        'Content-Length' => strlen(json_encode($params))
		     ])
		     ->post(Yii::$app->params['ptpost_endpoit']);

		$up = 1100;
		if(isset(Yii::$app->params["p".$inqResp['product']])){
			$up = Yii::$app->params["p".$inqResp['product']];
		}

		if ($curl->errorCode === null) {
			$resp = [];
			$resp['request'] = $params;
			$resp['params'] = $post;
			$resp['response'] = Json::decode($response);
			$resp['response']['mod_price'] = $up;
			Yii::$app->cache->set('ptpos_'.'trx_'.$params['trxId'], Json::encode($resp));
		   	return $resp;
		} else {
			return $curl->errorCode;
		} 
	}

	public function actionPurchase(){
		$curl = new curl\Curl();
		$post = Yii::$app->request->post();
		$params = [
		    'type' => 'purchase',
		    'accountType' => 'B2B',
		    'account' => Yii::$app->params['ptpost_account'],
		    'institutionCode' => Yii::$app->params['ptpost_institutionCode'],
		    'product' => $post['product_id'],
		    'billNumber' => $post['subscriber_id'],
		    'trxId' => $post['trxid'],
		    'retrieval' => date('YmdHisz')
		];
		$params['sign'] = $this->generateSign($params);

		$response = $curl->setRequestBody(json_encode($params))
		     ->setHeaders([
		     	'Authorization' => $this->clientAuth,
		        'Content-Type' => 'application/json',
		        'Origin' => 'narindo.com',
		        'Content-Length' => strlen(json_encode($params))
		     ])
		     ->post(Yii::$app->params['ptpost_endpoit']);

		$up = 1100;
		if(isset(Yii::$app->params["p".$post['product_id']])){
			$up = Yii::$app->params["p".$post['product_id']];
		}

		if ($curl->errorCode === null) {
			$resp = [];
			$resp['request'] = $params;
			$resp['params'] = $post;
			$resp['response'] = Json::decode($response);
			$resp['response']['mod_price'] = $up;
			Yii::$app->cache->set('ptpos_'.'trx_'.$params['trxId'], Json::encode($resp));
		   	return $resp;
		} else {
			return $curl->errorCode;
		} 
	}

	public function actionAdvice(){
		$curl = new curl\Curl();
		$post = Yii::$app->request->post();
		$data = Json::decode(Yii::$app->cache->get('ptpos_'.$post['trxid']));
		$trxResp = $data['response'];
		$params = [
		    'type' => 'advice',
		    'accountType' => 'B2B',
		    'account' => Yii::$app->params['ptpost_account'],
		    'institutionCode' => Yii::$app->params['ptpost_institutionCode'],
		    'product' => $trxResp['product'],
		    'billNumber' => $trxResp['billNumber'],
		    'trxId' => $trxResp['trxId'],
		    'retrieval' => date('YmdHisz'),
		    'paymentCode' => $trxResp['paymentCode']
		];
		$params['sign'] = $this->generateSign($params);

		$response = $curl->setRequestBody(json_encode($params))
		     ->setHeaders([
		     	'Authorization' => $this->clientAuth,
		        'Content-Type' => 'application/json',
		        'Origin' => 'narindo.com',
		        'Content-Length' => strlen(json_encode($params))
		     ])
		     ->post(Yii::$app->params['ptpost_endpoit']);

		$up = 1100;
		if(isset(Yii::$app->params["p".$trxResp['product']])){
			$up = Yii::$app->params["p".$trxResp['product']];
		}

		if ($curl->errorCode === null) {
			$resp = [];
			$resp['request'] = $params;
			$resp['params'] = $post;
			$resp['response'] = Json::decode($response);
			$resp['response']['mod_price'] = $up;
			Yii::$app->cache->set('ptpos_'.'advice_'.$params['trxId'], Json::encode($resp));
		   	return $resp;
		} else {
			return $curl->errorCode;
		} 
	}

	public function actionBalanceInquiry(){
		$curl = new curl\Curl();
		$post = Yii::$app->request->post();
		$params = [
		    'type' => 'balanceInquiry',
		    'accountType' => 'B2B',
		    'account' => Yii::$app->params['ptpost_account'],
		    'institutionCode' => Yii::$app->params['ptpost_institutionCode'],
		    'product' => $post['product_id'],
		    'billNumber' => $post['subscriber_id'],
		    'trxId' => $post['trxid'],
		    'retrieval' => date('YmdHisz')
		];
		$params['sign'] = $this->generateSign($params);

		$response = $curl->setRequestBody(json_encode($params))
		     ->setHeaders([
		     	'Authorization' => $this->clientAuth,
		        'Content-Type' => 'application/json',
		        'Origin' => 'narindo.com',
		        'Content-Length' => strlen(json_encode($params))
		     ])
		     ->post(Yii::$app->params['ptpost_endpoit']);

		if ($curl->errorCode === null) {
		   	$resp = [];
			$resp['request'] = $params;
			$resp['params'] = $post;
			$resp['response'] = Json::decode($response);
			Yii::$app->cache->set('ptpos_'.'balance_'.$params['trxId'], Json::encode($resp));
		   	return $resp;
		} else {
			return $curl->errorCode;
		} 
	}

	
}
