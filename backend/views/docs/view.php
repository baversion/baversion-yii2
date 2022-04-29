<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Docs */

$this->title = $model->doc_title;
$this->params['breadcrumbs'][] = ['label' => 'داکیومنت‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docs-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('حذف', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'با حذف این داکیومنت، کلیه پست‌های آن نیز حذف خواهند شد، آیا مطمئنید؟',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'author_id',
            'doc_title',
            'subtitle',
            'slug',
            'content:ntext',
            'version',
            'doc_version',
            'cover_image',
            'created_at',
            'updated_at',
            'published_at',
            'doc_status',
            'completed',
            'deprecated',
            'lock_to',
            'meta_keywords',
            'meta_description:ntext',
        ],
    ]) ?>

</div>
