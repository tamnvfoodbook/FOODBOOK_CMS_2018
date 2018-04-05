<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmitemcombo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmitemcombo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'POS_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'COMBO_ITEM_ID_LIST')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QUANTITY')->textInput() ?>

    <?= $form->field($model, 'TA_PRICE')->textInput() ?>

    <?= $form->field($model, 'OTS_PRICE')->textInput() ?>

    <?= $form->field($model, 'TA_DISCOUNT')->textInput() ?>

    <?= $form->field($model, 'OTS_DISCOUNT')->textInput() ?>

    <?= $form->field($model, 'SORT')->textInput() ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
