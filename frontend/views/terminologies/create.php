<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Terminology */

$this->title = 'افزودن اصطلاح فنی';
$this->params['breadcrumbs'][] = ['label' => 'Terminologies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terminology-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
