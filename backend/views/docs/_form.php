<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Docs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-9 col-md-9">
        <?= $form->field($model, 'doc_title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'cover_image')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>
    </div>

    <div class="col-lg-3 col-md-3">
        <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'doc_version')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'doc_status')->textInput() ?>

        <?= $form->field($model, 'lock_to')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'author_id')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'completed')->checkbox() ?>

        <?= $form->field($model, 'deprecated')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
