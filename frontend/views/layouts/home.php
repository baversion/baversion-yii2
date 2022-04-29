<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?= Html::csrfMetaTags() ?>
    <title>باورژن - آموزش برنامه‌نویسی، داکیومنت زبان‌های برنامه‌نویسی</title>
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->head() ?>
</head>

<body class="home">
<?php $this->beginBody() ?>
<div class="welcome d-flex justify-content-center flex-column">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark pt-4 px-0">
            <?= $this->render('//layouts/header') ?>
        </nav>
    </div>
    <!-- Inner Wrapper -->
    <div class="inner-wrapper mt-auto mb-auto container">
        <div class="row">
            <div class="col-md-7">
                <h1 class="welcome-heading display-4 text-white mb-4">باورژن</h1>
                <p class="text-white mb-4">آموزش برنامه‌نویسی صحیح و حرفه‌ای</p>
                <a href="/docs/laravel/5.6" class="btn btn-lg btn-outline-white btn-pill align-self-center mb-2">مستندات فارسی لاراول</a>
                <a href="/terminologies" class="btn btn-lg btn-primary btn-pill align-self-center mb-2">اصطلاحات فنی</a>
            </div>
        </div>
    </div>
    <!-- / Inner Wrapper -->
</div>
<?= Alert::widget() ?>
<?= $content ?>
<?= $this->render('//layouts/footer') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>