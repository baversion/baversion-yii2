<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $topic common\models\HelpTopics */
/* @var $post common\models\HelpPosts */

$this->title = 'افزودن پست به تاپیک راهنما';
$this->params['breadcrumbs'][] = ['label' => 'تاپیک‌های راهنما', 'url' => ['help/']];
$this->params['breadcrumbs'][] = ['label' => $topic->topic_title, 'url' => ['help/' . $topic->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_post_form', [
    'topic' => $topic,
    'post' => $post,
]) ?>
