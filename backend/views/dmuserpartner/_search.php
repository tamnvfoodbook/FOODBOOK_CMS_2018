<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmuserpartnerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmuserpartner-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'PARTNER_NAME') ?>

    <?= $form->field($model, 'AUTH_KEY') ?>

    <?= $form->field($model, 'ACCESS_TOKEN') ?>

    <?= $form->field($model, 'ACTIVE') ?>

    <?php // echo $form->field($model, 'IS_SEND_SMS') ?>

    <?php // echo $form->field($model, 'LIST_POS_PARENT') ?>

    <?php // echo $form->field($model, 'BRAND_NAME') ?>

    <?php // echo $form->field($model, 'SMS_PARTNER') ?>

    <?php // echo $form->field($model, 'API_KEY') ?>

    <?php // echo $form->field($model, 'SECRET_KEY') ?>

    <?php // echo $form->field($model, 'RESPONSE_URL') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
