<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmcitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmcity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'CITY_NAME') ?>

    <?= $form->field($model, 'SORT') ?>

    <?= $form->field($model, 'ACTIVE') ?>

    <?= $form->field($model, 'LONGITUDE') ?>

    <?php // echo $form->field($model, 'LATITUDE') ?>

    <?php // echo $form->field($model, 'GG_LOCALITY') ?>

    <?php // echo $form->field($model, 'AM_LOCALITY') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
