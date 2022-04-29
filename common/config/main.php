<?php
use yii\helpers\Url;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name' => 'باورژن',
    'language' => 'fa-IR',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'jdate' => [
            'class' => 'jDate\DateTime'
        ],
    ],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.*'],
        ],
        'markdown' => [
            // the module class
            'class' => 'kartik\markdown\Module',

            // the controller action route used for markdown editor preview
            'previewAction' => '/markdown/parse/preview',

            // the list of custom conversion patterns for post processing
            'customConversion' => [
                '<table>' => '<div><table class="table table-bordered table-striped">',
                '</table>' => '</table></div>',
            ],

            // whether to use PHP SmartyPantsTypographer to process Markdown output
            'smartyPants' => true
        ]
    ],
];
