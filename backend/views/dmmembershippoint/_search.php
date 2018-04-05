<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmmembershippointSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmmembershippoint-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'MEMBERSHIP_ID') ?>

    <?= $form->field($model, 'POS_PARENT') ?>

    <?= $form->field($model, 'AMOUNT') ?>

    <?= $form->field($model, 'POINT') ?>

    <?= $form->field($model, 'EAT_FIRST_DATE') ?>

    <?php // echo $form->field($model, 'EAT_LAST_DATE') ?>

    <?php // echo $form->field($model, 'EAT_COUNT') ?>

    <?php // echo $form->field($model, 'EAT_COUNT_FAIL') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
