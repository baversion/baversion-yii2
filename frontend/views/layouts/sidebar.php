<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>

<?php if(!Yii::$app->user->isGuest): ?>
<?php endif; ?>
<?php if(Yii::$app->controller->id == 'docs'): ?>
    <?php if(Yii::$app->controller->action->id != 'index'): ?>
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
                                            <li class="mb-1">
                                                <?= $parent['post_title'] ?> <span class="badge mr-3 badge-pill badge-outline-secondary">در صف ترجمه</span>
                                            </li>
                                        <?php else: ?>
                                            <li class="mb-1">
                                                <a href="<?= Url::to(['docs/' . $doc->slug . '/' . $doc->doc_version . '/' . $parent['slug']]) ?>"><?= $parent['post_title']; ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if ($child['post_order'] == 0): // Leave it empty, it shouldn't be inside list ?>
                                    <?php elseif ($child['post_status'] != 6): ?>
                                        <li class="mb-1">
                                            <?= $child['post_title'] ?> <span class="badge mr-3 badge-pill badge-outline-secondary">در صف ترجمه</span>
                                        </li>
                                    <?php else: ?>
                                        <li class="mb-1">
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
    <?php else: ?>
        <div class="p-3">
            <h4 class="font-italic">آخرین پست‌ها</h4>
            <ol class="list-unstyled mb-0">
                <?php foreach ($this->params['latestPosts'] as $latestPost): ?>
                    <?php if($latestPost->slug == null): ?>
                        <?php continue; ?>
                    <?php endif; ?>
                    <li class="mb-2"><a href="<?= Url::to(['docs/' . $latestPost->doc->slug . '/' . $latestPost->doc->doc_version . '/' . $latestPost->slug]) ?>"><?= $latestPost->post_title; ?></a> در <a class="badge mr-3 badge-pill badge-outline-success" href="<?= Url::to(['docs/' . $latestPost->doc->slug . '/' . $latestPost->doc->doc_version]) ?>"><?= $latestPost->doc->doc_title; ?></a></li>
                <?php endforeach; ?>
            </ol>
        </div>
    <?php endif; ?>

<?php elseif(Yii::$app->controller->id == 'terminologies'): ?>
    <div class="p-3">
        <h4 class="font-italic">آخرین اصطلاحات</h4>
        <ol class="list-unstyled mb-0">
            <?php foreach ($this->params['latestTerms'] as $term): ?>
                <li class="mb-2">
                    <a href="<?= Url::to(['terminologies/term/' . $term->slug]) ?>"><?= $term->term_title; ?></a>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
<?php elseif(Yii::$app->controller->id == 'blog'): ?>
    <div class="p-3">
        <h4 class="font-italic">مطالب برگزیده</h4>
        <ol class="list-unstyled mb-0">
            <?php foreach ($this->params['featuredPosts'] as $featuredPost): ?>
                <li class="mb-2"><a href="<?= Url::to(['blog/post/' . $featuredPost->slug]) ?>"><?= $featuredPost->article_title; ?></a></li>
            <?php endforeach; ?>
        </ol>
    </div>

    <div class="p-3">
        <h4 class="font-italic">داکیومنت‌ها</h4>
        <ol class="list-unstyled mb-0">
            <?php foreach ($this->params['docs'] as $doc): ?>
                <li class="mb-2"><a href="<?= Url::to(['docs/' . $doc->slug . '/' . $doc->doc_version]) ?>"><?= $doc->doc_title; ?></a></li>
            <?php endforeach; ?>
        </ol>
    </div>
<?php elseif(Yii::$app->controller->id == 'tag'): ?>
    <div class="p-3 mb-3 bg-light rounded">
        <h4 class="font-italic">تگ</h4>
        <p class="mb-0">تگ‌ها روشی سریع برای طبقه‌بندی و یافتن مطالب مشابه هستند.</p>
    </div>

    <div class="p-3">
        <h4 class="font-italic">تگ‌های تصادفی</h4>
        <ol class="list-unstyled mb-0">
            <?php foreach ($this->params['randomTags'] as $randomTag): ?>
                <li class="mb-2"><a href="<?= Url::to(['tag/' . $randomTag->slug]) ?>"><?= $randomTag->tag_name; ?></a></li>
            <?php endforeach; ?>
        </ol>
    </div>
<?php endif; ?>
