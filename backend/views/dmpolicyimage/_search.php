<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmpolicyimageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmpolicyimage-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'IMAGE_LINK') ?>

    <?= $form->field($model, 'DESCRIPTION') ?>

    <?= $form->field($model, 'DESCRIPTION_URL') ?>

    <?= $form->field($model, 'SORT') ?>

    <?php // echo $form->field($model, 'DATE_CREATED') ?>

    <?php // echo $form->field($model, 'DATE_START') ?>

    <?php // echo $form->field($model, 'DATE_END') ?>

    <?php // echo $form->field($model, 'ACTIVE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
