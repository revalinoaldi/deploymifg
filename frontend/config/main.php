<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
	'timeZone' => 'Asia/Jakarta',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'cart' => [
            'class' => 'devanych\cart\Cart',
            'storageClass' => 'devanych\cart\storage\DbSessionStorage',
            'calculatorClass' => 'devanych\cart\calculators\SimpleCalculator',
            'params' => [
                'key' => 'cart',
                'expire' => 604800,
                'productClass' => 'common\models\GetStarted',
                'productFieldId' => 'id',
                'productFieldPrice' => 'price',
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => false,
                'yii\web\JqueryAsset'=>[
					'js'=>['/vendors/js/vendors.min.js']
                    // 'js'=>['/ifg-life/frontend/web/vendors/js/vendors.min.js']
                ]
            ],
        ],
        
        'urlManager' => [
                'showScriptName' => false,
                'enablePrettyUrl' => true,
                'rules' => [
                    'contact'=>'site/contact',
                    'spaj/<id:.*>'=>'site/spaj',
                    'print/<id:.*>'=>'site/print',
                    'send-form'=>'site/send-form',
                    'upload/send'=>'upload/send',
                    'from-province'=>'site/from-province',
                    'verify-otp'=>'site/verify-otp',
                    'verify-agent'=>'site/verify-agent',
                    'closing-save'=>'site/closing-save',
                    'closing/<spajform:.*>'=>'site/closing',
                    'closing-spaj/<spajform:.*>'=>'site/closing-spaj',
					'check-agent/<id:.*>'=>'site/check-agent',
                    'appointment/create'=>'appointment/create',
                    'appointment/payment-notif'=>'appointment/payment-notif',
                    'appointment/payment-recurring'=>'appointment/payment-recurring',
                    'appointment/payment-finish'=>'appointment/payment-finish',
                    'appointment/payment-unfinish'=>'appointment/payment-unfinish',
                    'appointment/payment-error'=>'appointment/payment-error',
                    'appointment/view/<id:\d+>'=>'appointment/view',
                    'details/<id:\d+>'=>'site/details',
                    'appointment/preservice/<id:\d+>'=>'appointment/preservice',
                    'appointment/schedule/<date:.*>'=>'appointment/schedule',
                    'appointment/check-schedule/<date:.*>/<time:.*>/<t:.*>'=>'appointment/check-schedule',
                    '<controller:\w+>/<action:\w+>/<v:[a-z0-9.\-]+>' => '<controller>/<action>',
                    '<slug:[A-Za-z0-9 -_.]+>/<agent:.*>' =>'site/index',
                    '<slug:[A-Za-z0-9 -_.]+>' =>'site/index',
              ], 
        ],
        
    ],
    'params' => $params,
];
