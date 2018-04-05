<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmposmasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmposmaster-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'POS_MASTER_NAME') ?>

    <?= $form->field($model, 'DESCRIPTION') ?>

    <?= $form->field($model, 'IMAGE_PATH') ?>

    <?= $form->field($model, 'IS_COLLECTION') ?>

    <?php // echo $form->field($model, 'ACTIVE') ?>

    <?php // echo $form->field($model, 'FOR_BREAKFAST') ?>

    <?php // echo $form->field($model, 'FOR_LUNCH') ?>

    <?php // echo $form->field($model, 'FOR_DINNER') ?>

    <?php // echo $form->field($model, 'FOR_MIDNIGHT') ?>

    <?php // echo $form->field($model, 'SORT') ?>

    <?php // echo $form->field($model, 'CITY_ID') ?>

    <?php // echo $form->field($model, 'TIME_START') ?>

    <?php // echo $form->field($model, 'DAY_ON') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
