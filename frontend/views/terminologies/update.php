<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Terminology */

$this->title = 'ویرایش اصطلاح: ' . $model->slug;
$this->params['breadcrumbs'][] = ['label' => 'Terminologies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->slug, 'url' => ['term', 'slug' => $model->slug]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="terminology-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
