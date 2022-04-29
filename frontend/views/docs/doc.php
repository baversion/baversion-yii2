<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $doc array|\common\models\Docs[] */
/* @var $posts array|\common\models\DocPosts[] */

$this->title = 'داکیومنت ' . $doc->doc_title;
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="blog-post pb-3 mb-4">
    <h1><?= Html::encode($this->title) ?></h1>
    <head class="blog-post-meta">
        <span class="fas fa-clock"></span> <span class="post-date updated"><?= Yii::$app->jdate->date('l j F Y ساعت H:i', $doc->published_at) ?></span>
        <span class="fas fa-time"></span>
        <span class="fas fa-book"></span>
        <span><?= $doc->doc_title ?></span>
        <span class="badge mr-1 badge-primary"><span class="fas fa-history"></span> <?= $doc->version ?></span>
        <?php if($doc->deprecated): ?>
            <span class="badge mr-1 badge-danger"><span class="fas fa-trash"></span> منقضی شده</span>
        <?php elseif($doc->completed): ?>
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

    <?php if ($doc->cover_image !== null): ?>
        <img src="<?= $doc->cover_image ?>" class="img-fluid mx-auto d-block mb-4" alt="<?= $doc->doc_title ?>">
    <?php endif; ?>

    <?= $doc->content ?>

    <hr>

    <?php if ($doc->premium && !Yii::$app->user->can('accessPremium')): ?>
        <p class="alert alert-warning"><span class="fas fa-exclamation-triangle"></span> این داکیومنت مخصوص اعضای ویژه است. برای دسترسی به پست‌های این داکیومنت باید عضو ویژه سایت شوید.</p>
    <?php endif; ?>

    <div class="p-3">
        <h4 class="font-italic">فهرست محتوا</h4>
        <ol class="list-unstyled mb-0">
            <?php $parentPosts = []; ?>
            <?php $childPosts = []; ?>
            <?php $doc = $this->params['doc']; ?>
            <?php foreach ($this->params['posts'] as $sidePost): ?>
                <?php if ($sidePost['parent_id'] == null): ?>
                    <?php $parentPosts[$sidePost['post_order']] = $sidePost; ?>
                <?php else: ?>
                    <?php $childPosts[$sidePost['parent_id']][$sidePost['post_order']] = $sidePost; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php foreach ($parentPosts as $parent): ?>
                <li class="mb-2">
                    <?php if ($parent['slug'] == null): ?>
                        <?= $parent['post_title'] ?>
                    <?php else: ?>
                        <?php if ($parent['post_status'] != 6): ?>
                            <?= $parent['post_title'] ?>  <span class="badge mr-3 badge-pill badge-outline-secondary">در صف ترجمه</span>
                        <?php else: ?>
                            <a href="<?= Url::to(['docs/' . $doc->slug . '/' . $doc->doc_version . '/' . $parent['slug']]) ?>"><?= $parent['post_title']; ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (isset($childPosts[$parent['id']])): ?>
                        <ul>
                            <?php $orderCounter = 0; ?>
                            <?php foreach ($childPosts[$parent['id']] as $child): ?>
                                <?php if($child['post_order'] != ++$orderCounter): ?>
                                    <?php ++$orderCounter; ?>
                                    <?php if ($parent['post_status'] != 6): ?>
                                        <li>
                                            <?= $parent['post_title'] ?> <span class="badge mr-3 badge-pill badge-outline-secondary">در صف ترجمه</span>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <a href="<?= Url::to(['docs/' . $doc->slug . '/' . $doc->doc_version . '/' . $parent['slug']]) ?>"><?= $parent['post_title']; ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($child['post_order'] == 0): // Leave it empty, it shouldn't be inside list ?>
                                <?php elseif ($child['post_status'] != 6): ?>
                                    <li>
                                        <?= $child['post_title'] ?> <span class="badge mr-3 badge-pill badge-outline-secondary">در صف ترجمه</span>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <a href="<?= Url::to(['docs/' . $doc->slug . '/' . $doc->doc_version . '/' . $child['slug']]) ?>"><?= $child['post_title']; ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</article>