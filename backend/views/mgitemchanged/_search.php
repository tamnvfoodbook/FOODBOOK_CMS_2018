<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MgitemchangedSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mgitemchanged-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, '_id') ?>

    <?= $form->field($model, 'pos_parent') ?>

    <?= $form->field($model, 'pos_id') ?>

    <?= $form->field($model, 'last_changed') ?>

    <?= $form->field($model, 'reversion') ?>

    <?php // echo $form->field($model, 'changed') ?>

    <?php // echo $form->field($model, 'last_broadcast') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
