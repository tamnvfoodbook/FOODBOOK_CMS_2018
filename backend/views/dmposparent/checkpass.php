<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin([
    'action' => ['reset','pos_parent' => $pos_parent],
    'method' => 'post'
]); ?>
    <?= $form->field(@$userModel, 'oldpass')->passwordInput(['maxlength' => true])->label('Mật khẩu');?>
    <?= Html::submitButton('Xác nhận', ['class' => 'btn btn-danger']) ?>
<?php ActiveForm::end(); ?>
