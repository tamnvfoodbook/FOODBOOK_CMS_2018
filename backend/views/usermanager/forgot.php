<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>


<div class="user-form">
    <?php $form = ActiveForm::begin();?>


    <?= $form
        ->field($model, 'username')
        ->label('Tài khoản')
        ->textInput(['placeholder' => $model->getAttributeLabel('Số điện thoại')])?>
    <br>

    <?= Html::submitButton('Nhận mã Reset', ['class'=> 'btn btn-primary']) ;?>

    <?php ActiveForm::end(); ?>
</div>


