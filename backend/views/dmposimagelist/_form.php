<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposimagelist */
/* @var $form yii\widgets\ActiveForm */
/* @var $allPosMap backend\controllers\DmposimagelistController  */
?>

<div class="dmposimagelist-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

    <?=
        $form->field($model, 'POS_ID')->widget(Select2::classname(), [
            'data' => $allPosMap,
            'language' => 'en',
            'value' => $model->POS_ID,
            'options' => ['placeholder' => 'Chọn nhà hàng ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => 6]) ?>


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
                    'maxFileSize'=>200
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
                    'maxFileSize'=>200
                ],
            'options' =>
                ['accept' => 'image/*'],
        ]);
    }
    ?>

    <?= $form->field($model, 'ACTIVE')->dropDownList([1 => 'Active',0=>'Deactive'], ['prompt'=>'Chọn trạng thái']) ?>

    <?= $form->field($model, 'SORT')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '9',
        'clientOptions' => ['repeat' => 10, 'greedy' => false]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
