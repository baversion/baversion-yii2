<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
$this->title = 'آپلود فایل';
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= Html::submitButton('آپلود', ['class' => 'btn btn-outline-light', 'name' => 'upload']) ?>

<?php ActiveForm::end() ?>
