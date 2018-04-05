<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmmemberactionlogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmmemberactionlog-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'CREATED_AT') ?>

    <?= $form->field($model, 'USER_ID') ?>

    <?= $form->field($model, 'SPIN_RESULT') ?>

    <?= $form->field($model, 'DESCRIPTION') ?>

    <?php // echo $form->field($model, 'POS_PARENT') ?>

    <?php // echo $form->field($model, 'LOG_TYPE') ?>

    <?php // echo $form->field($model, 'AMOUNT') ?>

    <?php // echo $form->field($model, 'VOUCHER_LOG') ?>

    <?php // echo $form->field($model, 'PAYMENT_METHOD') ?>

    <?php // echo $form->field($model, 'RECEIVER_PHONE') ?>

    <?php // echo $form->field($model, 'BANK_ACCOUNT') ?>

    <?php // echo $form->field($model, 'UPDATED_AT') ?>

    <?php // echo $form->field($model, 'WITHDRAW_STATE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
