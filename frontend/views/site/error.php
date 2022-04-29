<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'خطای ' . Yii::$app->response->statusCode;
?>
<div class="site-error">

    <h1><?= $this->title ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>خطای بالا در هنگام پردازش توسط سرور رخ داده است.<br>
    در صورتی که فکر می‌کنید این خطا اشتباها رخ داده است، با ما <a href="/contant">تماس</a> بگیرید.
    <br>
    باتشکر</p>

</div>
