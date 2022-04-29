<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $doc common\models\Docs */
/* @var $post common\models\DocPosts */
/* @var $form yii\widgets\ActiveForm */
/* @var $postList array */
/* @var $model \common\models\DocPosts */
?>

<div class="doc-posts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($post, 'post_title', [
        'inputOptions' => [
            'class' => 'form-control input-lg',
            'placeholder' => 'عنوان پست'
        ]
    ])->textInput(['maxlength' => true])->label(false) ?>

    <?php if (Yii::$app->user->can('manageContent')): ?>
        <?= $form->field($post, 'slug', [
            'inputOptions' => [
                'class' => 'form-control',
                'placeholder' => 'slug',
                'dir' => 'auto'
            ],
            'template' => '
                <div class="input-group" dir="ltr">
                    <span class="input-group-addon">http://baversion.com/docs/' . $doc->slug . '/' . $doc->doc_version . '/</span>
                    {input}
                </div>',
        ])->textInput(['maxlength' => true])->label(false) ?>
    <?php endif; ?>

    <?= $form->field($post, 'content')->widget(TinyMce::class, [
        'options' => [
            'rows' => 20,
            'placeholder' => 'محتوای مطلب',
        ],
        'language' => 'fa',
        'clientOptions' => [
//            'file_browser_callback' => new yii\web\JsExpression("function(field_name, url, type, win) {
//			window.open('".yii\helpers\Url::to(['images', 'view-mode'=>'iframe', 'select-type'=>'tinymce'])."&tag_name='+field_name,'','width=800,height=540 ,toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no');
//		}"),
            'plugins' => [
                "advlist autolink lists link charmap anchor preview",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste image",
                "directionality image wordcount",
            ],
            'branding' => false,
            'toolbar' => 'ltr rtl | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist' . (!Yii::$app->user->can('manageContent') ? '' : ' | link image | code'),
            'menubar' => false,
            //'statusbar' => false,
            'directionality' => 'rtl',
            'theme' => 'modern',
            'skin' => 'lightgray',
            'contextmenu' => 'copy paste | inserttable cell | bold italic',
        ]
    ])->label(false);?>

    <?php if(\Yii::$app->user->can('manageContent')): ?>
        <?= $form->field($post, 'src', [
            'inputOptions' => [
                'class' => 'form-control input-lg',
                'placeholder' => 'منبع',
                'dir' => 'auto'
            ]
        ])->textInput(['maxlength' => true])->label(false) ?>

        <?= $form->field($post, 'parent_id')->dropDownList($postList, ['prompt' => 'والد'])->label(false) ?>

        <?= $form->field($post, 'meta_keywords', [
            'inputOptions' => [
                'class' => 'form-control input-lg',
                'placeholder' => 'کلمات کلیدی را با کاما جدا کنید.',
            ]
        ])->textInput(['rows' => 6])->label(false) ?>

        <?= $form->field($post, 'meta_description', [
            'inputOptions' => [
                'class' => 'form-control input-lg',
                'placeholder' => 'متای توضیحات را در یک پاراگراف بنویسید.',
            ]
        ])->textarea(['rows' => 6])->label(false) ?>
    <?php endif; ?>

    <?php if ($post->src !== null): ?>
        <div id="src">
            <div class="header">
                <span class="fas fa-globe"></span> منبع
            </div>
            <?= $post->src ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('ذخیره پیش‌نویس', ['class' => 'btn btn-default', 'name' => 'savePost', 'value' => 'draft', 'title' => 'پست برای شما قفل شده و تا زمان انتشار قابل مشاهده و ثبت توسط دیگران نیست.']) ?>
        <?= Html::submitButton('انتشار', ['class' => 'btn btn-primary', 'name' => 'savePost', 'value' => 'publish', 'title' => 'این پست منتشر خواهد شد.']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
