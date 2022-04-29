<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Docs */

$this->title = 'ویرایش ' . $model->doc_title;
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = ['label' => 'داکیومنت‌ها', 'url' => ['panel/docs']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_doc_form', [
    'model' => $model,
]) ?>