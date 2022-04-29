<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/bootstrap.min.js',
        'js/adminlte.min.js'
    ];
    public $css = [
        'css/bootstrap-rtl.css',
        'css/admin-lte.min.css',
        'css/fontawesome-all.min.css',
        'css/skin-blue.min.css',
        'css/style.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
