<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmitemtypemaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmitemtypemaster-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

    <?= $form->field($model, 'ITEM_TYPE_MASTER_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DESCRIPTION')->textInput(['maxlength' => true,'value'=> 'Trạng thái đang được cập nhật...']) ?>

    <?= $form->field($model, 'SORT')->textInput() ?>

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

    <?php ActiveForm::end(); ?>

</div>
