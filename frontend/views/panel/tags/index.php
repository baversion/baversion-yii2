<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TagsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'تگ‌ها';
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<p>
    <?= Html::a('افزودن تگ', ['create'], ['class' => 'btn btn-outline-light btn-sm']) ?>
</p>
z
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'tag_name',
        'slug',
        [
            'attribute' => 'created_at',
            'value' => function ($dataProvider) {
                return Yii::$app->jdate->date('o/n/d', $dataProvider->created_at);
            }
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($dataProvider) {
                return Yii::$app->jdate->date('o/n/d', $dataProvider->updated_at);
            }
        ],
        [
            'attribute' => 'tag_status',
            'value' => function ($dataProvider) {
                $status = [
                    0 => '<span class="badge mr-3 badge-pill badge-danger" >حذف شده</span>',
                    1 => '<span class="badge mr-3 badge-pill badge-default" >پیش‌نویس</span>',
                    2 => '<span class="badge mr-3 badge-pill badge-info" >در صف بررسی</span>',
                    3 => '<span class="badge mr-3 badge-pill badge-warning" >جهت بازبینی مجدد</span>',
                    5 => '<span class="badge mr-3 badge-pill badge-info" >برنامه‌ریزی شده</span>',
                    6 => '<span class="badge mr-3 badge-pill badge-success" >منتشر شده</span>',
                ];
                return $status[$dataProvider->tag_status];
            },
            'format' => 'html',
        ],
        'view_count',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'عملیات',
            'template' => '{update} {view}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="fas fa-eye"></span>', $url, [
                        'title' => Yii::t('app', 'مشاهده تگ'),
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a('<span class="fas fa-pencil-alt"></span>', $url, [
                        'title' => Yii::t('app', 'ویرایش تگ'),
                    ]);
                },
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    $url = 'tags/view/' . $model->id;
                    return $url;
                }
                if ($action === 'update') {
                    $url = 'tags/update/' . $model->id;
                    return $url;
                }
            }
        ],
    ],
]); ?>
<?php Pjax::end(); ?>
