<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmquerylog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmquerylog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'ACTION_QUERY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TABLE_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DATA_OLD')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'DATA_NEW')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'USER_MANAGER_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USER_MANAGER_NAME')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
