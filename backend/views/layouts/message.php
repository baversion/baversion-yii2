<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition login-page">
<div class="container">
    <div class="row">
        <div class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title"><b>با</b>ورژن</a></h1>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <?php /*<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>*/ ?>
                    </div>
                </div>
                <div class="box-body">
                    <?=$content?>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    قدرت گرفته از <a href="http://baversion.com" target="_blank">باورژن</a>.
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.login-logo -->
    <div class="row">
        <?php//= $content ?>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<?php $this->endBody() ?>
</body>
<?php $this->beginBody() ?>
</html>
<?php $this->endPage() ?>
