<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DocsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="docs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'author_id') ?>

    <?= $form->field($model, 'doc_title') ?>

    <?= $form->field($model, 'subtitle') ?>

    <?= $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'doc_version') ?>

    <?php // echo $form->field($model, 'cover_image') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'published_at') ?>

    <?php // echo $form->field($model, 'doc_status') ?>

    <?php // echo $form->field($model, 'completed') ?>

    <?php // echo $form->field($model, 'deprecated') ?>

    <?php // echo $form->field($model, 'lock_to') ?>

    <?php // echo $form->field($model, 'meta_keywords') ?>

    <?php // echo $form->field($model, 'meta_description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
