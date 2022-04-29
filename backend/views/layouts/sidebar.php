<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\url;

?>
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li<?php echo (Yii::$app->controller->id === 'site' ? ' class="active"' : ''); ?>>
                    <a href="<?=Url::to(['site/index'], true)?>"><i class="fas fa-tachometer-alt"></i> <span>داشبورد</span></a>
                </li>
                <li class="treeview<?php echo (Yii::$app->controller->id === 'docs' ? ' active' : ''); ?>">
                    <a href="#">
                        <i class="fas fa-book"></i>
                        <span>داکیومنت‌ها</span>
                        <span class="pull-left-container">
                          <i class="fas fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=Url::to(['docs/'], true)?>"><i class="far fa-circle fa-sm"></i> داکیومنت‌ها</a></li>
                        <li><a href="<?=Url::to(['docs/create'], true)?>"><i class="far fa-circle fa-sm"></i> افزودن داکیومنت</a></li>
                    </ul>
                </li>
                <li class="treeview<?php echo (Yii::$app->controller->id === 'blog' ? ' active' : ''); ?>">
                    <a href="#">
                        <i class="fas fa-pencil-alt"></i>
                        <span>وبلاگ</span>
                        <span class="pull-left-container">
                          <i class="fas fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=Url::to(['blog/'], true)?>"><i class="far fa-circle fa-sm"></i> پست‌ها</a></li>
                        <li><a href="<?=Url::to(['blog/create'], true)?>"><i class="far fa-circle fa-sm"></i> افزودن پست</a></li>
                    </ul>
                </li>
                <li class="treeview<?php echo (Yii::$app->controller->id === 'terminologies' ? ' active' : ''); ?>">
                    <a href="#">
                        <i class="fas fa-language"></i>
                        <span>اصطلاحات فنی</span>
                        <span class="pull-left-container">
                          <i class="fas fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=Url::to(['docs/'], true)?>"><i class="far fa-circle fa-sm"></i> اصطلاحات</a></li>
                        <li><a href="<?=Url::to(['docs/create'], true)?>"><i class="far fa-circle fa-sm"></i> افزودن اصطلاح</a></li>
                    </ul>
                </li>
                <li class="treeview<?php echo (Yii::$app->controller->id === 'cources' ? ' active' : ''); ?>">
                    <a href="#">
                        <i class="fas fa-graduation-cap"></i>
                        <span>دوره‌ها</span>
                        <span class="pull-left-container">
                          <i class="fas fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=Url::to(['docs/'], true)?>"><i class="far fa-circle fa-sm"></i> دوره‌ها</a></li>
                        <li><a href="<?=Url::to(['docs/'], true)?>"><i class="far fa-circle fa-sm"></i> مدرس‌ها</a></li>
                        <li><a href="<?=Url::to(['docs/'], true)?>"><i class="far fa-circle fa-sm"></i> شرکت‌کننده‌ها</a></li>
                        <li><a href="<?=Url::to(['docs/create'], true)?>"><i class="far fa-circle fa-sm"></i> افزودن دوره</a></li>
                    </ul>
                </li>
                <li class="treeview<?php echo (Yii::$app->controller->id === 'help' ? ' active' : ''); ?>">
                    <a href="#">
                        <i class="fas fa-question"></i>
                        <span>راهنما</span>
                        <span class="pull-left-container">
                          <i class="fas fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=Url::to(['help/'], true)?>"><i class="far fa-circle fa-sm"></i> تاپیک‌ها</a></li>
                        <li><a href="<?=Url::to(['help/create'], true)?>"><i class="far fa-circle fa-sm"></i> افزودن تاپیک</a></li>
                    </ul>
                </li>
                <li class="treeview<?php echo (Yii::$app->controller->id === 'users' ? ' active' : ''); ?>">
                    <a href="#">
                        <i class="fas fa-users"></i>
                        <span>کاربران</span>
                        <span class="pull-left-container">
                          <i class="fas fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=Url::to(['users/'], true)?>"><i class="far fa-circle fa-sm"></i> کاربران</a></li>
                        <li><a href="<?=Url::to(['users/roles'], true)?>"><i class="far fa-circle fa-sm"></i> افزودن کاربر</a></li>
                    </ul>
                </li>
                <li class="treeview<?php echo (Yii::$app->controller->id === 'roles' ? ' active' : ''); ?>">
                    <a href="#">
                        <i class="fas fa-user-shield"></i>
                        <span>نقش‌های کاربری</span>
                        <span class="pull-left-container">
                          <i class="fas fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=Url::to(['roles/'], true)?>"><i class="far fa-circle fa-sm"></i> نقش‌ها</a></li>
                        <li><a href="<?=Url::to(['roles/create'], true)?>"><i class="far fa-circle fa-sm"></i> افزودن نقش</a></li>
                    </ul>
                </li>
                <li class="treeview<?php echo (Yii::$app->controller->id === 'permissions' ? ' active' : ''); ?>">
                    <a href="#">
                        <i class="fas fa-key"></i>
                        <span>پرمیشن‌ها</span>
                        <span class="pull-left-container">
                          <i class="fas fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=Url::to(['permissions/'], true)?>"><i class="far fa-circle fa-sm"></i> پرمیشن‌ها</a></li>
                        <li><a href="<?=Url::to(['permissions/create'], true)?>"><i class="far fa-circle fa-sm"></i> افزودن پرمیشن</a></li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
