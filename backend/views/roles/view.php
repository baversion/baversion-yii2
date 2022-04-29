<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model backend\models\authItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'نقش‌های کاربری', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('ویرایش', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('حذف', ['delete', 'id' => $model->name], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'با حذف نقش‌های کاربری، کاربران بدون نقش خواهند ماند و نقشها باید مجددا تنظیم شوند، آیا به دقت بررسی کرده‌اید؟',
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

<h2>پرمیشن‌ها</h2>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>نام پرمیشن</th>
                <th>توضیحات</th>
            </tr>
        </thead>
        <tbody>
        <?php $permissionCounter = 0; ?>
        <?php foreach ($permissions as $permission): ?>
            <tr>
                <td><?= ++$permissionCounter ?></td>
                <td><?= $permission->name ?></td>
                <td><?= $permission->description ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if($permissionCounter === 0): ?>
            <tr>
                <td colspan="3">این نقش کاربری فاقد هرگونه پرمیشنی است.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
