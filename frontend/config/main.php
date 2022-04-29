<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'/*, 'assetsAutoCompress'*/],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\Users',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
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
//                'file' => [
//                    'class' => 'yii\log\FileTarget',
//                    'categories' => ['yii\web\HttpException:404'],
//                    'levels' => ['error', 'warning'],
//                    'logFile' => '@runtime/logs/404.log',
//                ],
//                'email' => [
//                    'class' => 'yii\log\EmailTarget',
//                    'except' => ['yii\web\HttpException:404'],
//                    'levels' => ['error', 'warning'],
//                    'message' => ['from' => 'robot@example.com', 'to' => 'admin@example.com'],
//                ],
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'categories' => ['catalog'],
//                    'logFile' => '@app/runtime/logs/catalog.log',
//                ],
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'categories' => ['basket'],
//                    'logFile' => '@app/runtime/logs/basket.log',
//                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapPluginAsset' => ['js'=>[]],
                'yii\bootstrap\BootstrapAsset' => ['css' => []],
                /*'borales\medium\Asset' => [
                    // set `bootstrap` theme for Medium Editor widget as a default one
                    'theme' => 'bootstrap',
                    // switch Medium Editor sources from the "latest" to the specific version
                    'useLatest' => false,
                    // use specific version of Medium Editor plugin with "useLatest=false"
                    'cdnVersion' => '5.22.1',
                ],*//* The following config is for local usage*/
                'borales\medium\Asset' => [
                    // use Medium Editor plugin sources from this path
                    'sourcePath' => '@bower/medium-editor/dist',
                ],
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'pattern' => 'sitemap<sitemap:-\w+>',
                    'route' => 'site/sitemap',
                    'suffix' => '.xml',
                    'defaults' => ['sitemap' => null],
                ],

                // Site
                '<controller:blog>/<action:post>/<slug:[a-z0-9\-]+>' => '<controller>/post',
                '<controller:blog>' => '<controller>/index',
                '<controller:docs>/<action:edit>/<id:\d+>' => '<controller>/edit',
                '<controller:docs>/<doc:[a-z0-9\-]+>/<version:[0-9\.]+>/<post:[a-z0-9\-]+>' => '<controller>/post',
                '<controller:docs>/<doc:[a-z0-9\-]+>/<version:[0-9\.]+>' => '<controller>/doc',
                '<controller:docs>' => '<controller>/index',

                '<controller:terminologies>/<action:term>/<slug:[a-z0-9\-]+>' => '<controller>/term',
                '<controller:terminologies>' => '<controller>/index',
                '<action:upload>' => 'images/upload',
                '<controller:tag>/<slug:[a-z0-9\-]+>' => '<controller>/tag',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<action:\w+>' => 'site/<action>',
                '<controller:\w+>' => '<controller>/index',
            ],
        ],
//        'assetsAutoCompress' => [ /* For new assets: Also uncomment bootstrap index, delete old assetes and run a page*/
//            'class' => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
//        ],
    ],
//    'catchAll' => [
//            'site/maintenance',
//            'hour' => '17:00',
//        ],
    'params' => $params,
];