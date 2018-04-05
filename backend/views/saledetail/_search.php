<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SALEDETAILSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="saledetail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, '_id') ?>

    <?= $form->field($model, 'Pos_Id') ?>

    <?= $form->field($model, 'Pos_Parent') ?>

    <?= $form->field($model, 'Fr_Key') ?>

    <?= $form->field($model, 'Amount') ?>

    <?php // echo $form->field($model, 'Price_Sale') ?>

    <?php // echo $form->field($model, 'Tran_Id') ?>

    <?php // echo $form->field($model, 'Created_At') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
