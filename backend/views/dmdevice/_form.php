<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmdevice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmdevice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'DEVICE_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DEVICE_TYPE')->textInput() ?>

    <?= $form->field($model, 'PUSH_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MSISDN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LAST_UPDATED')->textInput() ?>

    <?= $form->field($model, 'ACTIVE')->textInput() ?>

    <?= $form->field($model, 'VERSION')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'MODEL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LANGUAGE')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
