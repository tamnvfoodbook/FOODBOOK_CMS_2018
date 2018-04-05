<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\date\DatePicker;
use kartik\widgets\Select2;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmpolicyimage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmpolicyimage-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>
    <div class="row">
        <div class="col-lg-6">

            <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => '6']) ?>

            <?= $form->field($model, 'DESCRIPTION_URL')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'SORT')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9',
                'clientOptions' => ['repeat' => 10, 'greedy' => false]
            ]);
            ?>

            <?php
                if(!$model->DATE_START){
                    $model->DATE_START = date('d-m-Y');
                }
                if(!$model->DATE_END){
                    $model->DATE_END = date('d-m-Y', strtotime('+1 month'));
                }

                echo '<label class="control-label">Thời gian áp dụng</label>';
                echo DatePicker::widget([
                    'name' => 'Dmpolicyimage[DATE_START]',
                    'value' => date('d-m-Y',strtotime($model->DATE_START)),
                    'type' => DatePicker::TYPE_RANGE,
                    'name2' => 'Dmpolicyimage[DATE_END]',
                    'value2' => date('d-m-Y',strtotime($model->DATE_END)),
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose'=>true
                    ]
                ]);
            ?>
            <?= $form->field($model, 'CITY_ID')->widget(Select2::classname(), [
                'data' => $cityMap,
                'options' => ['placeholder' => 'Chọn thành phố ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]);
            ?>
            <?= $form->field($model, 'LIST_POS_PARENT')->widget(Select2::classname(), [
                'data' => $posparentMap,
                'options' => ['placeholder' => 'Chọn thương hiệu ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true

                ],
            ]);
            ?>
            <?= $form->field($model, 'ACTIVE')->dropDownList(['0' => 'Deactive','1' => 'Active']); ?>
        </div>
        <div class="col-lg-6">
            <?php
            if($model->IMAGE_LINK){
                echo Html::hiddenInput('IMAGE_LINK-old',$model->IMAGE_LINK);
                echo $form->field($model, 'IMAGE_LINK')->widget(FileInput::classname(), [
                    'pluginOptions' =>
                        [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' =>  'Select Photo',
                            'initialPreview'=>[
                                Html::img("$model->IMAGE_LINK", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                            ],
                            'maxFileSize'=>660
                        ],
                    'options' =>
                        ['accept' => 'image/*'],
                ]);
            }else{
                echo $form->field($model, 'IMAGE_LINK')->widget(FileInput::classname(), [
                    'pluginOptions' =>
                        [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' =>  'Select Photo',
                            'maxFileSize'=>660
                        ],
                    'options' =>
                        ['accept' => 'image/*'],
                ]);
            }
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
