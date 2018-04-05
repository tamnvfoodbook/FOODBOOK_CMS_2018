<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmmemberactionlog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmmemberactionlog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SPIN_RESULT')->textInput() ?>

    <?= $form->field($model, 'DESCRIPTION')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'POS_PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LOG_TYPE')->textInput() ?>

    <?= $form->field($model, 'AMOUNT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'VOUCHER_LOG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PAYMENT_METHOD')->textInput() ?>

    <?= $form->field($model, 'RECEIVER_PHONE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BANK_ACCOUNT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATED_AT')->textInput() ?>

    <?= $form->field($model, 'WITHDRAW_STATE')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
