<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\authItem */

$this->title = 'ویرایش پرمیشن: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'پرمیشن‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

