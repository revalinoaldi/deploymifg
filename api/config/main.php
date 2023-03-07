<?php

$params = array_merge(
	require(__DIR__ . '/../../common/config/params.php'),
	require(__DIR__ . '/../../common/config/params-local.php'),
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
    'timeZone' => 'Asia/Jakarta',
	'id' => 'app-api',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'modules' => [
		'v1' => [
			'basePath' => '@api/modules/v1',
			'class' => 'api\modules\v1\Module'
		],
		'dev' => [
			'basePath' => '@api/modules/dev',
			'class' => 'api\modules\dev\Module'
		],
		/*'v2' => [
			'basePath' => '@api/modules/v2',
			'class' => 'api\modules\v2\Module'
		],*/
	],
	'components' => [
		// 'user' => [
  //           'identityClass' => 'common\models\User',
  //           'enableAutoLogin' => false,
  //           // 'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
  //       ],
     //    'finnetApi' => [
	    //     'class' => 'mongosoft\soapclient\Client',
	    //     'url' => 'https://demos.finnet.co.id/devofc/FinChannelServices/routeX2.php?wsdl',
	    //     'options' => [
	    //         'cache_wsdl' => WSDL_CACHE_NONE,
	    //     ],
	    // ],
		'user' => [
	        'class' => 'common\models\UserMobile',
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
		'urlManager' => [
			'enablePrettyUrl' => true,
			'enableStrictParsing' => true,
			'showScriptName' => false,
			'rules' => [
				// Module V1
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => [
						//dev
						'ptposdev' 			=> 'dev/ptpos',
						'finnetdev' 			=> 'dev/finnet',
						'testdev' 			=> 'dev/test',
						'moldev' => 'dev/mol',
						//prod
						'finnet' 			=> 'v1/finnet',
						'digisign' 			=> 'v1/digisign',
					],
					'extraPatterns' => [
						'GET <action:\w+[-\w]+\w>' 					=> '<action>',
						'GET <action:\w+[-\w]+\w>/<id:\d+>' 		=> '<action>/',
						'POST <action:\w+[-\w]+\w>' 				=> '<action>',
						'POST <action:\w+[-\w]+\w>/<id:\d+>' 		=> '<action>/',
						'OPTIONS <action:\w+[-\w]+\w>' 				=> 'options',
					],
					'except' => ['delete', 'create', 'update'],
					'tokens' => [
						'{id}' => '<id:\\w+>'
					]
				],
				// only for integer id
				'<controller:\w+>/<id:\d+>'                             => '<controller>/view',
				'<controller:\w+>/<action:\w+[-\w]+\w>'                 => '<controller>/<action>',
				'<controller:\w+>/<action:\w+[-\w]+\w>/<id:\d+>'        => '<controller>/<action>',
				'<controller:\w+>s'                                     => '<controller>/index',
				'POST <controller:\w+>s'                                => '<controller>/create',
				'PUT <controller:\w+>/<id:\d+>'                         => '<controller>/update',
				'DELETE <controller:\w+>/<id:\d+>'                      => '<controller>/delete',
				// for id or slug
				'<controller:\w+>/<id_slug:\w+[-\w]+\w>'                => '<controller>/item',
				// for category view
				'<controller:\w+>/cat/<id_slug:\w+>'                    => '<controller>/cat',
				// blog is default controller for modules
				'<module:\w+>/<action:\w+>'                             => '<module>/blog/<action>',
				// blog is default controller for modules
				'<module:\w+>/<action:\w+>/<id:\d+>'                    => '<module>/blog/<action>',
				'<module:\w+>/<controller:\w+>'                         => '<module>/<controller>/index',
				'<module:\w+>/<controller:\w+>/<action:\w+[-\w]+\w>'    => '<module>/<controller>/<action>',
			],
		],
		'request' => [
			'enableCookieValidation' => false,
			'enableCsrfValidation' => false,
			// 'cookieValidationKey' => 'xxxxxxx',
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			]
		],
		'response' => [
			'class' => 'yii\web\Response',
			'on beforeSend' => function ($event) {
				// header("Access-Control-Allow-Origin: *");
				// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
				$now = time( );
				// $then = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $now + 60*60*3);
				$then = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $now);
				header("Expires: $then");
				
				// $response = $event->sender;
				// if ($response->data !== null)
				// {
				//     // remove "type":"yii\\web\\NotFoundHttpException"
				//     if( isset($response->data['type']) )
				//         unset($response->data['type']);

				//     $response->data = [
				//         'success' => $response->isSuccessful,
				//         'data' => $response->data,
				//     ];
				//     $response->statusCode = 200;
				// }
			},
		],
	],
	'params' => $params,
];
