<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Tags */
/* @var $articles common\models\Articles */

$this->title = $model->tag_name;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $model->content ?>

    <hr>

    <h3>از وبلاگ</h3>
    <ul>
    <?php foreach ($articles as $post): ?>
        <li><a href="<?= Url::to(['/blog/post/' . $post->article->slug]) ?>"><?= $post->article->article_title ?></a></li>
    <?php endforeach; ?>
    </ul>
</div>
