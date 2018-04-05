<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MgsalemanagerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mgsalemanager-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, '_id') ?>

    <?= $form->field($model, 'pos_name') ?>

    <?= $form->field($model, 'pos_type') ?>

    <?= $form->field($model, 'channels') ?>

    <?= $form->field($model, 'pos_parent') ?>

    <?php // echo $form->field($model, 'pos_id') ?>

    <?php // echo $form->field($model, 'tran_id') ?>

    <?php // echo $form->field($model, 'tran_date') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'discount_extra') ?>

    <?php // echo $form->field($model, 'discount_extra_amount') ?>

    <?php // echo $form->field($model, 'service_charge') ?>

    <?php // echo $form->field($model, 'service_charge_amount') ?>

    <?php // echo $form->field($model, 'coupon_amount') ?>

    <?php // echo $form->field($model, 'coupon_code') ?>

    <?php // echo $form->field($model, 'ship_fee_amount') ?>

    <?php // echo $form->field($model, 'discount_amount_on_item') ?>

    <?php // echo $form->field($model, 'original_amount') ?>

    <?php // echo $form->field($model, 'vat_amount') ?>

    <?php // echo $form->field($model, 'bill_amount') ?>

    <?php // echo $form->field($model, 'total_amount') ?>

    <?php // echo $form->field($model, 'membership_name') ?>

    <?php // echo $form->field($model, 'membership_id') ?>

    <?php // echo $form->field($model, 'sale_note') ?>

    <?php // echo $form->field($model, 'tran_no') ?>

    <?php // echo $form->field($model, 'sale_type') ?>

    <?php // echo $form->field($model, 'hour') ?>

    <?php // echo $form->field($model, 'pos_city') ?>

    <?php // echo $form->field($model, 'pos_district') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
