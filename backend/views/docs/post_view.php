<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $post common\models\DocPosts */

$this->title = $post->post_title;
$this->params['breadcrumbs'][] = ['label' => 'داکیومنت‌ها', 'url' => ['/docs']];
$this->params['breadcrumbs'][] = ['label' => $doc->doc_title, 'url' => ['docs/doc/' . $doc->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mb-4">
    <hr>
    <?= $post->content ?>
    <hr>
    <?php if ($post->src !== null): ?>
        <div id="src">
            <div class="header">
                <span class="fas fa-globe"></span> منبع
            </div>
            <?= $post->src ?>
        </div>
    <?php endif; ?>
</div>
