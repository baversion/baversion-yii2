<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
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
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?= $this->render('//layouts/header') ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?= $this->render('//layouts/sidebar') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>پنل مدیریت<small><?= Html::encode($this->title) ?></small></h1>
            <?php
            echo Breadcrumbs::widget([
                'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links/////////////////
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);
            ?>
        </section>

        <!-- Main content -->
        <section class="content">
            <?= Alert::widget() ?>
            <?= $content ?>
            <div class="clearfix"></div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="row">
            <div class="col-sm-12">
                <p class="pull-left">&copy;کپی‌رایت <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
                <p class="pull-right">قدرت گرفته از <a href="http://baversion.com/" target="_blank">باورژن</a>.</p>
            </div>
        </div>
    </footer>
</div>
<!-- ./wrapper -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
