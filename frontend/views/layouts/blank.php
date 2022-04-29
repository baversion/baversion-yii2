<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="og:title" content="<?= Html::encode($this->title) ?>">
    <meta name="og:type" content="article">
    <meta name="og:site_name" content="باورژن"/>
    <?php if (isset($this->params['meta']['keywords'])): ?>
        <meta name="keywords" content="<?= $this->params['meta']['keywords'] ?>">
    <?php endif; ?>
    <?php if (isset($this->params['meta']['description'])): ?>
        <meta name="description" content="<?= $this->params['meta']['description'] ?>">
        <meta name="og:description" content="<?= $this->params['meta']['description'] ?>">
    <?php endif; ?>
    <meta name="og:url" content="<?= Url::current([], true) ?>">
    <?php if (isset($this->params['meta']['image'])): ?>
        <meta name="og:image" content="<?= $this->params['meta']['image'] ?>">
    <?php endif; ?>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <?= $this->render('//layouts/header') ?>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (Yii::$app->session->hasFlash('info')): ?>
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fas fa-info"></span> توجه!</h4>
                    <?= Yii::$app->session->getFlash('info') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('danger')): ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fas fa-times-circle"></span> اخطار!</h4>
                    <?= Yii::$app->session->getFlash('danger') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fas fa-times-circle"></span> اخطار!</h4>
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('warning')): ?>
                <div class="alert alert-warning alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fas fa-exclamation-triangle"></span> هشدار!</h4>
                    <?= Yii::$app->session->getFlash('warning') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fas fa-check"></span> توجه!</h4>
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div><!-- /.row -->
</div>
<?= $this->render('//layouts/footer') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
