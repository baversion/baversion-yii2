<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $pagination \yii\data\Pagination */
/* @var $docs array|\common\models\Docs[] */

$this->title = 'داکیومنت‌ها';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="table-responsive">
    <table class="table table-condensed table-hover table-bordered table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>عنوان</th>
            <th>تاریخ ایجاد</th>
            <th>نویسنده</th>
            <th>مشاهده</th>
        </tr>
        </thead>
        <tbody>
        <?php $docCounter = 0; ?>
        <?php foreach ($docs as $doc): ?>
                <tr>
                    <td><?=++$docCounter?></td>
                    <td><?= $doc->doc_title ?> <span class="badge mr-3 badge-pill badge-outline-success"><?= $doc->doc_version ?></span></td>
                    <td><?=Yii::$app->jdate->date('o/n/d', $doc->created_at)?></td>
                    <td>
                        <?php if($doc->author_id == NULL): ?>
                            ثبت نشده
                        <?php else: ?>
                            <?= $doc->author->display_name ?>
                        <?php endif; ?>
                    </td>
                    <td>
                            <a href="<?= Url::to(['panel/docs/doc/' . $doc->id]) ?>"><span class="fas fa-eye"></span></a>
                    </td>
                </tr>
        <?php endforeach; ?>
        <?php if ($docCounter == 0): ?>
            <tr class="danger">
                <td colspan="5">هیچ محتوایی وجود ندارد.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
echo LinkPager::widget([
    'pagination' => $pagination,
]);
?>
<?php Pjax::end(); ?>
