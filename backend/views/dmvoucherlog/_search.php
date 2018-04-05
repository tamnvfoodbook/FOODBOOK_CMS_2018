<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmvoucherlogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmvoucherlog-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'VOUCHER_CODE') ?>

    <?= $form->field($model, 'VOUCHER_CAMPAIGN_ID') ?>

    <?= $form->field($model, 'VOUCHER_CAMPAIGN_NAME') ?>

    <?= $form->field($model, 'VOUCHER_DESCRIPTION') ?>

    <?= $form->field($model, 'POS_PARENT') ?>

    <?php // echo $form->field($model, 'POS_ID') ?>

    <?php // echo $form->field($model, 'DATE_CREATED') ?>

    <?php // echo $form->field($model, 'DATE_START') ?>

    <?php // echo $form->field($model, 'DATE_END') ?>

    <?php // echo $form->field($model, 'DATE_HASH') ?>

    <?php // echo $form->field($model, 'AMOUNT_ORDER_OVER') ?>

    <?php // echo $form->field($model, 'DISCOUNT_TYPE') ?>

    <?php // echo $form->field($model, 'DISCOUNT_AMOUNT') ?>

    <?php // echo $form->field($model, 'DISCOUNT_EXTRA') ?>

    <?php // echo $form->field($model, 'IS_ALL_ITEM') ?>

    <?php // echo $form->field($model, 'ITEM_TYPE_ID_LIST') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'BUYER_INFO') ?>

    <?php // echo $form->field($model, 'AFFILIATE_ID') ?>

    <?php // echo $form->field($model, 'AFFILIATE_DISCOUNT_TYPE') ?>

    <?php // echo $form->field($model, 'AFFILIATE_DISCOUNT_AMOUNT') ?>

    <?php // echo $form->field($model, 'AFFILIATE_DISCOUNT_EXTRA') ?>

    <?php // echo $form->field($model, 'AFFILIATE_USED_TOTAL_AMOUNT') ?>

    <?php // echo $form->field($model, 'USED_DATE') ?>

    <?php // echo $form->field($model, 'USED_DISCOUNT_AMOUNT') ?>

    <?php // echo $form->field($model, 'USED_BILL_AMOUNT') ?>

    <?php // echo $form->field($model, 'USED_MEMBER_INFO') ?>

    <?php // echo $form->field($model, 'USED_POS_ID') ?>

    <?php // echo $form->field($model, 'USED_SALE_TRAN_ID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
