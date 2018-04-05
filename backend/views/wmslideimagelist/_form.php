<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Wmitemimagelist */
/* @var $form yii\widgets\ActiveForm */

//echo '<pre>';
//var_dump($model->isNewRecord);
//echo '</pre>';
//die();
?>

<div class="wmitemimagelist-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>
    <div class="col-md-6">
        <?php
        if($model->isNewRecord === TRUE){
            echo $form->field($model, 'POS_ID')->widget(Select2::classname(), [
                'data' => $allPosMap,
                'options' => [
                    'placeholder' => 'Chọn nhà hàng...',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        }
        ?>

        <?= $form->field($model, 'DESCRIPTION')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'ACTIVE')->dropDownList(['1'=> 'ACTIVE','0'=> 'DEACTIVE']) ?>

        <?= $form->field($model, 'SORT')->textInput() ?>

    </div>
    <div class="col-md-6">

        <?php
        if($model->IMAGE_PATH){
            echo Html::hiddenInput('image-old',$model->IMAGE_PATH);
            echo $form->field($model, 'IMAGE_PATH')->widget(FileInput::classname(), [
                'pluginOptions' =>
                    [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Select Photo',
                        'initialPreview'=>[
                            Html::img("$model->IMAGE_PATH", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                        ],
                        'maxFileSize'=>60
                    ],
                'options' =>
                    ['accept' => 'image/*'],
            ]);
        }else{
            echo $form->field($model, 'IMAGE_PATH')->widget(FileInput::classname(), [
                'pluginOptions' =>
                    [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Select Photo',
                        'maxFileSize'=>60
                    ],
                'options' =>
                    ['accept' => 'image/*'],
            ]);
        }
        ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

