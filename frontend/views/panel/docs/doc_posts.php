<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $pagination \yii\data\Pagination */
/* @var $doc array|\common\models\Docs[] */
/* @var $posts array|\common\models\DocPosts[] */

$this->title = 'داکیومنت ' . $doc->doc_title;
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = ['label' => 'داکیومنت‌ها', 'url' => ['panel/docs']];
$this->params['breadcrumbs'][] = ['label' => $doc->doc_title, 'url' => ['panel/docs/doc/' . $doc->id]];
?>

<?php Pjax::begin(); ?>

<div class="table-responsive">
    <table class="table table-condensed table-hover table-bordered table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>عنوان</th>
            <th>تاریخ ایجاد</th>
            <th>نویسنده</th>
            <th>تعداد بازدید</th>
            <th>مشاهده</th>
        </tr>
        </thead>
        <tbody>
        <?php $postCounter = 0; ?>
        <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?=++$postCounter?></td>
                    <td><?= $post->post_title ?></td>
                    <td><?=Yii::$app->jdate->date('o/n/d', $post->created_at)?></td>
                    <td>
                        <?php if($post->author_id == NULL): ?>
                            ثبت نشده
                        <?php else: ?>
                            <?= $post->author->display_name ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $post->view_count ?></td>
                    <td>
                        <?php if($post->lock_to == Yii::$app->user->identity->id OR $post->lock_to === null): ?>
                            <a href="<?= Url::to(['panel/docs/preview/' . $post->id]) ?>" target="_blank" title="پیش‌نمایش پست"><span class="fas fa-eye"></span></a>
                        <?php endif; ?>
                        <?php if($post->lock_to == Yii::$app->user->identity->id): ?>
                            <a href="<?= Url::to(['panel/docs/post/' . $post->id]) ?>" target="_blank" title="ویرایش پست"><span class="fas fa-pencil-alt"></span></a>
                            <?= Html::a('<span class="fas fa-hand-rock"></span>', ['catch', 'id' => $post->id], [
                                'title' => 'آزاد کردن',
                                'data' => [
                                    'confirm' => 'آزاد کردن پست، امکان انتخاب و ویرایش آن را به اعضا می‌دهد. آیا از ویرایش منصرف شده‌اید؟',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php elseif($post->lock_to === null): ?>
                            <?= Html::a('<span class="fas fa-hand-paper"></span>', ['catch', 'id' => $post->id], [
                                'title' => 'رزرو',
                                'data' => [
                                    'confirm' => 'برای ویرایش پست باید آن را انتخاب و رزرو کنید. آیا می‌خواهید پست را رزرو کنید؟',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php else: ?>
                            <span class="fa fa-lock"></span>
                        <?php endif; ?>
                        <?php if ($post->post_status == 6 && $post->slug != null): ?>
                            <a href="<?= Url::to(['docs/' . $doc->slug . '/' . $doc->doc_version . '/' . $post->slug]) ?>" target="_blank" title="لینک پست"><span class="fas fa-link"></span></a>
                        <?php endif; ?>
                    </td>
                </tr>
        <?php endforeach; ?>
        <?php if ($postCounter == 0): ?>
            <tr class="danger">
                <td colspan="6">هیچ محتوایی وجود ندارد.</td>
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
