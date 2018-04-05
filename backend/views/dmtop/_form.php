<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vendor\datepick\src;

/* @var $this yii\web\View */
/* @var $model backend\models\DmPosStats */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-pos-stats-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

    <?= $form->field($model, 'POS_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'POS_PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->widget(
    DatePicker::className(), [
            // inline too, not bad
             'inline' => true, 
             // modify template for custom rendering
            'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'dd-M-yyyy'
            ]
    ]);?>

    <?= $form->field($model, 'SUM_USER_CHECKIN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SUM_USER_ORDER_ONLINE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SUM_PRICE_ONLINE')->textInput() ?>

    <?= $form->field($model, 'SUM_USER_ORDER_OFF')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SUM_PRICE_OFF')->textInput() ?>

    <?= $form->field($model, 'SUM_COUPON_USED')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SUM_COUPON_PRICE')->textInput() ?>

    <?= $form->field($model, 'SUM_COUPON_AVAILABLE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SUM_USER_SHARED_FB')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SUM_USER_WISHLIST')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
