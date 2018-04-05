<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Mgitemchanged */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mgitemchanged-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pos_parent') ?>

    <?= $form->field($model, 'pos_id') ?>

    <?= $form->field($model, 'last_changed') ?>

    <?= $form->field($model, 'reversion') ?>

    <?= $form->field($model, 'changed') ?>

    <?= $form->field($model, 'last_broadcast') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
