<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $topic common\models\HelpTopics */
/* @var $post common\models\HelpPosts */
/* @var $form yii\widgets\ActiveForm */
?>

<script>
    function addFunctions(editor) {

        function callOut() {
            editor.insertContent('<div class="bd-callout bd-callout-info"><h4>عنوان کال‌اوت</h4>\nمتن کال‌اوت</div><br>');
        }

        editor.addButton('callout', {
            icon: ' fa fa-bullhorn',
            tooltip: "افزودن نکته",
            onclick: callOut
        });
    }
</script>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($post, 'post_title')->textInput(['maxlength' => true]) ?>

<?= $form->field($post, 'slug', [
    'inputOptions' => [
        'class' => 'form-control',
        'placeholder' => 'اسلاگ',
        'dir' => 'auto'
    ],
    'template' => '
        <label for="basic-url">{label}</label>
        <div class="input-group">
          {input}
          <span class="input-group-addon ltr">http://baversion.com/help/' . $topic->slug . '/</span>
        </div>',
])->textInput(['maxlength' => true])->label(false) ?>

<?= $form->field($post, 'content')->widget(TinyMce::class, [
    'options' => [
        'rows' => 20,
        'placeholder' => 'محتوای مطلب',
    ],
    'language' => 'fa',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste",
            "directionality image wordcount",
        ],
        'branding' => false,
        'toolbar' => 'ltr rtl | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image | code',
        'menubar' => false,
        'statusbar' => false,
        'directionality' => 'rtl',
        'theme' => 'modern',
        'contextmenu' => 'copy paste | link image | inserttable cell | bold italic',
        'setup' => new JsExpression("addFunctions"),
        //set br for enter
        'force_br_newlines' => true,
        'force_p_newlines' => false,
        'forced_root_block' => '',
    ]
])->label(false);?>

<div class="form-group">
    <?php if ($post->help_status != 1): ?>
        <?= Html::submitButton('ذخیره پیش‌نویس', ['class' => 'btn btn-default', 'name' => 'save', 'value' => 'draft', 'title' => 'این پست با حالت پیش‌نویس ذخیره می‌شود.']) ?>
    <?php endif; ?>
    <?php if ($post->help_status != null): ?>
        <?= Html::submitButton('بروزرسانی', ['class' => 'btn btn-primary', 'name' => 'save', 'value' => 'update', 'title' => 'این پست بروزرسانی می‌شود.']) ?>
    <?php endif; ?>
    <?php if ($post->help_status != 6): ?>
        <?= Html::submitButton('انتشار', ['class' => 'btn btn-success', 'name' => 'save', 'value' => 'publish', 'title' => 'این پست منتشر می‌شود.']) ?>
    <?php endif; ?>
    <?php if ($post->help_status != null && yii::$app->user->can('deleteHelp')): ?>
        <?= Html::submitButton('حذف', ['class' => 'btn btn-danger', 'name' => 'save', 'value' => 'remove', 'title' => 'این پست حذف می‌شود.']) ?>
    <?php endif; ?>
</div>

<?php ActiveForm::end(); ?>
