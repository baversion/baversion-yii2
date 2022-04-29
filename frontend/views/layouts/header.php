<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
    <img src="/images/shards-logo-white.svg" class="mr-2" alt="باورژن - آموزش برنامه‌نویسی">
    باورژن
</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
        <li class="nav-item<?=Yii::$app->controller->id == 'docs' ? ' active' : '' ?>">
            <a class="nav-link" href="/docs">داکیومنت<?=Yii::$app->controller->id == 'docs' ? ' <span class="sr-only">(current)</span>' : '' ?></a>
        </li>
        <li class="nav-item<?=Yii::$app->controller->id == 'terminologies' ? ' active' : '' ?>">
            <a class="nav-link" href="/terminologies">اصطلاحات فنی<?=Yii::$app->controller->id == 'terminologies' ? ' <span class="sr-only">(current)</span>' : '' ?></a>
        </li>
        <?php /*
        <li class="nav-item<?=Yii::$app->controller->id == 'stack' ? ' active' : '' ?>">
            <a class="nav-link" href="/stack">استک<?=Yii::$app->controller->id == 'stack' ? ' <span class="sr-only">(current)</span>' : '' ?></a>
        </li>
        <li class="nav-item<?=Yii::$app->controller->id == 'references' ? ' active' : '' ?>">
            <a class="nav-link" href="/references">رفرنس<?=Yii::$app->controller->id == 'references' ? ' <span class="sr-only">(current)</span>' : '' ?></a>
        </li>
        */ ?>
        <li class="nav-item<?=Yii::$app->controller->id == 'blog' ? ' active' : '' ?>">
            <a class="nav-link" href="/blog">وبلاگ<?=Yii::$app->controller->id == 'blog' ? ' <span class="sr-only">(current)</span>' : '' ?></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <?php if (!Yii::$app->user->isGuest): ?>
            <?php if (Yii::$app->user->can('managePost')): ?>
            <li class="nav-item"><a href="#" class="nav-link"><span class="fas fa-search"></span></a></li>
            <li class="nav-item"><a href="/help" class="nav-link"><span class="fas fa-question"></span></a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-bell"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            <?php endif; ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="http://baversion.com/images/<?= Yii::$app->user->identity->image ?>" class="user-menu">
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?= Url::to(['/settings']) ?>"><span class="fas fa-cog"></span> تنظیمات حساب کاربری</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= Url::to(['/docs']) ?>"><span class="fas fa-book"></span> داکیومنت</a>
                    <a class="dropdown-item" href="<?= Url::to(['/terminology']) ?>"><span class="fas fa-language"></span> اصطلاحات فنی</a>
                    <a class="dropdown-item" href="<?= Url::to(['/references']) ?>"><span class="fas fa-map-signs"></span> رفرنس</a>
                    <a class="dropdown-item" href="<?= Url::to(['/tag']) ?>"><span class="fas fa-tags"></span> تگ</a>
                    <a class="dropdown-item" href="<?= Url::to(['/blog']) ?>"><span class="fas fa-pencil-alt"></span> وبلاگ</a>
                    <a class="dropdown-item" href="<?= Url::to(['/my']) ?>"><span class="fas fa-archive"></span> پست‌های من</a>
                    <div class="dropdown-divider"></div>
                    <?= Html::a('خروج', ['site/logout'], ['data' => ['method' => 'post'], 'class' => 'dropdown-item']) ?>
                </div>
            </li>
        <?php else: ?>
            <?php /*
            <li class="nav-item nav-btn">
                <a href="/signup" class="btn btn-outline-white navbar-btn">ثبت‌نام</a>
            </li>
            <li class="nav-item">
                <a href="/login" class="btn btn-primary navbar-btn">ورود</a>
            </li> */ ?>
        <?php endif; ?>
    </ul>
</div>