<?php

use dosamigos\selectize\SelectizeTextInput;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;;


/* @var $this yii\web\View */
/* @var $model common\models\Articles */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'article_title', [
    'inputOptions' => [
        'class' => 'form-control input-lg',
        'placeholder' => 'عنوان مطلب'
    ]
])->textInput(['maxlength' => true])->label(false) ?>

<?= $form->field($model, 'slug', [
    'inputOptions' => [
        'class' => 'form-control input-lg',
        'placeholder' => 'slug',
    ],
    'template' => '
        <label for="basic-url">{label}</label>
        <div class="input-group mb-3" dir="ltr">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon3">http://baversion.com/blog/post/</span>
          </div>
          {input}
        </div>',
])->textInput(['maxlength' => true])->label(false) ?>

<script>
    function addFunctions(editor) {

        function callOut() {
            editor.insertContent('<div class="bd-callout bd-callout-info"><h4>توجه</h4><p>\n</p></div><br>');
        }

        editor.addButton('callout', {
            icon: ' fas fa-bullhorn',
            tooltip: "افزودن نکته",
            onclick: callOut
        });
    }
</script>
<?= $form->field($model, 'content')->widget(TinyMce::class, [
    'options' => [
        'rows' => 20,
        'placeholder' => 'محتوای پست',
    ],
    'language' => 'fa',
    'clientOptions' => [
        'file_browser_callback' => new yii\web\JsExpression("function(field_name, url, type, win) {
			//window.open('".yii\helpers\Url::to(['panel/images/upload', 'view-mode'=>'iframe', 'select-type'=>'tinymce'])."&tag_name='+field_name,'','width=800,height=540 ,toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no');
			if(type == 'image') {
			    $('#upload_image input[type=\"file\"').click();
			}
		}"),
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
        'theme' => 'modern',
        'skin' => 'light',
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
        'autosave_retention' => '1440m',
        'setup' => new JsExpression("addFunctions"),
        //set br for enter
        'force_br_newlines' => false,
        'force_p_newlines' => true,
        'forced_root_block' => '',
        'content_css' => 'http://baversion.com/assets/css-compress/fb1566e3a1e26fe8afb7135b467a5bb7.css',
        'relative_urls' => false,
        'remove_script_host' => false,
        'convert_urls' => true,
    ]
])->label(false);?>

<?= $form->field($model, 'excerpt', [
    'inputOptions' => [
        'class' => 'form-control input-lg',
        'placeholder' => 'چکیده',
    ]
])->textarea(['rows' => 6])->label(false) ?>

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
    <?= Html::submitButton('ذخیره پیش‌نویس', ['class' => 'btn btn-outline-light', 'name' => 'createPost', 'value' => 'draft', 'title' => 'پست برای شما قفل شده و تا زمان انتشار قابل مشاهده و ثبت توسط دیگران نیست.']) ?>
    <?= Html::submitButton('انتشار', ['class' => 'btn btn-outline-primary', 'name' => 'createPost', 'value' => 'publish', 'title' => 'این پست منتشر خواهد شد.']) ?>
</div>

<?php ActiveForm::end(); ?>

<form action="<?= \yii\helpers\Url::to('/upload') ?>" id="upload_image" target="test-text-ifr" method="post" enctype="multipart/form-data" style="width:0;height:0;overflow: hidden;">
    <input type="file" name="image" onchange="$('#upload_image').submit();this.value='';">
    <input type="hidden" name="_csrf-frontend"  value="<?= Yii::$app->request->getCsrfToken() ?>">
</form>