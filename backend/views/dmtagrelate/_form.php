<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmtagrelate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmtagrelate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TAG_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'POS_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PIORITY')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
