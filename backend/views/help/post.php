<?php

use yii\grid\GridView;
use yii\helpers\Html;
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

    <?php foreach ($topic->helpPosts as $posts): ?>

    <?php endforeach; ?>

</div>
