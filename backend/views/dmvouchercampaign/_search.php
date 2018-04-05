<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmvouchercampaignSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmvouchercampaign-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'VOUCHER_NAME') ?>

    <?= $form->field($model, 'VOUCHER_DESCRIPTION') ?>

    <?= $form->field($model, 'CITY_ID') ?>

    <?= $form->field($model, 'POS_PARENT') ?>

    <?php // echo $form->field($model, 'POS_ID') ?>

    <?php // echo $form->field($model, 'QUANTITY_PER_DAY') ?>

    <?php // echo $form->field($model, 'DATE_CREATED') ?>

    <?php // echo $form->field($model, 'DATE_UPDATED') ?>

    <?php // echo $form->field($model, 'DATE_START') ?>

    <?php // echo $form->field($model, 'DATE_END') ?>

    <?php // echo $form->field($model, 'TIME_HOUR_DAY') ?>

    <?php // echo $form->field($model, 'TIME_DATE_WEEK') ?>

    <?php // echo $form->field($model, 'AMOUNT_ORDER_OVER') ?>

    <?php // echo $form->field($model, 'DISCOUNT_TYPE') ?>

    <?php // echo $form->field($model, 'DISCOUNT_AMOUNT') ?>

    <?php // echo $form->field($model, 'DISCOUNT_EXTRA') ?>

    <?php // echo $form->field($model, 'IS_ALL_ITEM') ?>

    <?php // echo $form->field($model, 'ITEM_TYPE_ID_LIST') ?>

    <?php // echo $form->field($model, 'ACTIVE') ?>

    <?php // echo $form->field($model, 'MANAGER_ID') ?>

    <?php // echo $form->field($model, 'MANAGER_NAME') ?>

    <?php // echo $form->field($model, 'AFFILIATE_ID') ?>

    <?php // echo $form->field($model, 'AFFILIATE_DISCOUNT_TYPE') ?>

    <?php // echo $form->field($model, 'AFFILIATE_DISCOUNT_AMOUNT') ?>

    <?php // echo $form->field($model, 'AFFILIATE_DISCOUNT_EXTRA') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
