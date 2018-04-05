<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderrateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orderrate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, '_id') ?>

    <?= $form->field($model, 'pos_id') ?>

    <?= $form->field($model, 'pos_parent') ?>

    <?= $form->field($model, 'dmShift') ?>

    <?= $form->field($model, 'member_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'score') ?>

    <?php // echo $form->field($model, 'reson_bad_food') ?>

    <?php // echo $form->field($model, 'reson_expensive_price') ?>

    <?php // echo $form->field($model, 'reson_bad_service') ?>

    <?php // echo $form->field($model, 'reson_bad_shipper') ?>

    <?php // echo $form->field($model, 'reson_other') ?>

    <?php // echo $form->field($model, 'reson_note') ?>

    <?php // echo $form->field($model, 'published') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
