<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmzalopageconfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmzalopageconfig-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PAGE_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'POS_PARENT')->hiddenInput(['value' => Yii::$app->session->get('pos_parent')])->label(false); ?>

    <?= $form->field($model, 'ZALO_OA_KEY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'URL_POINT_POLICY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'URL_PROMOTION')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_ERROR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_TITLE_CHECKIN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_CHECKIN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_MEMBER_POINT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_MEMBER_NO_POINT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_NO_GIFT_POINT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_GET_MENU')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_TOKEN_ORDER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_TITLE_ORDER_ONLINE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_ORDER_ONLINE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_TITLE_BOOKING')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_BOOKING_ONLINE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_TITLE_RATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_REQUIED_RATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_TITLE_REQUIED_REGISTER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_REQUIED_REGISTER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_REGISTER_SUCCESS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_NO_DAILY_VOUCHER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_MISS_DAILY_VOUCHER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_SENT_DAILY_VOUCHER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_LIMIT_DAILY_VOUCHER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_TITLE_LIST_POS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_LIST_POS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_TITLE_MEMBERSHIP_INFO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_TITLE_PROMOTION')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_VIEW_ALL_ARTICLES')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_SHOW_PROMOTION')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MESSAGE_TITLE_GET_MENU')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
