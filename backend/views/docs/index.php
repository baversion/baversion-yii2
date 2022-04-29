<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\DocsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'داکیومنت‌ها';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>
<?php //$this->render('_search', ['model' => $searchModel]); ?>

<p>
    <?= Html::a('افزودن داکیومنت', ['create'], ['class' => 'btn btn-default']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'doc_title',
            'value' => function ($dataProvider) {
                return '<img src="' . $dataProvider->cover_image . '" class="micro-thumbnail"> ' . $dataProvider->doc_title;
            },
            'format' => 'html',
        ],
        'doc_title',
        'subtitle',
        'version',
        'doc_version',
        [
            'attribute' => 'created_at',
            'value' => function ($dataProvider) {
                return Yii::$app->jdate->date('j F Y', $dataProvider->created_at);
            },
        ],
        [
            'label' => 'برچسب‌ها',
            'value' => function ($dataProvider) {
                $status = [
                    0 => '<span class="label label-danger" >حذف شده</span>',
                    1 => '<span class="label label-default" >پیش‌نویس</span>',
                    2 => '<span class="label label-info" >در صف بررسی</span>',
                    3 => '<span class="label label-warning" >جهت بازبینی مجدد</span>',
                    5 => '<span class="label label-info" >برنامه‌ریزی شده</span>',
                    6 => '<span class="label label-success" >منتشر شده</span>',
                ];
                return ($status[$dataProvider->doc_status]) .
                    ($dataProvider->completed ? ' <span class="label label-success">مستندات کامل</span>' : '') .
                    ($dataProvider->deprecated ? ' <span class="label label-danger">مستندات منقضی</span>' : '');
            },
            'format' => 'html',
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
<?php Pjax::end(); ?>
