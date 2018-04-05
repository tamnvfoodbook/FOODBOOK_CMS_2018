<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Membershiplog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="membershiplog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'className') ?>

    <?= $form->field($model, 'Pos_Id') ?>

    <?= $form->field($model, 'User_Id') ?>

    <?= $form->field($model, 'Pr_Key') ?>

    <?= $form->field($model, 'Membership_Log_Type') ?>

    <?= $form->field($model, 'Amount') ?>

    <?= $form->field($model, 'Point') ?>

    <?= $form->field($model, 'Membership_Log_Date') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
