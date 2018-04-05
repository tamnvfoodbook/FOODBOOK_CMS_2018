<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Orderrate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orderrate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pos_id') ?>

    <?= $form->field($model, 'pos_parent') ?>

    <?= $form->field($model, 'dmShift') ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'score') ?>

    <?= $form->field($model, 'reson_bad_food') ?>

    <?= $form->field($model, 'reson_expensive_price') ?>

    <?= $form->field($model, 'reson_bad_service') ?>

    <?= $form->field($model, 'reson_bad_shipper') ?>

    <?= $form->field($model, 'reson_other') ?>

    <?= $form->field($model, 'reson_note') ?>

    <?= $form->field($model, 'published') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
