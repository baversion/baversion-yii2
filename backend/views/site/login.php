<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'ورود';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>برای ورود فرم زیر را پر کنید:</p>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'class' => 'ltr form-control'])->label('نام کاربری') ?>

                <?= $form->field($model, 'password')->passwordInput(['class' => 'ltr form-control'])->label('پسورد') ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('مرا به خاطر داشته باش') ?>

                <div class="form-group">
                    <?= Html::submitButton('ورود', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
