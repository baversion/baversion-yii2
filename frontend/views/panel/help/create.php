<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HelpTopics */

$this->title = 'Create Help Topics';
$this->params['breadcrumbs'][] = ['label' => 'Help Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-topics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
