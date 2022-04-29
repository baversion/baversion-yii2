<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $pagination \yii\data\Pagination */
/* @var $docs array|\common\models\Docs[] */

$this->title = 'داکیومنت‌ها';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docs-index">

    <h1 class="font-italic"><?= Html::encode($this->title) ?></h1>
    <p class="pb-3 mb-4 border-bottom">داکیومنت‌های پروژه‌های اپن‌سورس منتخب را در این قسمت می‌توانید دنبال کنید.</p>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
    <?php foreach ($docs as $doc): ?>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="blog-post-title"><a href="<?= Url::to(['docs/' . $doc->slug . '/' . $doc->doc_version]) ?>"><?= $doc->doc_title ?></a></h2>
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?= $doc->cover_image ?>" class="img-fluid" alt="<?= $doc->doc_title ?>">
                        </div>
                        <div class="col-md-9">
                            <p class="card-text"><?= $doc->content ?></p>
                        </div>
                    </div>
                </div>

                <ul class="list-group list-group-flush">
                    <?php $counter = 0; ?>
                <?php foreach ($doc->docPosts as $post): ?>
                <?php if($counter == 3): ?>
                    <?php break; ?>
                <?php else: ?>
                    <?php if ($post->slug !== NULL): ?>
                    <?php $counter++; ?>
                    <?php else: ?>
                    <?php continue; ?>
                    <?php endif;?>
                <?php endif; ?>
                    <?php if ($post->post_status == 6): ?>
                    <li class="list-group-item"><a href="<?= Url::to(['docs/' . $doc->slug . '/' . $doc->doc_version . '/' . $post->slug]) ?>"><?= $post->post_title ?></a></li>
                    <?php else: ?>
                    <li class="list-group-item"><?= $post->post_title ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul>

                <div class="card-footer">
                    <li class="badge mr-1 mt-2 mb-2 badge-primary" data-toggle="tooltip" data-placement="top" title="آخرین ورژن منطبق با داکیومنت">
                        <span class="fas fa-history"></span> <?= $doc->version ?>
                    </li>
                    <?php if($doc->deprecated): ?>
                    <li class="badge mr-1 mt-2 mb-2 badge-danger" data-toggle="tooltip" data-placement="top" title="این داکیومنت از طرف توسعه‌دهنده ساپورت نمی‌شود، جدیدترین ورژن داکیومنت بزودی ترجمه خواهد شد">
                        <span class="fas fa-trash"></span> منقضی شده
                    </li>
                    <?php elseif($doc->completed): ?>
                        <li class="badge mr-1 mt-2 mb-2 badge-success" data-toggle="tooltip" data-placement="top" title="پست‌ها به طور کامل ترجمه شده‌اند">
                            <span class="fas fa-check"></span> کامل شده
                        </li>
                    <?php else: ?>
                    <li class="badge mr-1 mt-2 mb-2 badge-dark" data-toggle="tooltip" data-placement="top" title="پست‌ها در حال ترجمه هستند">
                        <span class="fas fa-tasks"></span> در حال تکمیل
                    </li>
                    <?php endif; ?>
                    <?php if ($doc->premium): ?>
                    <li class="badge mr-1 mt-2 mb-2 badge-warning" data-toggle="tooltip" data-placement="top" title="این داکیومنت فقط در اختیار اعضای ویژه است">
                        <span class="fas fa-gem"></span> اعضای ویژه
                    </li>
                    <?php else: ?>
                    <li class="badge mr-1 mt-2 mb-2 badge-info" data-toggle="tooltip" data-placement="top" title="این داکیومنت به صورت عمومی در دسترس همه بازدیدکنندگان قرار دارد">
                        <span class="fas fa-unlock"></span> رایگان
                    </li>
                    <?php endif; ?>
                    <a href="<?= Url::to(['docs/' . $doc->slug . '/' . $doc->doc_version]) ?>" class="btn btn-outline-secondary float-right">
                        <?php if ($doc->cover_image !== null): ?>
                            <img src="<?= $doc->cover_image ?>" class="micro-thumbnail" alt="<?= $doc->doc_title ?>">
                        <?php endif; ?>
                        مشاهده داکیومنت
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

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
