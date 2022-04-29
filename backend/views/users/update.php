<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Users */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => 'کاربران', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->display_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if ($model->image !== null): ?>
    <img src="<?= Yii::$app->urlManagerF->createUrl(['images/' . ($model->image != null ? $model->image : 'default.png')]) ?>" alt="<?= $model->display_name ?>" class="thumbnail mini-thumbnail">
<?php endif; ?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'display_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?php if ($model->image !== null): ?>
    <?= $form->field($model, 'image')->checkbox(array('label'=>'حذف عکس'))->label(''); ?>
<?php endif; ?>

<?= Html::dropDownList('role', $userRole, $listRoles, ['class' => 'form-group']) ?>

    <div class="form-group">
        <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>