<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HelpTopics */

$this->title = 'آپدیت تاپیک: ' . $model->topic_title;
$this->params['breadcrumbs'][] = ['label' => 'تاپیک‌های راهنما', 'url' => ['help/']];
$this->params['breadcrumbs'][] = ['label' => $model->topic_title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
