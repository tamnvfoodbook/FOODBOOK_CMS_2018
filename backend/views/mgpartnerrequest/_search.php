<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MgpartnerrequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mgpartnerrequest-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, '_id') ?>

    <?= $form->field($model, 'partner_name') ?>

    <?= $form->field($model, 'request_at') ?>

    <?= $form->field($model, 'response_at') ?>

    <?= $form->field($model, 'request_data') ?>

    <?php // echo $form->field($model, 'response_data') ?>

    <?php // echo $form->field($model, 'has_exception') ?>

    <?php // echo $form->field($model, 'tag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
