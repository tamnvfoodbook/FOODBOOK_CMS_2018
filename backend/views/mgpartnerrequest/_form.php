<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Mgpartnerrequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mgpartnerrequest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'partner_name') ?>

    <?= $form->field($model, 'request_at') ?>

    <?= $form->field($model, 'response_at') ?>

    <?= $form->field($model, 'request_data') ?>

    <?= $form->field($model, 'response_data') ?>

    <?= $form->field($model, 'has_exception') ?>

    <?= $form->field($model, 'tag') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
