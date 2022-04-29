<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Terminology */
\dominus77\highlight\Plugin::$options = [
    'theme' => 'github',// Styles
    'lineNumbers' => true,    // Show line numbers
    'singleLine' => true,     // Show number if one line
];
\dominus77\highlight\Plugin::register($this);

$this->title = $model->term_title;
$this->params['breadcrumbs'][] = ['label' => 'Terminologies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="terminology-term pb-3 mb-4">
    <h1><?= Html::encode($this->title) ?></h1>
    <p class="blog-post-meta">
        <span class="fas fa-user"></span> <span class="vcard author author_name"><span class="fn">مجتبی پاکزاد</span></span>
        <span class="fas fa-clock"></span> <span class="post-date updated"><?= Yii::$app->jdate->date('l j F Y ساعت H:i', $model->published_at) ?></span>
        <span class="fas fa-time"></span>
    </p>

    <?= $model->content ?>
</article>
