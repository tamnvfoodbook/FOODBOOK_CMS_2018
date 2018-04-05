<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposparent */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Sửa '.$model->NAME;

?>

<div class="dmposparent-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'NAME')->textInput(['maxlength' => true,'readonly' => true]) ?>
            <?= $form->field($model, 'MERCHANT_ID')->textInput(['maxlength' => true,'readonly' => true]) ?>

            <?= $form->field($model, 'FACEBOOK_URL')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'MANAGER_EMAIL_LIST')->textInput() ?>
            <?=$form->field($model, 'POS_FEATURE')->widget(Select2::classname(), [
                'data' => $allPosMap,
                'language' => 'en',
                'options' => [
//                        'multiple' => true,
                    'placeholder' => 'Chọn nhà hàng...'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
            <?= $form->field($model, 'MANAGER_PHONE')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9',
                'clientOptions' => ['repeat' => 10, 'greedy' => false]
            ]);
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => 6]) ?>
            <?php
            if($model->IMAGE){
                echo Html::hiddenInput('IMAGE-old',$model->IMAGE);
                echo $form->field($model, 'IMAGE')->widget(FileInput::classname(), [
                    'pluginOptions' =>
                        [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' =>  'Select Photo',
                            'initialPreview'=>[
                                Html::img("$model->IMAGE", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                            ],
                            'maxFileSize'=>100
                        ],
                    'options' =>
                        ['accept' => 'image/*'],
                ]);
            }else{
                echo $form->field($model, 'IMAGE')->widget(FileInput::classname(), [
                    'pluginOptions' =>
                        [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' =>  'Select Photo',
                            'maxFileSize'=>100
                        ],
                    'options' =>
                        ['accept' => 'image/*'],
                ]);
            }

            ?>
        </div>

    </div><!-- /.tab-pane -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tạo' : 'Sửa', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
