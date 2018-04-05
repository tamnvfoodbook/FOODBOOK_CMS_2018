<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model backend\models\Dmpartner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmpartner-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'PARTNER_NAME')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'ACTIVE')->dropDownList(['0' => 'Không', '1' => 'Có']) ?>
        </div>
        <div class="col-md-6">
            <?php
            if($model->AVATAR_IMAGE){
                echo Html::hiddenInput('AVATAR_IMAGE-old',$model->AVATAR_IMAGE);
                echo $form->field($model, 'AVATAR_IMAGE')->widget(FileInput::classname(), [
                    'pluginOptions' =>
                        [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' =>  'Select Photo',
                            'initialPreview'=>[
                                Html::img("$model->AVATAR_IMAGE", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                            ],
                            'maxFileSize'=>960
                        ],
                    'options' =>
                        ['accept' => 'image/*'],
                ]);
            }else{
                echo $form->field($model, 'AVATAR_IMAGE')->widget(FileInput::classname(), [
                    'pluginOptions' =>
                        [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' =>  'Select Photo',
                            'maxFileSize'=>960
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
