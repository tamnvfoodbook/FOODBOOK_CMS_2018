<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmconfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmconfig-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'KEYGROUP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SORT')->textInput() ?>

    <?= $form->field($model, 'KEYWORD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'VALUES')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DESC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ACTIVE')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
