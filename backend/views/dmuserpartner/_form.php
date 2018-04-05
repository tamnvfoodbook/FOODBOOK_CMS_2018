<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmuserpartner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmuserpartner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PARTNER_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BRAND_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LIST_POS_PARENT')->widget(Select2::classname(), [
        'data' => $posParentMap,
        'options' => ['placeholder' => 'Chọn thương hiệu ...','multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'SECRET_KEY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'API_KEY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SMS_PARTNER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IS_SEND_SMS')->dropDownList(['0' => 'Không', '1' => 'Có']) ?>

    <?= $form->field($model, 'RESPONSE_URL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ACTIVE')->dropDownList(['0' => 'Không', '1' => 'Có'])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
