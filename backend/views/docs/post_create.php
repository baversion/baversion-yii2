<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $doc common\models\Docs */
/* @var $post common\models\DocPosts */
/* @var $postList array */

$this->title = 'ساخت پست';
$this->params['breadcrumbs'][] = ['label' => 'داکیومنت‌ها', 'url' => ['/docs']];
$this->params['breadcrumbs'][] = ['label' => $doc->doc_title, 'url' => ['docs/doc/' . $doc->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_post_form', [
    'doc' => $doc,
    'post' => $post,
    'postList' => $postList,
]) ?>