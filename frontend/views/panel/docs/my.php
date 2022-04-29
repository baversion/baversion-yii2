<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $posts common\models\DocPosts */
/* @var $pagination \yii\data\Pagination */

$this->title = 'مطالب نوشته شده توسط شما';
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = ['label' => 'داکیومنت‌ها', 'url' => ['panel/docs']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(); ?>
<div class="table-responsive">
    <table class="table table-condensed table-hover table-bordered table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>عنوان</th>
            <th>تاریخ انتشار</th>
            <th>وضعیت</th>
            <th>مشاهده</th>
        </tr>
        </thead>
        <tbody>
        <?php $postCounter = $pagination->page * $pagination->defaultPageSize; ?>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td><?=++$postCounter?></td>
                <td><?= $post->post_title ?></td>
                <td><?=Yii::$app->jdate->date('o/n/d', $post->published_at)?></td>
                <td>
                    <?php
                    $status = [
                        'draft' => 'پیش‌نویس',
                        'pending' => 'در دست بررسی',
                        'published' => 'منتشر شده',
                        'trash' => 'حذف شده'
                    ];
                    echo $status[$post->post_status];
                    ?>
                </td>
                <td>
                    <?php if ($post->post_status == 'published'): ?>
                        <a href="<?= Url::to(['docs/' . $post->doc->slug . '/' . $post->doc->doc_version . '/' . $post->slug]) ?>" target="_blank"><span class="fa fa-link"></span></a>
                    <?php elseif ($post->post_status == 'draft' or ($post->post_status == 'pending' && Yii::$app->user->can('manageContent'))): ?>
                        <a href="<?= Url::to(['panel/docs/post/' . $post->id]) ?>" target="_blank"><span class="fa fa-pencil"></span></a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if ($postCounter == 0): ?>
            <tr class="danger">
                <td colspan="5">هیچ محتوایی وجود ندارد.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
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
