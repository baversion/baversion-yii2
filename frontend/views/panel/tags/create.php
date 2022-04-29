<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Tags */

$this->title = 'افزودن تگ';
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = ['label' => 'تگ‌ها', 'url' => ['panel/tags']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
