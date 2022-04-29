<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $doc common\models\Docs */
/* @var $post common\models\DocPosts */
/* @var $posts common\models\DocPosts */
\dominus77\highlight\Plugin::$options = [
    'theme' => 'github',// Styles
    'lineNumbers' => true,    // Show line numbers
    'singleLine' => true,     // Show number if one line
];
\dominus77\highlight\Plugin::register($this);

$this->title = $post->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="blog-post pb-3 mb-4">
    <h1><?= Html::encode($this->title) ?></h1>
    <head class="blog-post-meta">
        <span class="fas fa-user"></span> <span class="vcard author author_name"><span class="fn"><?= $doc->author->display_name ?></span></span>
        <span class="fas fa-clock"></span> <span class="post-date updated"><?= Yii::$app->jdate->date('l j F Y ساعت H:i', $post->published_at) ?></span>
        <span class="fas fa-time"></span>
        <span class="fas fa-book"></span>
        <span><?= $doc->doc_title ?></span>
        <span class="badge mr-1 badge-primary"><span class="fas fa-history"></span> <?= $doc->version ?></span>
        <?php if ($doc->completed): ?>
            <span class="badge mr-1 badge-success"><span class="fas fa-check"></span> کامل شده</span>
        <?php else: ?>
            <span class="badge mr-1 badge-dark"><span class="fas fa-tasks"></span> در حال تکمیل</span>
        <?php endif; ?>
        <?php if ($doc->premium): ?>
            <span class="badge mr-3 badge-warning"><span class="far fa-gem"></span> اعضای ویژه</span>
        <?php else: ?>
            <span class="badge mr-3 badge-success"><span class="fas fa-unlock"></span> رایگان</span>
        <?php endif; ?>
    </head>

    <?php if($doc->deprecated): ?>
        <div class="alert alert-danger mt-2">
            <span class="fas fa-trash"></span> این داکیومنت از طرف توسعه‌دهنده ساپورت نمی‌شود، جدیدترین ورژن داکیومنت بزودی ترجمه خواهد شد
        </div>
    <?php endif; ?>

    <?php if ($doc->premium && !Yii::$app->user->can('accessPremium')): ?>
        <p><?= $post->meta_description ?></p>
        <p class="alert alert-warning"><span class="fas fa-exclamation-triangle"></span> این داکیومنت مخصوص اعضای ویژه است. برای دسترسی به پست‌های این داکیومنت باید عضو ویژه سایت شوید.</p>
    <?php else: ?>
        <?= $post->content ?>
        <div id="src">
            <div class="header">
                <span class="fas fa-globe"></span> منبع
            </div>
            <?= $post->src ?>
        </div>
    <?php endif; ?>
</article>
