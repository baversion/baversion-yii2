<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HelpTopics */

$this->title = 'ساخت تاپیک راهنما';
$this->params['breadcrumbs'][] = ['label' => 'تاپیک‌های راهنما', 'url' => ['help/']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
