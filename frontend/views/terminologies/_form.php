<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Terminology */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="terminology-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'term_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'initial')->dropDownList(array_combine(range('a', 'z'), range('A', 'Z')), ['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'term_status')->dropDownList([
            1 => 'پیش‌نویس',
            4 => 'بازبینی',
            6 => 'انتشار',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
