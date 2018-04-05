<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmmembershiptype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmmembershiptype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'POS_PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MEMBERSHIP_TYPE_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MEMBERSHIP_TYPE_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ACTIVE')->textInput() ?>

    <?= $form->field($model, 'MEMBERSHIP_TYPE_IMAGE')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
