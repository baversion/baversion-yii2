<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'تماس';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    از اینکه تمایل دارید با ما تماس بگیرید متشکریم، به هر دلیلی که که تمایل دارید با ما تماس بگیرید، استقبال خواهیم کرد.
<br>
    اولین و مهمترین اصل کار ما ارتباط صحیح و شفاف با مشتری‌ها و کاربران‌مان است، سعی داریم مادامی که توانایی پاسخگویی به تماس‌ها را داشته باشیم، روش‌های دیگری برای تماس را ایجاد کنیم.
<br>
    برای مشاوره، انتقادات، پیشنهادات و هر موضوع مرتبطی که تمایل دارید می‌توانید از طریق راه‌های زیر با ما تماس بگیرید:
<br>
    ایمیل baversion.com[at]gmail[dot]com در تمام ساعات شبانه روز پذیرای ایمیل‌های شما است و ما در اسرع وقت به آن‌ها پاسخ خواهیم داد.
<br>
<?php if(!Yii::$app->session->hasFlash('form')): ?>
    همچنین فرم زیر نیز در صورتی که تمایل ندارید به ایمیل خود وارد شوید:
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('نام شما') ?>

                <?= $form->field($model, 'email')->label('ایمیل') ?>

                <?= $form->field($model, 'subject')->label('موضوع') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6])->label('متن') ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ])->label('کد کپچا') ?>

                <div class="form-group">
                    <?= Html::submitButton('ارسال', ['class' => 'btn btn-outline-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php endif; ?>
</div>
