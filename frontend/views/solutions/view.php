<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Solutions */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Solutions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solutions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'author_id',
            'solution_title',
            'slug',
            'problem:ntext',
            'solution:ntext',
            'cover_image',
            'created_at',
            'updated_at',
            'published_at',
            'solution_status',
        ],
    ]) ?>

</div>
