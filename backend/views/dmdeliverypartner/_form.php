<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmdeliverypartner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmdeliverypartner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'URL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CONFIG_JSON')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ACTIVE')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
