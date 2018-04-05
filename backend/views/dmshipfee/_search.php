<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmshipfeeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmshipfee-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'POS_ID') ?>

    <?= $form->field($model, 'FROM_KM') ?>

    <?= $form->field($model, 'TO_KM') ?>

    <?= $form->field($model, 'FROM_AMOUNT') ?>

    <?php // echo $form->field($model, 'TO_AMOUNT') ?>

    <?php // echo $form->field($model, 'FEE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
