<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $pagination \yii\data\Pagination */
/* @var $posts array|\common\models\Articles[] */

$this->title = 'وبلاگ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <h1 class="font-italic"><?= Html::encode($this->title) ?></h1>
    <p class="pb-3 mb-4 border-bottom">اخبار دنیای برنامه‌نویسی، آموزش‌های برنامه‌نویسی و نحوه استفاده از ابزار را در وبلاگ باورژن می‌توانید دنبال کنید.</p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php foreach ($posts as $post): ?>
        <article class="blog-post pb-3 mb-4 border-bottom">
            <h2 class="blog-post-title"><a href="<?= Url::to(['blog/post/' . $post->slug]) ?>"><?= $post->article_title ?></a></h2>
            <p class="blog-post-meta">
                <span class="fas fa-clock"></span> <span class="post-date updated"><?= Yii::$app->jdate->date('l j F Y ساعت H:i', $post->published_at) ?></span>
                <span class="fas fa-user"></span> <span class="vcard author author_name"><span class="fn">مجتبی پاکزاد</span></span>
                <span class="fas fa-time"></span>
            </p>

            <?php if ($post->cover_image !== null): ?>
                <img src="<?= $post->cover_image ?>" class="img-fluid mb-4 mx-auto d-block" alt="<?= $post->article_title ?>">
            <?php endif; ?>
            <p><?= $post->excerpt ?></p>
        </article>
    <?php endforeach; ?>

    <nav aria-label="Page navigation">
        <?php
        echo LinkPager::widget([
            'pagination' => $pagination,
            'options' => [
                'class' => 'pagination'
            ],
            'linkContainerOptions' => [
                'class' => 'page-item'
            ],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link', 'href' => '#', 'tabindex' => '-1']
        ]);
        ?>
    </nav>

    <?php Pjax::end(); ?>
</div>
