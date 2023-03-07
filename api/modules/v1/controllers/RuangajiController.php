<?php

namespace api\modules\v1\controllers;

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
use common\models\Settings;
use common\models\UserMobile;
use common\models\Profile;
use common\models\Content;
use common\models\QuizCategory;
use common\models\QuizLevel;
use common\models\Quiz;
use common\models\QuizList;
use common\models\QuizOptions;


class RuangajiController extends Controller
{
	private $_verbs = ['POST'];
	// private $_verbs = ['POST', 'GET', 'OPTIONS'];
	private $client;
	/**
	 * @inheritdoc
	 */
	public function beforeAction($action)
    {
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
				'except'      => ['register', 'login'],
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

	

	public function actionSetting(){
		$post = Yii::$app->request->post();
		$setting = Settings::find()->all();
		$resp = [
			'rc'=>'00',
			'msg'=>'Get Settings'
		];
		$resp['data'] = $setting;
	   	return $resp;
	}

	public function actionRegister(){
		$post = @file_get_contents('php://input');
		$data = Json::decode($post, true);
		$model = new UserMobile();
		$model->name = $data["name"];
		$model->phone = $data["phone"];
		$model->location = $data["location"];
		$model->username = $data["username"];
		$model->email = $data["email"];
		$model->password = $data["password"];

		$resp = [
			'rc'=>'00',
			'msg'=>'Get Settings'
		];


		if($model->register()){
			$dataresp = $model;
		}else{
			$dataresp = $model->getErrors();
			$resp["rc"] = "01";
			$resp['msg']='Failed';
		}
		
		$resp['data'] = $dataresp;
	   	return $resp;
	}

	public function actionLogin(){
		$post = @file_get_contents('php://input');
		$data = Json::decode($post, true);

		$resp = [
			'rc'=>'00',
			'msg'=>'login'
		];

		$model = new UserMobile();
		$model->login = $data["login"];
		$model->password = $data["password"];
		if($model->login()){
			$da = UserMobile::find()->where(['or', ['username'=>trim($data["login"])], ['email'=>trim($data["login"])]])->one();
			$dataresp = [];
			$dataresp["user"] = $da;
			$dataresp["profile"] = $da->profile;
		}else{
			$dataresp = $model->getErrors();
			$resp["rc"] = "01";
			$resp['msg']='Username/emial atau password salah';
		}
		
		$resp['data'] = $dataresp;
	   	return $resp;
	}

	public function actionGetVersion(){
		return Yii::$app->user->identity;
	}

	public function actionBanner(){
		$query = Content::find()->select(['content.*', 'c.category_name'])->where(['show_in_banner'=>1, 'status'=>1]);
		$query->join('left join', 'category c', 'content.category_id =c.id')->orderBy('id desc');
		$model = $query->all();
		$resp = [
			'rc'=>'00',
			'msg'=>'banner',
			'data'=>$model
		];
		return $resp;
	}

	public function actionContent(){
		$post = @file_get_contents('php://input');
		$data = Json::decode($post, true);
		$query = Content::find()->select(['content.*', 'c.category_name'])->where(['category_id'=>$data["category_id"], 'status'=>1]);
		$query->join('left join', 'category c', 'content.category_id =c.id')->orderBy('id desc');
		$model = $query->all();
		$resp = [
			'rc'=>'00',
			'msg'=>'Content List',
			'data'=>$model
		];
		return $resp;
	}

	public function actionContentDetail(){
		$post = @file_get_contents('php://input');
		$data = Json::decode($post, true);
		$query = Content::find()->select(['content.*', 'c.category_name'])->where(['id'=>$data["id"], 'status'=>1]);
		$query->join('left join', 'category c', 'content.category_id =c.id')->orderBy('id desc');
		$model = $query->one();
		$resp = [
			'rc'=>'00',
			'msg'=>'Content Detail',
			'data'=>$model
		];
		if($model == null){
			$resp["rc"] = "01";
			$resp["msg"] = "Content Not Found";
		}
		return $resp;
	}

	public function actionQuizCategory(){
		$query = QuizCategory::find();
		$model = $query->all();
		$resp = [
			'rc'=>'00',
			'msg'=>'Quiz Category',
			'data'=>$model
		];
		return $resp;
	}


	
}
