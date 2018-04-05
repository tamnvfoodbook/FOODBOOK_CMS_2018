<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Bookingonlinelog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bookingonlinelog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Foodbook_Code') ?>

    <?= $form->field($model, 'Pos_Id') ?>

    <?= $form->field($model, 'Pos_Workstation') ?>

    <?= $form->field($model, 'User_Id') ?>

    <?= $form->field($model, 'Book_Date') ?>

    <?= $form->field($model, 'Hour') ?>

    <?= $form->field($model, 'Minute') ?>

    <?= $form->field($model, 'Number_People') ?>

    <?= $form->field($model, 'Note') ?>

    <?= $form->field($model, 'Status') ?>

    <?= $form->field($model, 'Created_At') ?>

    <?= $form->field($model, 'Updated_At') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
