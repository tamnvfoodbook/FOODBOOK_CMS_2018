<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmitemtype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmitemtype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ITEM_TYPE_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_TYPE_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SORT')->textInput() ?>

    <?= $form->field($model, 'MIN_ITEM_CHOICE')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '9',
        'clientOptions' => ['repeat' => 10, 'greedy' => false]
    ]) ?>
    <?= $form->field($model, 'MAX_ITEM_CHOICE')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '9',
        'clientOptions' => ['repeat' => 10, 'greedy' => false]
    ]) ?>

    <?= $form->field($model, 'ACTIVE')->dropDownList([0 => "Deactive", 1 => "Active"]) ?>
    <?php
    if($model->isNewRecord){
                echo $form->field($model, 'POS_ID')->widget(Select2::classname(), [
                    'data' => $allPosMap,
                    'options' => [
                        'id'=>'pos-id',
                        'placeholder' => 'Chọn nhà hàng...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);

                echo $form->field($model, 'ITEM_LIST')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'options' => [
                            'multiple' => true,
                        ],
                        'pluginOptions'=>[
                            'depends'=>['pos-id'],
                            'placeholder'=>'Select...',
                            'url'=>Url::to(['/dmitemtype/subcat'])
                        ]
                    ]);

                /*echo $form->field($model, 'ITEM_LIST')->widget(Select2::classname(), [
                    'options' => [
                        'placeholder' => 'Chọn nhà hàng...',
                    ],
                    'pluginOptions' => [
                        'depends'=>['pos-id'],
                        'allowClear' => true,
                        'url'=>Url::to(['/dmitemtype/subcat'])
                    ],
                ]);*/
            }

            /*echo $form->field($model, 'ITEM_LIST')->widget(DepDrop::classname(), [
                'pluginOptions'=>[
                    'depends'=>['pos-id'],
                    'placeholder'=>'Select...',
                    'url'=>Url::to(['/dmitemtype/subcat'])
                ]
            ]);*/


    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php
            if(!$model->isNewRecord){
                echo Html::submitButton($model->isNewRecord ? 'Create' : 'Cập nhật và đồng bộ', ['class' => 'btn btn-success','name' => 'btn_for_all', 'value' => 1]);
            }
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
