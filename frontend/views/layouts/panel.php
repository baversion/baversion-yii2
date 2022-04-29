<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
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
    <title>باورژن - پنل - <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <?= $this->render('//layouts/header') ?>
</nav>
<div id="panel" class="container-fluid">
    <div class="row panel">
        <?= $this->render('//layouts/panel-sidebar') ?>
        <div class="container">
            <?= Breadcrumbs::widget([
                'itemTemplate' => "<li><i>{link}</i></li>\n",
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]); ?>
            <h1><?= Html::encode($this->title) ?></h1>

            <?php if (Yii::$app->session->hasFlash('info')): ?>
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fa fa-info"></span> توجه!</h4>
                    <?= Yii::$app->session->getFlash('info') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('danger')): ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fa fa-times-circle"></span> اخطار!</h4>
                    <?= Yii::$app->session->getFlash('danger') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('warning')): ?>
                <div class="alert alert-warning alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fa fa-warning"></span> هشدار!</h4>
                    <?= Yii::$app->session->getFlash('warning') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fa fa-check"></span> توجه!</h4>
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>
            <?= $content ?>
        </div>
    </div>
</div>
<?= $this->render('//layouts/footer') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
