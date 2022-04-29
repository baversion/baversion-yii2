<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        /**
         * I commented the following lines until fix the problem with minifier vendor.
         * It has conflict with TinyMCE and CkEditor.
         */
        'css/bootstrap-rtl.min.css',
        'css/fontawesome-all.min.css',
        'css/animate.min.css',
        'css/style.css',
//        'assets/css-compress/fb1566e3a1e26fe8afb7135b467a5bb7.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
