<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Terminology */
?>
<div class="terminology-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'author_id',
            'term_title',
            'slug',
            'content:ntext',
            'initial',
            'created_at',
            'updated_at',
            'published_at',
            'last_editor',
            'lock_to',
            'view_count',
            'meta_keywords',
            'meta_description:ntext',
            'term_status',
        ],
    ]) ?>

</div>
