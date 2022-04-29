<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Docs */

$this->title = 'ساخت داکیومنت';
$this->params['breadcrumbs'][] = ['label' => 'داکیومنت‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
