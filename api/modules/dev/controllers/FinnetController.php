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
use narindo\Nusoap\NusoapClient;
use DateTime;


class FinnetController extends Controller
{
	// private $_verbs = ['POST'];
	private $_verbs = ['POST', 'GET', 'OPTIONS'];
	private $client;
	/**
	 * @inheritdoc
	 */
	public function beforeAction($action)
    {
        $this->client = new NusoapClient(Yii::$app->params['finnet_endpoint'], true);
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
				'except'      => ['inquiry', 'trx', 'advice'],
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

	public function generateData($data){
		$password = Yii::$app->params['finnet_password'];
		$data['merchantCode'] = Yii::$app->params['finnet_merchant_code'];
		$data['merchantNumber'] = Yii::$app->params['finnet_merchant_number'];
		$data['userName'] = Yii::$app->params['finnet_username'];
		$data['transactionType'] = '38';
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
	    $timeStamp = $d->format("d-m-Y H:i:s:u");

	    $data['timeStamp'] = $timeStamp;
	    $data['signature'] = SHA1($data['userName'].MD5($password).$data['productCode'].$data['merchantCode'].$data['terminal'].$data['merchantNumber'].$data['transactionType'].$data['billNumber'].$data['bit61'].$data['traxId'].$timeStamp);
		return $data;
	}

	public function generateTrxData($data){
		$params = [];
		$password = Yii::$app->params['finnet_password'];
		$params['userName'] = Yii::$app->params['finnet_username'];
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
	    $timeStamp = $d->format("d-m-Y H:i:s:u");
	    $params['timeStamp'] = $timeStamp;
	    $params['transactionType'] = '50';

        $params['productCode'] = $data['productCode'];
        $params['merchantCode'] = $data['merchantCode'];
	    $params['terminal'] = $data['terminal'];
	    $params['merchantNumber'] = $data['merchantNumber'];
	    $params['billNumber'] = $data['billNumber'];
	    $params['amount'] = $data['amount'];
		$params['feeAmount'] = $data['feeAmount'];
	    $params['bit61'] = $data['bit61'];
	    $params['traxId'] = $data['traxId'];

	    $params['signature'] = SHA1($params['userName'].MD5($password).$params['productCode'].$params['merchantCode'].$params['terminal'].$params['merchantNumber'].$params['transactionType'].$params['billNumber'].$params['amount'].$params['feeAmount'].$params['bit61'].$params['traxId'].$timeStamp);
	    return $params;
	}

	public function generateAdviceData($data){
		$password = Yii::$app->params['finnet_password'];
		$params = [];
		$params['merchantCode'] = $data['merchantCode'];
		$params['merchantNumber'] = $data['merchantNumber'];
		$params['userName'] = Yii::$app->params['finnet_username'];
		$params['transactionType'] = '77';
		$params['traxId'] = $data['traxId'];
		$params['terminal'] = $data['terminal'];
		$params['productCode'] = $data['productCode'];
		$params['bit61'] = $data['bit61'];
		$params['billNumber'] = $data['billNumber'];
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
	    $timeStamp = $d->format("d-m-Y H:i:s:u");

	    $params['timeStamp'] = $timeStamp;
	    $params['signature'] = SHA1($params['userName'].MD5($password).$params['productCode'].$params['merchantCode'].$params['terminal'].$params['merchantNumber'].$params['transactionType'].$params['billNumber'].$params['bit61'].$params['traxId'].$timeStamp);
		return $params;
	}

	public function actionInquiry(){
		// $post = Yii::$app->request->post();
		// $data['traxId'] = $post['trxid'];
		// $data['terminal'] = $post['merchant_id'];
		// $data['productCode'] = $post['product_id'];
		// $data['bit61'] = $post['subscriber_id'];
		// $data['billNumber'] = $post['subscriber_id'];

		$data['traxId'] = '924123456789123456';
		$data['terminal'] = '92412345';
		$data['productCode'] = '090001';
		$data['bit61'] = '301010285750';
		// $data['billNumber'] = '401000023151';
		$data['billNumber'] = '301010285750';

		$param['inputBillPayment']=$this->generateData($data);

		
       	$result = $this->client->call('billpayment', $param, 'routeDx2');
       	$resp = [];
       	$resp['params'] = $data;
       	$resp['request'] = $param;
       	$resp['response'] = $result;
       	Yii::$app->cache->set('finnet_'.$data['traxId'], Json::encode($resp));
	   	return $resp;
	}

	public function actionTrx(){
		$post = Yii::$app->request->post();
		// $post['trxid'] = '924123456789123456';
		$data = Json::decode(Yii::$app->cache->get('finnet_'.$post['trxid']));
		$inqData = $data['response'];

		$params['inputBillPayment'] = $this->generateTrxData($inqData);

		$result = $this->client->call('billpayment', $params, 'routeDx2');
       	$resp = [];
       	$resp['params'] = $post;
       	$resp['request'] = $params;
       	$resp['response'] = $result;
       	Yii::$app->cache->set('finnet_trx_'.$inqData['traxId'], Json::encode($resp));
	   	return $resp;
	}

	public function actionAdvice(){
		$post = Yii::$app->request->post();
		// $post['trxid'] = '924123456789123456';
		$post['trxid'] = '811161418380618217315';
		$data = Json::decode(Yii::$app->cache->get('finnet_trx_'.$post['trxid']));
		$trxData = $data['request']['inputBillPayment'];

		$params['inputBillPayment'] = $this->generateAdviceData($trxData);

		$result = $this->client->call('billpayment', $params, 'routeDx2');
		var_dump($result);die;
       	$resp = [];
       	$resp['params'] = $post;
       	$resp['request'] = $params;
       	$resp['response'] = $result;
       	Yii::$app->cache->set('finnet_advice_'.$trxData['traxId'], Json::encode($resp));
	   	return $resp;
	}
	
}
