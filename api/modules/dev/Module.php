<?php
namespace api\modules\dev;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Doavers API V1 Module
 * 
 * @author Doavers Light <umbur21@gmail.com>
 * @since 1.0
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\dev\controllers';

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;

        $response   = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $headers    = \Yii::$app->response->headers;
        $headers->add('Access-Control-Allow-Headers', 'Accept');
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // $behaviors['authenticator'] = [
            // 'class' => HttpBasicAuth::className(),
            // 'class' => QueryParamAuth::className(),
            /*'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
            	HttpBearerAuth::className(),
            	QueryParamAuth::className(),
            ],*/
            /*'auth' => function ($username, $password) {
                Return Identity object or null
                $loginForm = new LoginForm();
                return $loginForm->login($username, $password);

                $model = new User();
                $hashPassword = $model->setPassword($password);

                $user = User::findOne([
                    'username' => $username,
                ]);
                
                if($user != null)
                    return \Yii::$app->getSecurity()->validatePassword($password, $user->password_hash);
                else
                    return false;
                
                return User::findOne([
                    'username' => $username,
                    'password_hash' => \yii\base\Security::generatePasswordHash($password)
                ]);
            },
            'auth' => [$this, 'auth'],*/
        // ];
        /*$behaviors['bootstrap'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];*/
	    
        return $behaviors;
    }

    // public function auth($username, $password)
    // {
    //     $model = new User();
    //     $hashPassword = $model->setPassword($password);
    //     // var_dump($hashPassword); 
    //     // var_dump($model->getErrors()); die();

    //     $model = new LoginForm();
    //     //return $model->login($username, $password);
    //     //return true;
    // }
}
