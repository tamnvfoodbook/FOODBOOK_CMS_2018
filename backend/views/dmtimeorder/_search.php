<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmtimeorderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmtimeorder-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'POS_ID') ?>

    <?= $form->field($model, 'TYPE') ?>

    <?= $form->field($model, 'DAY_OF_WEEK') ?>

    <?= $form->field($model, 'TIME_START') ?>

    <?php // echo $form->field($model, 'TIME_END') ?>

    <?php // echo $form->field($model, 'DAY_OFF') ?>

    <?php // echo $form->field($model, 'ACTIVE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
