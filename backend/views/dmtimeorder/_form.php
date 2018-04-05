<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\select2\Select2;
//use kartik\field\FieldRange;

use kartik\field\FieldRange;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;



/* @var $this yii\web\View */
/* @var $model backend\models\Dmtimeorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmtimeorder-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'POS_ID')->widget(Select2::classname(), [
        'data' => $allPosMap,
        'language' => 'en',
        'options' => ['placeholder' => 'Chọn POS...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?php
        if($model->DAY_OF_WEEK){
            echo $form->field($model, 'DAY_OF_WEEK')->widget(Select2::classname(), [
                'data' => Yii::$app->params['daysOfWeek'],
                'language' => 'en',
                'options' => ['placeholder' => 'Chọn Ngày...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    //'multiple' => true
                ],
            ]);
        }else{
            echo $form->field($model, 'DAY_OF_WEEK')->widget(Select2::classname(), [
                'data' => Yii::$app->params['daysOfWeek'],
                'language' => 'en',
                'options' => ['placeholder' => 'Chọn Ngày...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true
                ],
            ]);
        }
    ?>

    <?= FieldRange::widget([
                    'form' => $form,
                    'model' => $model,
                    'label' => 'Enter time range',
                    'attribute1' => 'TIME_START',
                    'attribute2' => 'TIME_END',
                    'type' => FieldRange::INPUT_TIME,
                    'widgetOptions1' => [
                        'pluginOptions' => [
                            'showMeridian' => false,
                            'minuteStep' => 30,
                        ]
                    ],
                    'widgetOptions2' => [
                        'pluginOptions' => [
                            'showMeridian' => false,
                            'minuteStep' => 1,
                        ],
                    ],
                    ])
    ?>

    <?= $form->field($model, 'TYPE')->dropDownList(['10'=>'Kiểu ngày','20'=> 'Kiểu tuần'],['class'=>'form-control','prompt' => 'Chọn kiểu']) ?>

    <?=
        $form->field($model, 'DAY_OFF')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Ngày nghỉ ...'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format'=> 'dd/mm'
        ]
    ])
    ?>

    <?= $form->field($model, 'ACTIVE')->dropDownList(['1'=>'Active','0'=> 'Deactive'],['class'=>'form-control','prompt' => 'Chọn trạng thái']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

