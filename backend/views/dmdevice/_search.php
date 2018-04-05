<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmdeviceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmdevice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'DEVICE_ID') ?>

    <?= $form->field($model, 'DEVICE_TYPE') ?>

    <?= $form->field($model, 'PUSH_ID') ?>

    <?= $form->field($model, 'MSISDN') ?>

    <?php // echo $form->field($model, 'LAST_UPDATED') ?>

    <?php // echo $form->field($model, 'ACTIVE') ?>

    <?php // echo $form->field($model, 'VERSION') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'MODEL') ?>

    <?php // echo $form->field($model, 'LANGUAGE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
