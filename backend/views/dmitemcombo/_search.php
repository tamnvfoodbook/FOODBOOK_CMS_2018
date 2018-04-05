<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmitemcomboSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmitemcombo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'POS_ID') ?>

    <?= $form->field($model, 'ITEM_ID') ?>

    <?= $form->field($model, 'COMBO_ITEM_ID_LIST') ?>

    <?= $form->field($model, 'QUANTITY') ?>

    <?php // echo $form->field($model, 'TA_PRICE') ?>

    <?php // echo $form->field($model, 'OTS_PRICE') ?>

    <?php // echo $form->field($model, 'TA_DISCOUNT') ?>

    <?php // echo $form->field($model, 'OTS_DISCOUNT') ?>

    <?php // echo $form->field($model, 'SORT') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
