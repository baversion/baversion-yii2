<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HelpTopics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="help-topics-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'topic_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug', [
        'inputOptions' => [
            'class' => 'form-control',
            'placeholder' => 'اسلاگ',
            'dir' => 'auto'
        ],
        'template' => '
            <label for="basic-url">{label}</label>
            <div class="input-group">
              {input}
              <span class="input-group-addon ltr">http://baversion.com/help/</span>
            </div>',
    ])->textInput(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('ذخیره', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
