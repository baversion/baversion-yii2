<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<div class="p-3">
    <h4 class="font-italic">مدیریت</h4>
    <ul class="nav flex-column pl-1 mt-4">
        <li class="nav-item<?=Yii::$app->controller->id == 'panel/dashboard' && Yii::$app->controller->action->id != 'profile' ? ' active' : '' ?>"><a href="<?= Url::to(['panel/dashboard']) ?>" class="nav-link"><span class="fas fa-tachometer-alt"></span> داشبورد</a></li>
        <?php if (\Yii::$app->user->can('createContent')): ?>
            <li class="nav-item<?=Yii::$app->controller->id == 'panel/docs' ? ' active' : '' ?>"><a href="#" data-toggle="collapse" data-target="#docs-aside" data-parent="#nav-sidebar" class="collapsed nav-link"><span class="fas fa-book"></span> داکیومنت▾</a>
                <ul class="list-unstyled flex-column pl-3 collapse" id="docs-aside" aria-expanded="false">
                    <li class="nav-item"><a href="<?= Url::to(['panel/docs']) ?>" class="nav-link"><span class="fa fa-circle-o"></span> داکیومنت‌ها</a></li>
                    <?php if (\Yii::$app->user->can('manageContent')): ?>
                        <li class="nav-item"><a href="<?= Url::to(['panel/docs/pending']) ?>" class="nav-link"><span class="fa fa-circle-o"></span> بررسی جهت انتشار</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <li class="nav-item<?=Yii::$app->controller->id == 'panel/blog' ? ' active' : '' ?>"><a href="#" data-toggle="collapse" data-target="#blog-aside" data-parent="#nav-sidebar" class="collapsed nav-link"><span class="fas fa-pencil-alt"></span> وبلاگ▾</a>
                <ul class="list-unstyled flex-column pl-3 collapse" id="blog-aside" aria-expanded="false">
                    <?php if (\Yii::$app->user->can('manageContent')): ?>
                        <li class="nav-item"><a href="<?= Url::to(['panel/blog']) ?>" class="nav-link"><span class="fa fa-circle-o"></span> همه</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="<?= Url::to(['panel/blog/create']) ?>" class="nav-link"><span class="fa fa-circle-o"></span> افزودن پست</a></li>
                    <li class="nav-item"><a href="<?= Url::to(['panel/blog/my']) ?>" class="nav-link"><span class="fa fa-circle-o"></span> پست‌های شما</a></li>
                    <?php if (\Yii::$app->user->can('manageContent')): ?>
                        <li class="nav-item"><a href="<?= Url::to(['panel/blog/pending']) ?>" class="nav-link"><span class="fa fa-circle-o"></span> بررسی جهت انتشار</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="<?= Url::to(['panel/blog/draft']) ?>" class="nav-link"><span class="fa fa-circle-o"></span> پیش‌نویس‌ها</a></li>
                </ul>
            </li>
            <li class="nav-item<?=Yii::$app->controller->id == 'panel/tags' ? ' active' : '' ?>"><a href="#" data-toggle="collapse" data-target="#tags-aside" data-parent="#nav-sidebar" class="collapsed nav-link"><span class="fas fa-tags"></span> تگ‌ها▾</a>
                <ul class="list-unstyled flex-column pl-3 collapse" id="tags-aside" aria-expanded="false">
                    <?php if (\Yii::$app->user->can('manageContent')): ?>
                        <li class="nav-item"><a href="<?= Url::to(['panel/tags']) ?>" class="nav-link"><span class="fa fa-circle-o"></span> همه</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="<?= Url::to(['panel/tags/create']) ?>" class="nav-link"><span class="fa fa-circle-o"></span> افزودن</a></li>
                </ul>
            </li>
            <li class="nav-item<?=Yii::$app->controller->id == 'panel/images' && Yii::$app->controller->action->id == 'upload' ? ' active' : '' ?>"><a href="<?= Url::to(['panel/images/upload']) ?>" class="nav-link"><span class="fas fa-upload"></span> آپلود عکس</a></li>
        <?php endif; ?>
        <li class="nav-item<?=Yii::$app->controller->id == 'panel/dashboard' && Yii::$app->controller->action->id == 'profile' ? ' active' : '' ?>"><a href="<?= Url::to(['panel/profile']) ?>" class="nav-link"><span class="fas fa-user"></span> تغییر مشخصات کاربری</a></li>
    </ul>
</div>