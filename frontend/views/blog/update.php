<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Articles */

$this->title = $model->article_title;
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = ['label' => 'وبلاگ', 'url' => ['panel/blog']];
$this->params['breadcrumbs'][] = $model->article_title;
$this->params['breadcrumbs'][] = 'ویرایش';
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
