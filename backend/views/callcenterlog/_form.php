<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Callcenterlog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="callcenterlog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cid_name') ?>

    <?= $form->field($model, 'source') ?>

    <?= $form->field($model, 'destination') ?>

    <?= $form->field($model, 'recording') ?>

    <?= $form->field($model, 'start') ?>

    <?= $form->field($model, 'tta') ?>

    <?= $form->field($model, 'duration') ?>

    <?= $form->field($model, 'pdd') ?>

    <?= $form->field($model, 'mos') ?>

    <?= $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
