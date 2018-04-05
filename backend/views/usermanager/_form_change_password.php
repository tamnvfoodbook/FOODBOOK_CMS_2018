<?php
$this->title = "Thay đổi mật khẩu";
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
?>
<div class="user-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['id' => 'resetpass-form']); ?>
    <?= $form->field($model, 'oldpass')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'newpass')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'repeatnewpass')->passwordInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Lưu' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>



<script>
    $(document).ready(function () {
        $("#resetpass-form").on("beforeSubmit", function (event, messages) {
            var form = $(this);
            // return false if form still have some validation errors
//            if (form.find('.has-error').length) {
//                return false;
//            }
            if (!$('#user-oldpass').length ){
                $('.field-user-oldpass').addClass('has-error');
                $('.field-user-oldpass .help-block').html('Mật khẩu cũ Không được để trống');

                return false;
            }
            // submit form

        });
    });
</script>

