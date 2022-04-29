<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $docs common\models\Docs */
/* @var $pagination \yii\data\Pagination */

$this->title = 'داکیومنت‌ها';
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>

    <?php if (Yii::$app->user->can('manageContent')): ?>
        <p>
            <?= Html::a('ایجاد داکیومنت', ['create'], ['class' => 'btn btn-outline-light']) ?>
        </p>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-condensed table-hover table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>عنوان</th>
                <th>زیرعنوان</th>
                <th>ورژن داکیومنت</th>
                <th>آخرین ورژن</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            <?php $docCounter = $pagination->page * $pagination->defaultPageSize; ?>
            <?php foreach ($docs as $doc): ?>
                <tr>
                    <td><?=++$docCounter?></td>
                    <td>
                        <?php if($doc->cover_image !== null): ?>
                            <img src="<?= $doc->cover_image ?>" title="<?= $doc->doc_title ?>" width="20px">
                        <?php endif; ?>
                        <?= $doc->doc_title ?>
                    </td>
                    <td><?= $doc->subtitle ?></td>
                    <td><?= $doc->doc_version ?></td>
                    <td><?= $doc->version ?></td>
                    <td>
                        <span class="badge mr-3 badge-pill badge-<?= ($doc->completed ? 'success' : 'info') ?>">
                        <?= ($doc->completed ? 'مستندات کامل' : 'در حال تکمیل مستندات') ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= Url::to(['panel/docs/doc/' . $doc->id]) ?>" target="_blank" title="مشاهده پست‌ها" class="btn btn-pill btn-outline-primary btn-sm">
                            <span class="fas fa-eye"></span> مشاهده پست‌ها
                        </a>
                        <?php if ($doc->doc_status == 6): ?>
                            <a href="<?= Url::to(['docs/' . $doc->slug . '/' . $doc->doc_version]) ?>" target="_blank" title="مشاهده داکیومنت" class="btn btn-pill btn-outline-light btn-sm">
                                <span class="fas fa-link"></span> مشاهده داکیومنت
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if ($docCounter == 0): ?>
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
