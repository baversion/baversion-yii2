<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tags */

$this->title = $model->tag_name;
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = ['label' => 'تگ‌ها', 'url' => ['panel/tags']];
$this->params['breadcrumbs'][] = ['label' => $model->tag_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
