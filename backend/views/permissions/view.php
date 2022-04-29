<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\authItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'پرمیشن‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('ویرایش', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('حذف', ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'با حذف پرمیشن‌های ست شده ممکن است دسترسی به برخی صفحات از بین برود، آیا به دقت بررسی کرده‌اید؟',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
            'rule_name',
            'data',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->jdate->date('l j F Y ساعت H:i', $model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return Yii::$app->jdate->date('l j F Y ساعت H:i', $model->updated_at);
                }
            ],
        ],
    ]) ?>

</div>
