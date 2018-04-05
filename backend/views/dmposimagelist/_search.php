<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmposimagelistSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmposimagelist-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'POS_ID') ?>

    <?= $form->field($model, 'DESCRIPTION') ?>

    <?= $form->field($model, 'IMAGE_PATH') ?>

    <?= $form->field($model, 'ACTIVE') ?>

    <?php // echo $form->field($model, 'SORT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
