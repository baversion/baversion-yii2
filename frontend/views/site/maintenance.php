<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'سایت در حال بروزرسانی است.';
?>
<div class="mt-4">

    <h1><?= $this->title ?></h1>

    <div class="alert alert-info">
        <p>باورژن در حال بروزرسانی است، سایت تا ساعت <?= $hour ?> به حالت عادی باز خواهد گشت.<br>
        در صورتی که نیاز به ارتباط با ما دارید، از طریق ایمیل baversion.com در جیمیل می‌توانید با ما تماس بگیرید.<br>
            باتشکر از صبر و شکیبایی شما
        </p>
    </div>
</div>
