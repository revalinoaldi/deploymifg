<?php

$config = [
	'components' => [
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => 'X02SBQA2BPxz1Z1uG2Zn8kh73GIvvMXj',
		],
	],
];

if (!YII_ENV_TEST) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
		'allowedIPs' => ['127.0.0.1','::1','10.210.*.*', '116.68.170.74', '202.137.2.117']
	];

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		'generators' => [
			'crud' => [
				'class' => 'yii\gii\generators\crud\Generator',
				'templates' => ['doavers' => '@vendor/doavers/yii2-gii/generators/crud/doavers']
			]
		],
		'allowedIPs' => ['127.0.0.1','::1','10.210.*.*', '116.68.170.74', '202.137.2.117']
	];
}

return $config;
