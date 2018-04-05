<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmconfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmconfig-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'KEYGROUP') ?>

    <?= $form->field($model, 'SORT') ?>

    <?= $form->field($model, 'KEYWORD') ?>

    <?= $form->field($model, 'VALUES') ?>

    <?php // echo $form->field($model, 'DESC') ?>

    <?php // echo $form->field($model, 'ACTIVE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
