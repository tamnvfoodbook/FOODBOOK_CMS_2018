<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CampaignSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campaign-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, '_id') ?>

    <?= $form->field($model, 'Pos_Id') ?>

    <?= $form->field($model, 'City_Id') ?>

    <?= $form->field($model, 'Campaign_Name') ?>

    <?= $form->field($model, 'Campaign_Created_At') ?>

    <?php // echo $form->field($model, 'Campaign_Start') ?>

    <?php // echo $form->field($model, 'Campaign_End') ?>

    <?php // echo $form->field($model, 'Coupon_Id') ?>

    <?php // echo $form->field($model, 'Item_Id_List') ?>

    <?php // echo $form->field($model, 'Active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
