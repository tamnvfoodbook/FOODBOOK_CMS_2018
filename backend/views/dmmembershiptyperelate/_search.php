<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmmembershiptyperelateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmmembershiptyperelate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'MEMBERSHIP_ID') ?>

    <?= $form->field($model, 'POS_PARENT') ?>

    <?= $form->field($model, 'MEMBERSHIP_TYPE_ID') ?>

    <?= $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'DOB') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
