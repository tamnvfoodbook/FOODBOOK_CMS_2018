<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposparentpolicy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmposparentpolicy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'POS_PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'EXCHANGE_POINT')->textInput() ?>

    <?= $form->field($model, 'DESCRIPTION')->textArea(['rows' => '6'])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Sửa', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
