<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'generalFunction' => [
            'class' => 'common\components\GeneralFunction', 
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        // 'user' => [
        //     'class' => 'dektrium\user\Module',
        // ],
        // 'cache' => [
        //     'class' => 'yii\caching\MemCache',
        //     'servers' => [
        //         [
        //             'host' => '127.0.0.1',
        //             'port' => 11211,
        //             'weight' => 100,
        //         ]
        //     ],
        // ],
    ],
];
