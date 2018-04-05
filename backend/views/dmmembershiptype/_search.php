<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmmembershiptypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmmembershiptype-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'POS_PARENT') ?>

    <?= $form->field($model, 'MEMBERSHIP_TYPE_ID') ?>

    <?= $form->field($model, 'MEMBERSHIP_TYPE_NAME') ?>

    <?= $form->field($model, 'ACTIVE') ?>

    <?php // echo $form->field($model, 'MEMBERSHIP_TYPE_IMAGE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
