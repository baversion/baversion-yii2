<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Docs */

$this->title = 'ویرایش داکیومنت ' . $model->doc_title;
$this->params['breadcrumbs'][] = ['label' => 'داکیومنت‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->doc_title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

