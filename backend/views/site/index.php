<?php

/* @var $this yii\web\View */

use common\widgets\Alert;
use yii\helpers\Url;

$this->title = 'داشبورد';
?>
<div class="site-index">

    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>0</h3>

                    <p>درآمد</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-alt"></i>
                </div>
                <a href="#" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>0</h3>

                    <p>تعداد دوره‌ها</p>
                </div>
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <a href="<?=Url::to(['ad/index'], true)?>" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3><?= $usersCount ?></h3>

                    <p>تعداد کاربران</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="<?=Url::to(['users/index'], true)?>" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?= $docsCount ?></h3>

                    <p>تعداد داکیومنت‌ها</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="#" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- .row -->
    <div class="row">
        <!-- .col -->
        <div class="col-md-3">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">آخرین پرداخت‌ها</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    The body of the box
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <!-- .col -->
        <div class="col-md-3">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">آخرین دوره‌‌ها</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    The body of the box
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <!-- .col -->
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">آخرین کاربران</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul>
                    <?php foreach ($latestRegisteredUsers as $user): ?>
                        <li>
                            <a href="<?=Url::to(['users/view', 'id' => $user['id']], true)?>"><?= $user['display_name'] ?></a>
                            <span class="pull-left-container">
                              <small class="label pull-right bg-blue"><?= Yii::$app->jdate->date('d F Y', $user['created_at']) ?></small>
                            </span>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="<?=Url::to(['users/'], true)?>">همه کاربران</a>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <!-- .col -->
        <div class="col-md-3">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">آخرین پست‌های داکیومنت‌‌ها</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul>
                        <?php foreach ($latestDocPosts as $post): ?>
                            <li>
                                <a href="<?=Url::to(['docs/preview/' . $post['id']], true)?>"><?= $post['post_title'] ?></a>
                                <span class="pull-left-container">
                              <small class="label pull-right bg-blue"><?= Yii::$app->jdate->date('d F Y', $post['published_at']) ?></small>
                            </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="<?=Url::to(['docs/'], true)?>">مشاهده داکیومنت‌‌ها</a>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
