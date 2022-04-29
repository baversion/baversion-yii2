<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $posts common\models\DocPosts */
/* @var $pagination \yii\data\Pagination */

$this->title = 'پیش‌نویس‌ها';
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
            <th>داکیومنت</th>
            <th>مشاهده</th>
        </tr>
        </thead>
        <tbody>
        <?php $postCounter = $pagination->page * $pagination->defaultPageSize; ?>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td><?=++$postCounter?></td>
                <td><?= $post->post_title ?></td>
                <td><?= $post->doc->doc_title ?></td>
                <td>
                    <?php $lock_to = null; ?>
                    <?php foreach ($post->docPostMetas as $meta): ?>
                        <?php if ($meta->meta_key == 'edit_lock'): ?>
                            <?php $lock_to = $meta->meta_value ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if($lock_to == Yii::$app->user->identity->id): ?>
                        <a href="<?= Url::to(['panel/docs/post/' . $post->id]) ?>" target="_blank" title="ویرایش پست"><span class="fa fa-pencil"></span></a>
                        <?= Html::a('<span class="fa fa-hand-grab-o"></span>', ['catch', 'id' => $post->id], [
                            'title' => 'آزاد کردن',
                            'data' => [
                                'confirm' => 'آزاد کردن پست، امکان انتخاب و ویرایش آن را به اعضا می‌دهد. آیا از ویرایش منصرف شده‌اید؟',
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php elseif($lock_to == null): ?>
                        <a href="<?= Url::to(['panel/docs/post/' . $post->id]) ?>" target="_blank" title="مشاهده پست"><span class="fa fa-eye"></span></a>
                        <?= Html::a('<span class="fa fa-hand-stop-o"></span>', ['catch', 'id' => $post->id], [
                            'title' => 'رزرو',
                            'data' => [
                                'confirm' => 'برای ویرایش پست باید آن را انتخاب و رزرو کنید. آیا می‌خواهید پست را رزرو کنید؟',
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php else: ?>
                        <span class="fa fa-lock"></span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if ($postCounter == 0): ?>
            <tr class="danger">
                <td colspan="4">هیچ محتوایی وجود ندارد.</td>
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
