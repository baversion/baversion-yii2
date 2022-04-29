<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\authItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'پرمیشن‌ها';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<p>
    <?= Html::a('افزودن پرمیشن', ['create'], ['class' => 'btn btn-default']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'name',
        'description:ntext',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return Yii::$app->jdate->date('j F Y ساعت H:i', $model->created_at);
            }
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                return Yii::$app->jdate->date('j F Y ساعت H:i', $model->updated_at);
            }
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
<?php Pjax::end(); ?>
