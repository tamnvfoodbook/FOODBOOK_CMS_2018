<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CouponlogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="couponlog-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, '_id') ?>

    <?= $form->field($model, 'className') ?>

    <?= $form->field($model, 'Pos_Id') ?>

    <?= $form->field($model, 'Pos_Parent') ?>

    <?= $form->field($model, 'User_Id') ?>

    <?php // echo $form->field($model, 'Coupon_Id') ?>

    <?php // echo $form->field($model, 'User_Id_Parent') ?>

    <?php // echo $form->field($model, 'Coupon_Name') ?>

    <?php // echo $form->field($model, 'Coupon_Log_Date') ?>

    <?php // echo $form->field($model, 'Coupon_Log_Start') ?>

    <?php // echo $form->field($model, 'Coupon_Log_End') ?>

    <?php // echo $form->field($model, 'Denominations') ?>

    <?php // echo $form->field($model, 'Share_Quantity') ?>

    <?php // echo $form->field($model, 'Type') ?>

    <?php // echo $form->field($model, 'Active') ?>

    <?php // echo $form->field($model, 'Pr_Key') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
