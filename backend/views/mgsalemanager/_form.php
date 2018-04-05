<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Mgsalemanager */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mgsalemanager-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pos_name') ?>

    <?= $form->field($model, 'pos_type') ?>

    <?= $form->field($model, 'channels') ?>

    <?= $form->field($model, 'pos_parent') ?>

    <?= $form->field($model, 'pos_id') ?>

    <?= $form->field($model, 'tran_id') ?>

    <?= $form->field($model, 'tran_date') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'discount_extra') ?>

    <?= $form->field($model, 'discount_extra_amount') ?>

    <?= $form->field($model, 'service_charge') ?>

    <?= $form->field($model, 'service_charge_amount') ?>

    <?= $form->field($model, 'coupon_amount') ?>

    <?= $form->field($model, 'coupon_code') ?>

    <?= $form->field($model, 'ship_fee_amount') ?>

    <?= $form->field($model, 'discount_amount_on_item') ?>

    <?= $form->field($model, 'original_amount') ?>

    <?= $form->field($model, 'vat_amount') ?>

    <?= $form->field($model, 'bill_amount') ?>

    <?= $form->field($model, 'total_amount') ?>

    <?= $form->field($model, 'membership_name') ?>

    <?= $form->field($model, 'membership_id') ?>

    <?= $form->field($model, 'sale_note') ?>

    <?= $form->field($model, 'tran_no') ?>

    <?= $form->field($model, 'sale_type') ?>

    <?= $form->field($model, 'hour') ?>

    <?= $form->field($model, 'pos_city') ?>

    <?= $form->field($model, 'pos_district') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
