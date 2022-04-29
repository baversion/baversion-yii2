<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\url;

?>
    <header class="main-header">
        <!-- Logo -->
        <a href="index.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>B</b>V</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>با</b>ورژن</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <?php
                    if (!Yii::$app->user->isGuest) {
                        ?>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= Yii::$app->urlManagerF->createUrl(['images/' . (Yii::$app->user->identity->image != null ? Yii::$app->user->identity->image : 'default.png')]) ?>" class="user-image"
                                     alt="آواتار">
                                <span class="hidden-xs"><?= Yii::$app->user->identity->display_name ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?= Yii::$app->urlManagerF->createUrl(['images/' . (Yii::$app->user->identity->image != null ? Yii::$app->user->identity->image : 'default.png')]) ?>" class="img-circle" alt="آواتار <?= Yii::$app->user->identity->username ?>">
                                    <p>
                                        <?= (Yii::$app->user->identity->username != null ? Yii::$app->user->identity->username : 'فاقد نام کاربری') ?>
                                        <small>عضویت از <?= Yii::$app->jdate->date('d F Y', Yii::$app->user->identity->created_at) ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="row">
                                        <div class="col-xs-6 text-center">
                                            <a href="<?= Yii::$app->urlManagerF->createUrl(['/']) ?>" target="_blank">باورژن</a>
                                        </div>
                                        <div class="col-xs-6 text-center">
                                            <a href="<?=Url::to(['admin/'], true)?>">پنل مدیریت</a>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?=Url::to(['user/view', 'id' => Yii::$app->user->identity->id], true)?>" class="btn btn-default btn-flat">پروفایل</a>
                                    </div>
                                    <div class="pull-right">
                                        <?=Html::beginForm(['/logout'], 'post')
                                        . Html::submitButton(
                                            'خروج',
                                            ['class' => 'btn btn-default btn-flat']
                                        )
                                        . Html::endForm()?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>
