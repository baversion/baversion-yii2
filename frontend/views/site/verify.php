<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'تایید ایمیل';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
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
    لطفا برای تایید ایمیل خود از فرم زیر استفاده کنید.
<br>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'verify-form', 'method' => 'get']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'name' => 'email'])->label('ایمیل') ?>

                <?= $form->field($model, 'token')->textInput(['autofocus' => true, 'name' => 'token'])->label('توکن') ?>

                <div class="form-group">
                    <?= Html::submitButton('تایید', ['class' => 'btn btn-outline-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
