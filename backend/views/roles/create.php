<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\authItem */

$this->title = 'افزودن نقش کاربری';
$this->params['breadcrumbs'][] = ['label' => 'نقش‌های کاربری', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
    'permissions' => $permissions,
]) ?>
