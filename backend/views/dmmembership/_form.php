<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmmembership */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmmembership-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MEMBER_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MEMBER_IMAGE_PATH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ACTIVE')->textInput() ?>

    <?= $form->field($model, 'HASH_PASSWORD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FACEBOOK_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PHONE_NUMBER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'LAST_UPDATED')->textInput() ?>

    <?= $form->field($model, 'MY_STATUS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BIRTHDAY')->textInput() ?>

    <?= $form->field($model, 'CREATED_BY')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
