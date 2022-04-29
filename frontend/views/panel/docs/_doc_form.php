<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Docs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="docs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'doc_title', [
        'inputOptions'=>[
            'class'=>'form-control input-lg',
            'placeholder'=>'عنوان داکیومنت'
        ]
    ])->textInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'subtitle', [
        'inputOptions'=>[
            'class'=>'form-control input-lg',
            'placeholder'=>'زیرعنوان'
        ]
    ])->textInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'slug', [
        'inputOptions' => [
            'class' => 'form-control input-lg',
            'placeholder' => 'اسلاگ',
            'dir' => 'auto',
        ]
    ])->textInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'cover_image', [
        'inputOptions' => [
            'class' => 'form-control input-lg',
            'placeholder' => 'http://baversion.com/images/{image-name.extension}',
            'dir' => 'auto',
        ]
    ])->textInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'content')->widget(TinyMce::class, [
        'options' => [
            'rows' => 20,
            'placeholder' => 'محتوای مطلب',
        ],
        'language' => 'fa',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap anchor",
                "searchreplace visualblocks code fullscreen autosave",
                "insertdatetime media table contextmenu paste anchor",
                "directionality placeholder image wordcount codesample visualblocks",
            ],
            'branding' => false,
            'toolbar' => 'restoredraft codesample visualblocks | styleselect | bold italic | bullist numlist | anchor link image | code ',
            'menubar' => false,
            'statusbar' => false,
            'directionality' => 'rtl',
//            'theme' => 'modern',
//            'skin' => 'light',
            'contextmenu' => 'copy paste | link image | inserttable cell | bold italic',
            'codesample_languages' => [
                ['text' => 'HTML/XML', 'value' => 'markup'],
                ['text' => 'JavaScript', 'value' => 'javascript'],
                ['text' => 'CSS', 'value' => 'css'],
                ['text' => 'PHP', 'value' => 'php'],
                ['text' => 'Ruby', 'value' => 'ruby'],
                ['text' => 'Python', 'value' => 'python'],
                ['text' => 'Java', 'value' => 'java'],
                ['text' => 'C', 'value' => 'c'],
                ['text' => 'C#', 'value' => 'csharp'],
                ['text' => 'C++', 'value' => 'cpp']
            ],
            'code_dialog_width' => '1024',
            'autosave_interval' => '20s', // default 30s
            'autosave_retention' => '1440m', // Keep it for 24 hours in local storage
            // There is more options for image plugin, especially list
            // The mensions plugin is very useful
            // toc is very good for documents table of contents
            // Search and replace, save, table, ...
            // Visualblock can help me to change code from popup to same editor
            // Where is placeholder plugin?
            // Check bower and its assets
            // Can you bring autosave to database? or save it every 30s to db and 5s in local storage
            // Think about publishing post process carefully

        ]
    ])->label(false);?>

    <?= $form->field($model, 'version', [
        'inputOptions' => [
            'class' => 'form-control input-lg',
            'placeholder' => 'ورژن فعلی مثلا 3.1.6',
            'dir' => 'auto',
        ]
    ])->textInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'doc_version', [
        'inputOptions' => [
            'class' => 'form-control input-lg',
            'placeholder' => 'ورژن اصلی که کلیه مستندات در آن صدق می‌کند. مثال 3',
            'dir' => 'auto',
        ]
    ])->textInput(['maxlength' => true])->label(false) ?>

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
        <?php if ($model->doc_status == 6): ?>
            <?= Html::submitButton('آپدیت پیش‌نویس', ['class' => 'btn btn-outline-light', 'name' => 'saveDoc', 'value' => 'draft', 'title' => 'پست برای شما کماکان قفل می‌ماند و اطلاعات آن آپدیت می‌شود.']) ?>
            <?= Html::submitButton('آپدیت پست', ['class' => 'btn btn-outline-primary', 'name' => 'saveDoc', 'value' => 'publish', 'title' => 'اطلاعات این پست آپدیت خواهد شد.']) ?>
        <?php else: ?>
            <?= Html::submitButton('ذخیره پیش‌نویس', ['class' => 'btn btn-outline-light', 'name' => 'saveDoc', 'value' => 'draft', 'title' => 'پست برای شما قفل خواهد شد و تا زمان انتشار قابل مشاهده و ثبت توسط دیگران نیست.']) ?>
            <?= Html::submitButton('انتشار', ['class' => 'btn btn-outline-primary', 'name' => 'saveDoc', 'value' => 'publish', 'title' => 'این پست منتشر خواهد شد.']) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
