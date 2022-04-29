<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'کاربران';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'label' => 'نام',
            'value' => function ($model) {
                return '<img src="' . Yii::$app->urlManagerF->createUrl(['images/' . ($model->image != null ? $model->image : 'default.png')]) . '" alt="' . $model->display_name . '" class="micro-thumbnail"> ' . $model->display_name;
            },
            'format' => 'html',
        ],
        'username',
        'email:email',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return Yii::$app->jdate->date('l j F Y ساعت H:i', $model->created_at);
            }
        ],
        [
            'attribute' => 'last_login',
            'value' => function ($model) {
                return Yii::$app->jdate->date('l j F Y ساعت H:i', $model->last_login);
            }
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
<?php Pjax::end(); ?>
