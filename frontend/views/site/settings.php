<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Users */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'ویرایش مشخصات';
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = $this->title;
?>



<?php $form = ACTIVEFORM::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'display_name')->textInput(['maxlength' => true, 'dir' => 'auto']) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'dir' => 'auto']) ?>
            <small class="text-muted">در صورت تغییر ایمیل، باید مجددا ایمیل خود را تایید کنید.</small>

            <?= $form->field($model, 'password')->passwordInput([]) ?>
            <small class="text-muted">اگر نمی‌خواهید پسوردتان را تغییر دهید، فیلد مربوط به پسورد را خالی رها کنید.</small>

            <div class="form-group">
                <?= Html::submitButton('آپدیت پروفایل', ['class' => 'btn btn-outline-primary', 'name' => 'updateProfile', 'value' => 'update']) ?>
            </div>
        </div>
    </div>

    <br>

<?php ActiveForm::end(); ?>
