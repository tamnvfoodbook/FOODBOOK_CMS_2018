<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmPosStatsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-pos-stats-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'POS_ID') ?>

    <?= $form->field($model, 'POS_PARENT') ?>

    <?= $form->field($model, 'CREATED_AT') ?>

    <?= $form->field($model, 'SUM_USER_CHECKIN') ?>

    <?php // echo $form->field($model, 'SUM_USER_ORDER_ONLINE') ?>

    <?php // echo $form->field($model, 'SUM_PRICE_ONLINE') ?>

    <?php // echo $form->field($model, 'SUM_USER_ORDER_OFF') ?>

    <?php // echo $form->field($model, 'SUM_PRICE_OFF') ?>

    <?php // echo $form->field($model, 'SUM_COUPON_USED') ?>

    <?php // echo $form->field($model, 'SUM_COUPON_PRICE') ?>

    <?php // echo $form->field($model, 'SUM_COUPON_AVAILABLE') ?>

    <?php // echo $form->field($model, 'SUM_USER_SHARED_FB') ?>

    <?php // echo $form->field($model, 'SUM_USER_WISHLIST') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
