<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmfacebookpageconfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmfacebookpageconfig-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TITLE')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
