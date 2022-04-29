<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Tags */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'tag_name', [
    'inputOptions'=>[
        'class'=>'form-control input-lg',
        'placeholder'=>'نام تگ'
    ]
])->textInput(['maxlength' => true])->label(false) ?>

<?= $form->field($model, 'slug', [
    'inputOptions' => [
        'class' => 'form-control input-lg',
        'placeholder' => 'slug',
    ],
    'template' => '<label for="basic-url">{label}</label>
<div class="input-group mb-3" dir="ltr">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon3">http://baversion.com/tag/</span>
  </div>
  {input}
</div>',
])->textInput(['maxlength' => true])->label(false) ?>

<script>
    function addFunctions(editor) {

        function callOut() {
            editor.insertContent('<div class="bd-callout bd-callout-info"><h4>عنوان کال‌اوت</h4>\n<p>متن کال‌اوت</p></div><br>');
        }

        editor.addButton('callout', {
            icon: ' fa fa-bullhorn',
            tooltip: "افزودن نکته",
            onclick: callOut
        });
    }
</script>
<?= $form->field($model, 'content')->widget(TinyMce::class, [
    'options' => [
        'rows' => 20,
        'placeholder' => 'محتوای تگ',
    ],
    'language' => 'fa',
    'clientOptions' => [
//        'file_browser_callback' => new yii\web\JsExpression("function(field_name, url, type, win) {
//			window.open('".yii\helpers\Url::to(['panel/images/upload', 'view-mode'=>'iframe', 'select-type'=>'tinymce'])."&tag_name='+field_name,'','width=800,height=540 ,toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no');
//		}"),
        'plugins' => [
            "advlist autolink lists link charmap anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste image",
            "directionality placeholder image wordcount",
        ],
        'branding' => false,
        'toolbar' => 'ltr rtl | currentdate | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image | callout' . (Yii::$app->user->can('manageContent') ? ' | code' : ''),
        'menubar' => false,
        'statusbar' => false,
        'directionality' => 'rtl',
        'theme' => 'modern',
        'skin' => 'lightgray',
        'contextmenu' => 'link image | inserttable cell | bold italic',
        'setup' => new JsExpression("addFunctions"),
        //set br for enter
        'force_br_newlines' => true,
        'force_p_newlines' => false,
        'forced_root_block' => '',
        'content_css' => 'http://baversion.com/assets/css-compress/fb1566e3a1e26fe8afb7135b467a5bb7.css',
    ]
])->label(false);?>

<?php if(\Yii::$app->user->can('manageContent')): ?>
<?= $form->field($model, 'meta_keywords', [
    'inputOptions' => [
        'class' => 'form-control input-lg',
        'placeholder' => 'کلمات کلیدی را با کاما جدا کنید.',
    ]
])->textInput(['rows' => 6])->label(false) ?>

<?= $form->field($model, 'meta_description', [
    'inputOptions' => [
        'class' => 'form-control input-lg',
        'placeholder' => 'متای توضیحات را در یک پاراگراف بنویسید.',
    ]
])->textarea(['rows' => 6])->label(false) ?>

<?php endif; ?>

<div class="form-group">
    <?php if ($model->tag_status == 'publish'): ?>
        <?= Html::submitButton('آپدیت پیش‌نویس', ['class' => 'btn btn-outline-light', 'name' => 'saveTag', 'value' => 'draft', 'title' => 'پست برای شما کماکان قفل می‌ماند و اطلاعات آن آپدیت می‌شود.']) ?>
        <?= Html::submitButton('آپدیت پست', ['class' => 'btn btn-outline-primary', 'name' => 'saveTag', 'value' => 'publish', 'title' => 'اطلاعات این پست آپدیت خواهد شد.']) ?>
    <?php else: ?>
        <?= Html::submitButton('ذخیره پیش‌نویس', ['class' => 'btn btn-outline-light', 'name' => 'saveTag', 'value' => 'draft', 'title' => 'پست برای شما قفل خواهد شد و تا زمان انتشار قابل مشاهده و ثبت توسط دیگران نیست.']) ?>
        <?= Html::submitButton('انتشار', ['class' => 'btn btn-outline-primary', 'name' => 'saveTag', 'value' => 'publish', 'title' => 'این پست منتشر خواهد شد.']) ?>
    <?php endif; ?>
</div>

<?php ActiveForm::end(); ?>
