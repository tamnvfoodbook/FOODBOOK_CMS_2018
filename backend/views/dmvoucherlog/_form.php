<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmvoucherlog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmvoucherlog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'VOUCHER_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'VOUCHER_CAMPAIGN_ID')->textInput() ?>

    <?= $form->field($model, 'VOUCHER_CAMPAIGN_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'VOUCHER_DESCRIPTION')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'POS_PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'POS_ID')->textInput() ?>

    <?= $form->field($model, 'DATE_CREATED')->textInput() ?>

    <?= $form->field($model, 'DATE_START')->textInput() ?>

    <?= $form->field($model, 'DATE_END')->textInput() ?>

    <?= $form->field($model, 'DATE_HASH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AMOUNT_ORDER_OVER')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT_TYPE')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT_AMOUNT')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT_EXTRA')->textInput() ?>

    <?= $form->field($model, 'IS_ALL_ITEM')->textInput() ?>

    <?= $form->field($model, 'ITEM_TYPE_ID_LIST')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'BUYER_INFO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AFFILIATE_ID')->textInput() ?>

    <?= $form->field($model, 'AFFILIATE_DISCOUNT_TYPE')->textInput() ?>

    <?= $form->field($model, 'AFFILIATE_DISCOUNT_AMOUNT')->textInput() ?>

    <?= $form->field($model, 'AFFILIATE_DISCOUNT_EXTRA')->textInput() ?>

    <?= $form->field($model, 'AFFILIATE_USED_TOTAL_AMOUNT')->textInput() ?>

    <?= $form->field($model, 'USED_DATE')->textInput() ?>

    <?= $form->field($model, 'USED_DISCOUNT_AMOUNT')->textInput() ?>

    <?= $form->field($model, 'USED_BILL_AMOUNT')->textInput() ?>

    <?= $form->field($model, 'USED_MEMBER_INFO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USED_POS_ID')->textInput() ?>

    <?= $form->field($model, 'USED_SALE_TRAN_ID')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
