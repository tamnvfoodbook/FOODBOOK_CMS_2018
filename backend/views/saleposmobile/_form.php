<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Saleposmobile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="saleposmobile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pos_id') ?>

    <?= $form->field($model, 'pr_key') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'ticket_name') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'time_update') ?>

    <?= $form->field($model, 'date_time') ?>

    <?= $form->field($model, 'trans_type') ?>

    <?= $form->field($model, 'data_sale_detail') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
