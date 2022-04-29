<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TerminologySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'اصطلاحات فنی';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="font-italic"><?= Html::encode($this->title) ?></h1>
<p class="pb-3 mb-4 border-bottom">از نظر ما یادگیری مفهوم اصطلاحات تخصصی بهتر از معادل‌سازی فارسی است که در اثر موارد باعث گیج شدن نویسنده می‌شود.</p>
<?php if (Yii::$app->user->can('manageContent')): ?>
    <p>
        <?= Html::a('افزودن اصطلاح', ['create'], ['class' => 'btn btn-outline-light btn-sm']) ?>
    </p>
<?php endif; ?>
<?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php foreach (array_chunk(range('A', 'Z'), 4, true) as $characters): ?>
    <div class="row">
        <?php foreach ($characters as $char): ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <h3><?= $char ?></h3>
                <ul class="list-group">
                    <?php $lowerChar = strtolower($char); ?>
                    <?php if (isset($terms[$lowerChar])): ?>
                        <?php foreach ($terms[$lowerChar] as $term): ?>
                            <li><a href="<?= Url::to('terminologies/term/' . $term['slug']) ?>"><?= $term['term_title'] ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<?php Pjax::end(); ?>
