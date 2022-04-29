<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\authItem */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin();?>
    <div class="row">
        <div class="col-md-4">
            <div class="role-form">
                <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>
                <?=$form->field($model, 'description')->textarea(['rows' => 6])?>
            </div>
        </div>
    </div>

    <hr>

    <h2>پرمیشن‌ها:</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام پرمیشن</th>
                        <th>توضیحات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($permissions as $permission): ?>
                        <tr>
                            <td>
                                <?= Html::checkbox("Permissions[{$permission['name']}]", $permission['checked'], ['id' => $permission['name']]); ?>
                            </td>
                            <td><label for="<?= $permission['name'] ?>"><?= $permission['name'] ?></label></td>
                            <td><?= $permission['description'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?=Html::submitButton($model->isNewRecord ? 'ساخت' : 'آپدیت', ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-primary'])?>
    </div>
<?php ActiveForm::end();?>

