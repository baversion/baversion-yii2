<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Docs */

$this->title = 'Create Docs';
$this->params['breadcrumbs'][] = ['label' => 'Docs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_doc_form', [
        'model' => $model,
    ]) ?>

</div>
