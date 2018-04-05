<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\date\DatePicker;
use yii\widgets\MaskedInput;


/* @var $this yii\web\View */
/* @var $model backend\models\COUPON */
/* @var $form yii\widgets\ActiveForm */

date_default_timezone_set('Asia/Bangkok');


?>

<div class="coupon-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'Coupon_Name') ?>
    <?php
//    $model->Coupon_Log_Date = $dateCreat;// better put it on controller
//    $form->field($model, 'Coupon_Log_Date')->hiddenInput()->label(false);
//    echo '<label class="control-label">Ngày tạo</label>';
//    echo DatePicker::widget([
//        'name' => 'dp_2',
//        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
//        'value' => date('d-m-Y', strtotime('+2 days')),
//        'pluginOptions' => [
//            'autoclose'=>true,
//            'format' => 'dd-m-yyyy'
//        ]
//    ]);

//    echo $form->field($model, 'Denominations', [
//        'addon' => ['append' => ['content'=>'.00']],
//    ]);

    ?>
    <?= $form->field($model, 'Denominations')->widget(MaskedInput::className(), [
        'mask' => '9',
        'clientOptions' => ['repeat' => 10, 'greedy' => false]
    ]) ?>

    <?php
        if(isset($model->Coupon_Log_Date)){
            $dateCreat = date(Yii::$app->params['DATE_FORMAT'],$model->Coupon_Log_Date->sec);
            echo '<label class="control-label">Ngày tạo</label>';
            echo Html::input('text','',$dateCreat,['class'=>'form-control','readonly' => true]);
        }
    ?>

    <?= $form->field($model, 'Active')->radioList(['1'=>'Active', '0'=>'Deactive']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
