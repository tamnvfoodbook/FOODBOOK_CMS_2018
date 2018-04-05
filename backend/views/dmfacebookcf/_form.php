<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmfacebookcf */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmfacebookcf-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PAGE_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'POS_PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PAGE_ACCESS_TOKEN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'URL_POINT_POLICY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'URL_PROMOTION')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATED_AT')->textInput() ?>

    <?= $form->field($model, 'PERSISTENT_MENU')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'MESSAGE_GREETING')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_ERROR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_CHECKIN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_MEMBER_POINT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_MEMBER_NO_POINT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_NO_GIFT_POINT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_GET_MENU')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_TOKEN_ORDER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_ORDER_ONLINE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_BOOKING_ONLINE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_REQUIED_RATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_REQUIED_REGISTER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_REGISTER_SUCCESS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_NO_DAILY_VOUCHER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_MISS_DAILY_VOUCHER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_SENT_DAILY_VOUCHER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_LIMIT_DAILY_VOUCHER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SUB_TITLE_HOTLINE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SUB_TITLE_PROMOTION')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SUB_TITLE_POLICY_POINT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_GET_POS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AUTO_REPLY_MENU')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'STATUS_BOTCHAT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
