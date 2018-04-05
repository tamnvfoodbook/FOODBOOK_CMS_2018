<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SALEDETAIL */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="saledetail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Pos_Id') ?>

    <?= $form->field($model, 'Pos_Parent') ?>

    <?= $form->field($model, 'Fr_Key') ?>

    <?= $form->field($model, 'Amount') ?>

    <?= $form->field($model, 'Price_Sale') ?>

    <?= $form->field($model, 'Tran_Id') ?>

    <?= $form->field($model, 'Created_At') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
