<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmnoticeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmnotice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TITLE') ?>

    <?= $form->field($model, 'CONTENT') ?>

    <?= $form->field($model, 'CREATED_BY') ?>

    <?= $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'FULL_CONTENT_URL') ?>

    <?php // echo $form->field($model, 'IS_ALL_POS') ?>

    <?php // echo $form->field($model, 'POS_PARENT') ?>

    <?php // echo $form->field($model, 'LIST_POS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
