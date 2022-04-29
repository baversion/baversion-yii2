<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Users */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => 'کاربران', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('بن', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'کاربر مورد نظر دیگر به سایت دسترسی نخواهد داشت، آیا مطمئن هستید؟',
            'method' => 'post',
        ],
    ]) ?>
</p>

<img src="<?= Yii::$app->urlManagerF->createUrl(['images/' . ($model->image != null ? $model->image : 'default.png')]) ?>" alt="<?= $model->display_name ?>" class="thumbnail mini-thumbnail">

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'display_name',
        'username',
        'email:email',
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
            'label' => 'نقش کاربری',
            'value' => function ($model) {
                foreach(\Yii::$app->authManager->getRolesByUser($model->id) as $item)
                {
                    $role = $item->name;
                }
                return $role;
            }
        ],
    ],
]) ?>