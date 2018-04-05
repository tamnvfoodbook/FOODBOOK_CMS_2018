<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmfacebookpageconfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmfacebookpageconfig-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'PAGE_ID') ?>

    <?= $form->field($model, 'POS_PARENT') ?>

    <?= $form->field($model, 'PAGE_ACCESS_TOKEN') ?>

    <?= $form->field($model, 'URL_POINT_POLICY') ?>

    <?= $form->field($model, 'URL_PROMOTION') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATED_AT') ?>

    <?php // echo $form->field($model, 'PERSISTENT_MENU') ?>

    <?php // echo $form->field($model, 'MESSAGE_GREETING') ?>

    <?php // echo $form->field($model, 'MESSAGE_ERROR') ?>

    <?php // echo $form->field($model, 'MESSAGE_CHECKIN') ?>

    <?php // echo $form->field($model, 'MESSAGE_MEMBER_POINT') ?>

    <?php // echo $form->field($model, 'MESSAGE_MEMBER_NO_POINT') ?>

    <?php // echo $form->field($model, 'MESSAGE_NO_GIFT_POINT') ?>

    <?php // echo $form->field($model, 'MESSAGE_GET_MENU') ?>

    <?php // echo $form->field($model, 'MESSAGE_TOKEN_ORDER') ?>

    <?php // echo $form->field($model, 'MESSAGE_ORDER_ONLINE') ?>

    <?php // echo $form->field($model, 'MESSAGE_BOOKING_ONLINE') ?>

    <?php // echo $form->field($model, 'MESSAGE_REQUIED_RATE') ?>

    <?php // echo $form->field($model, 'MESSAGE_REQUIED_REGISTER') ?>

    <?php // echo $form->field($model, 'MESSAGE_REGISTER_SUCCESS') ?>

    <?php // echo $form->field($model, 'MESSAGE_NO_DAILY_VOUCHER') ?>

    <?php // echo $form->field($model, 'MESSAGE_MISS_DAILY_VOUCHER') ?>

    <?php // echo $form->field($model, 'MESSAGE_SENT_DAILY_VOUCHER') ?>

    <?php // echo $form->field($model, 'MESSAGE_LIMIT_DAILY_VOUCHER') ?>

    <?php // echo $form->field($model, 'SUB_TITLE_HOTLINE') ?>

    <?php // echo $form->field($model, 'SUB_TITLE_PROMOTION') ?>

    <?php // echo $form->field($model, 'SUB_TITLE_POLICY_POINT') ?>

    <?php // echo $form->field($model, 'MESSAGE_GET_POS') ?>

    <?php // echo $form->field($model, 'AUTO_REPLY_MENU') ?>

    <?php // echo $form->field($model, 'STATUS_BOTCHAT') ?>

    <?php // echo $form->field($model, 'JSON_FUNCTION') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
