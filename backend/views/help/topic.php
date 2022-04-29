<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $topic common\models\HelpTopics */

$this->title = $topic->topic_title;
$this->params['breadcrumbs'][] = ['label' => 'تاپیک‌های راهنما', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-topics-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('ویرایش', ['update', 'id' => $topic->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('حذف', ['delete', 'id' => $topic->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'این راهنما با کلیه زیر مجموعه‌ها حذف خواهد شد، آیا مطمئنید؟',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $topic,
        'attributes' => [
            'topic_title',
            'slug',
            [
                'attribute' => 'created_at',
                'value' => function ($topic) {
                    return Yii::$app->jdate->date('l j F Y ساعت H:i', $topic->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($topic) {
                    return Yii::$app->jdate->date('l j F Y ساعت H:i', $topic->updated_at);
                }
            ],
        ],
    ]) ?>

    <h3>پست‌ها</h3>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-condensed table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان پست</th>
                    <th>چکیده</th>
                    <th>تاریخ ایجاد</th>
                    <th>تاریخ آپدیت</th>
                    <th>وضعیت</th>
                </tr>
            </thead>
            <tbody>
            <?php $rowNumber = 0; ?>
            <?php foreach ($topic->helpPosts as $post): ?>
                <tr>
                    <td><?= ++$rowNumber; ?></td>
                    <td><a href="#"><?= $post->post_title ?></a></td>
                    <td><?= StringHelper::byteSubstr($post->content, 0, 80)?> ...</td>
                    <td><?= Yii::$app->jdate->date('l j F Y ساعت H:i', $post->created_at) ?></td>
                    <td><?= Yii::$app->jdate->date('l j F Y ساعت H:i', $post->updated_at) ?></td>
                    <td>
                    <?php
                    $status = [
                        0 => 'حذف شده',
                        1 => 'پیش‌نویس',
                        6 => 'منتشر شده',
                    ];
                    echo $status[$post->help_status];
                    ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if ($rowNumber == 0): ?>
                <tr>
                    <td colspan="6">مطلبی در این تاپیک منتشر نشده است.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
