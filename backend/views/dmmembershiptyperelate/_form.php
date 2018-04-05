<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmmembershiptyperelate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmmembershiptyperelate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MEMBERSHIP_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'POS_PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MEMBERSHIP_TYPE_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'DOB')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
