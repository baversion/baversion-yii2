<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Articles */
/* @var $tags common\models\Tags */
\dominus77\highlight\Plugin::$options = [
    'theme' => 'github',// Styles
    'lineNumbers' => true,    // Show line numbers
    'singleLine' => true,     // Show number if one line
];
\dominus77\highlight\Plugin::register($this);

$this->title = $model->article_title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="blog-post pb-3 mb-4">
    <h1><?= Html::encode($this->title) ?></h1>
    <p class="blog-post-meta">
        <span class="fas fa-user"></span> <span class="vcard author author_name"><span class="fn">مجتبی پاکزاد</span></span>
        <span class="fas fa-clock"></span> <span class="post-date updated"><?= Yii::$app->jdate->date('l j F Y ساعت H:i', $model->published_at) ?></span>
        <span class="fas fa-time"></span>
    </p>

    <?= $model->content ?>

    <div id="tags">
        <div class="header">
            <span class="fas fa-tags"></span> تگ‌ها
        </div>
        <?php foreach ($tags as $tag): ?>
            <a href="<?= Url::to(['tag/' . $tag->tag->slug]) ?>" rel="tag"><?= $tag->tag->tag_name ?></a>
        <?php endforeach; ?>
    </div>

    <?php if($sources != null): ?>
        <div id="src">
            <div class="header">
                <span class="fas fa-globe"></span> منابع
            </div>
            <?php foreach ($sources as $src): ?>
                <?= $src->meta_value ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</article>
