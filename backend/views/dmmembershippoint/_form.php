<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmmembershippoint */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmmembershippoint-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'POINT')->textInput() ?>

   <!--
   <?/*= $form->field($model, 'MEMBERSHIP_ID')->textInput(['maxlength' => true]) */?>

    <?/*= $form->field($model, 'POS_PARENT')->textInput(['maxlength' => true]) */?>

    <?/*= $form->field($model, 'AMOUNT')->textInput() */?>

   <?/*= $form->field($model, 'EAT_FIRST_DATE')->textInput() */?>

    <?/*= $form->field($model, 'EAT_LAST_DATE')->textInput() */?>

    <?/*= $form->field($model, 'EAT_COUNT')->textInput() */?>

    <?/*= $form->field($model, 'EAT_COUNT_FAIL')->textInput() */?>
    -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
