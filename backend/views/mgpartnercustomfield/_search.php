<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MgpartnercustomfieldSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mgpartnercustomfield-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, '_id') ?>

    <?= $form->field($model, 'partner_id') ?>

    <?= $form->field($model, 'partner_name') ?>

    <?= $form->field($model, 'pos_id') ?>

    <?= $form->field($model, 'pos_parent') ?>

    <?php // echo $form->field($model, 'pos_name') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'time_delivery') ?>

    <?php // echo $form->field($model, 'image_url') ?>

    <?php // echo $form->field($model, 'image_thumb_url') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
