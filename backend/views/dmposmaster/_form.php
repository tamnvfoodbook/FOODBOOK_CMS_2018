<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
//use backend\assets\AppAsset;
//
//AppAsset::register($this);
//$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/timepicker/bootstrap-timepicker.min.js', ['position' => \yii\web\View::POS_HEAD]);
//
//$this->registerCssFile('css/rating.min.css',['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposmaster */
/* @var $cityMap backend\controllers\DmposmasterController */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmposmaster-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

    <?= $form->field($model, 'POS_MASTER_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'POS_MASTER_NAME_EN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DESCRIPTION')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'ACTIVE')->checkbox() ?>

    <?= $form->field($model, 'FOR_BREAKFAST')->checkbox() ?>

    <?= $form->field($model, 'FOR_LUNCH')->checkbox() ?>

    <?= $form->field($model, 'FOR_DINNER')->checkbox() ?>

    <?= $form->field($model, 'FOR_MIDNIGHT')->checkbox() ?>

    <?= $form->field($model, 'IS_COLLECTION')->checkbox() ?>

    <?= $form->field($model, 'LOAD_BY_LOCATION')->checkbox() ?>


    <?= $form->field($model, 'SORT')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '9',
        'clientOptions' => ['repeat' => 10, 'greedy' => false]
    ]) ?>


    <?= $form->field($model, 'CITY_ID')->widget(Select2::classname(), [
        'data' => $cityMap,
        'options' => ['placeholder' => 'Chọn thành phố'],
    ])
    ?>


    <?= $form->field($model, 'TIME_START')->textInput([
        'maxlength' => true,
        'class' => 'form-control timepicker',
    ]) ?>



    <?= $form->field($model, 'DAY_ON')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

