<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmcity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmcity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID')->textInput() ?>

    <?= $form->field($model, 'CITY_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SORT')->textInput() ?>

    <?= $form->field($model, 'ACTIVE')->dropDownList([1 => 'Active',0=>'Deactive'], ['prompt'=>'Chọn trạng thái']
    ) ?>

    <?= $form->field($model, 'LONGITUDE')->textInput() ?>

    <?= $form->field($model, 'LATITUDE')->textInput() ?>

    <?= $form->field($model, 'GG_LOCALITY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AM_LOCALITY')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
