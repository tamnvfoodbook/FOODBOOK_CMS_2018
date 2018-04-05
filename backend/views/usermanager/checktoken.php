<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="user-form">
    <?php $form = ActiveForm::begin([
        'action' => 'index.php?r=usermanager/resetpassword',
    ]);?>

    <label>Mã xác thực</label>
    <?=Html::input('text','token_sms','',['class'=>'form-control'])?>
    <?=Html::hiddenInput('reset_client_token',$reset_client_token)?>
    <br>
    <?= Html::submitButton('Gửi mã xác thực', ['class'=> 'btn btn-primary']) ;?>

    <?php ActiveForm::end(); ?>
</div>


