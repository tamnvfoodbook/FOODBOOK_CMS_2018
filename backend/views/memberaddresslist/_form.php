<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberaddresslist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="memberaddresslist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'alias_name') ?>

    <?= $form->field($model, 'extend_address') ?>

    <?= $form->field($model, 'full_address') ?>

    <?= $form->field($model, 'city_id') ?>

    <?= $form->field($model, 'district_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'longitude') ?>

    <?= $form->field($model, 'latitude') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
