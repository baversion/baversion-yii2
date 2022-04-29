<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $post common\models\DocPosts */

\dominus77\highlight\Plugin::$options = [
    'theme' => 'github',// Styles
    'lineNumbers' => true,    // Show line numbers
    'singleLine' => true,     // Show number if one line
];
\dominus77\highlight\Plugin::register($this);

$this->title = $post->post_title;
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = ['label' => 'داکیومنت‌ها', 'url' => ['panel/docs']];
$this->params['breadcrumbs'][] = ['label' => $doc->doc_title, 'url' => ['panel/docs/doc/' . $doc->id]];
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
