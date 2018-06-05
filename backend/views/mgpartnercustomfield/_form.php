<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Mgpartnercustomfield */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mgpartnercustomfield-form">


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>
    <div class="col-md-6">
        <?= $form->field($model, 'partner_id')->widget(Select2::classname(), [
            'data' => $partnerMap,
            'options' => [
                'placeholder' => 'Chọn ...'
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]); ?>

        <?= $form->field($model, 'pos_id')->widget(Select2::classname(), [
            'data' => $allPosMap,
            'options' => [
                'placeholder' => 'Chọn ...'
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]); ?>

        <?= $form->field($model, 'tags')->widget(Select2::classname(), [
            'options' => [
                'placeholder' => 'Chọn ...'
            ],
            'pluginOptions' => [
                'tags' => true,
                'allowClear' => true,
                'multiple' => true
            ],
        ]); ?>
        <?= $form->field($model, 'active')->dropDownList([0 => 'Deactive', 1 => "Active"]) ?>
    </div>

    <div class="col-md-6">

        <?php
        if($model->image_url){
            echo Html::hiddenInput('image_url-old',$model->image_url);
            echo $form->field($model, 'image_url')->widget(FileInput::classname(), [
                'pluginOptions' =>
                    [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Select Photo',
                        'initialPreview'=>[
                            Html::img("$model->image_url", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                        ],
                        'maxFileSize'=>600
                    ],
                'options' =>
                    ['accept' => 'image/*'],
            ]);
        }else{
            echo $form->field($model, 'image_url')->widget(FileInput::classname(), [
                'pluginOptions' =>
                    [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Select Photo',
                        'maxFileSize'=>600
                    ],
                'options' =>
                    ['accept' => 'image/*'],
            ]);
        }
        ?>

        <?php
        if($model->image_thumb_url){
            echo Html::hiddenInput('image_thumb_url-old',$model->image_thumb_url);
            echo $form->field($model, 'image_thumb_url')->widget(FileInput::classname(), [
                'pluginOptions' =>
                    [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Select Photo',
                        'initialPreview'=>[
                            Html::img("$model->image_thumb_url", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                        ],
                        'maxFileSize'=>600
                    ],
                'options' =>
                    ['accept' => 'image/*'],
            ]);
        }else{
            echo $form->field($model, 'image_thumb_url')->widget(FileInput::classname(), [
                'pluginOptions' =>
                    [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Select Photo',
                        'maxFileSize'=>600
                    ],
                'options' =>
                    ['accept' => 'image/*'],
            ]);
        }
        ?>
    </div>

    <div class="form-group col-md-12">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
