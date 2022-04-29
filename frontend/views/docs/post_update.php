<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $doc common\models\Docs */
/* @var $post common\models\DocPosts */
/* @var $postList array */

$this->title = 'ویرایش ' . $post->post_title;
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = ['label' => 'داکیومنت‌ها', 'url' => ['panel/docs']];
$this->params['breadcrumbs'][] = ['label' => $doc->doc_title, 'url' => ['panel/docs/doc/' . $doc->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_post_form', [
    'doc' => $doc,
    'post' => $post,
    'postList' => $postList,
]) ?>

