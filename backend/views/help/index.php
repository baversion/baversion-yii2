<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\HelpTopicsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'تاپیک‌های راهنما';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<p>
    <?= Html::a('افزودن تاپیک', ['create'], ['class' => 'btn btn-default']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'topic_title',
        'slug',
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

        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'عملیات',
            'template' => '{topic} {add} {update} {delete}',
            'buttons' => [
                'topic' => function ($url, $model) {
                    return Html::a('<span class="fa fa-eye"></span>', $url, [
                        'title' => 'مشاهده تاپیک',
                    ]);
                },
                'add' => function ($url, $model) {
                    return Html::a('<span class="fa fa-plus"></span>', $url, [
                        'title' => 'افزودن پست به این تاپیک',
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a('<span class="fa fa-pencil-alt"></span>', $url, [
                        'title' => 'ویرایش تاپیک',
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="fa fa-trash"></span>', $url, [
                        'title' => 'حذف تاپیک',
                    ]);
                }

            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'topic') {
                    $url ='help/topic/'.$model->id;
                    return $url;
                }
                if ($action === 'add') {
                    $url ='help/add/'.$model->id;
                    return $url;
                }
                if ($action === 'update') {
                    $url ='help/update/'.$model->id;
                    return $url;
                }
                if ($action === 'delete') {
                    $url ='help/delete/'.$model->id;
                    return $url;
                }

            }
        ],
    ],
]); ?>
<?php Pjax::end(); ?>
