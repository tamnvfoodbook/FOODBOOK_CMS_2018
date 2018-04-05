<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\widgets\MaskedInput;
use backend\assets\AppAsset;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposparent */
/* @var $form yii\widgets\ActiveForm */

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

?>

<div class="dmposparent-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

    <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Thông tin chính</a></li>
        <li><a href="#tab_2" data-toggle="tab">Thông tin mở rộng - Ảnh</a></li>
        <li><a href="#tab_3" data-toggle="tab">Ví điện tử - Thẻ tích điểm</a></li>
        <li><a href="#tab_4" data-toggle="tab">Cấu hình Callcenter</a></li>
        <li><a href="#tab_5" data-toggle="tab">Giới hạn nhà hàng</a></li>
        <li><a href="#tab_6" data-toggle="tab">Cấu hình Zalo</a></li>
    </ul>
    <div class="tab-content">

    <div class="tab-pane active" id="tab_1">
        <?= $form->field($model, 'ID')->textInput(['maxlength' => true,'class' => 'text-uppercase form-control']) ?>

        <?= $form->field($model, 'NAME')->textInput(['maxlength' => true]) ?>

        <?php
        if($model->isNewRecord){
            echo $form->field($model, 'SOURCE')->hiddenInput(['value' => 'FOODBOOK_CMS'])->label(false);
        }else{
            echo $form->field($model, 'SOURCE')->dropDownList($partnerMap);
        }

        ?>
        <?= $form->field($model, 'POS_TYPE')->dropDownList([0 => 'MIXED', 1 => 'POS PC',2 => 'POS MOBILE' ]) ?>

    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="tab_2">
        <div class="row">
            <div class="col-md-6">
                <?php
                    if(!$model->isNewRecord){
                        echo $form->field($model, 'POS_FEATURE')->widget(Select2::classname(), [
                            'data' => $posModelMap,
                            'language' => 'en',
                            'options' => [
//                        'multiple' => true,
                                'placeholder' => 'Chọn nhà hàng...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    }
                ?>


                <?= $form->field($model, 'IS_SEND_SMS')->dropDownList([1 => 'Có',0 => 'Không'], ['value' => !empty($model->IS_SEND_SMS) ? $model->IS_SEND_SMS : 1]); ?>

                <?= $form->field($model, 'IS_GIFT_POINT')->dropDownList([0 => 'Không', 1 => 'Có']) ?>
                <?= $form->field($model, 'APP_ID')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'FACEBOOK_URL')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'FACEBOOK_PAGE_ID')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'MSG_UP_MEMBERSHIP')->textInput() ?>

                <?= $form->field($model, 'MSG_MEMBER_BAD_RATE')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '9',
                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                ]);
                ?>
                <?= $form->field($model, 'MANAGER_PHONE')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '9',
                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                ]);
                ?>

                <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => 3]) ?>

            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'AHAMOVE_ID')->textInput() ?>
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
                <?php
                if($model->LOGO){
                    echo Html::hiddenInput('LOGO-old',$model->LOGO);
                    echo $form->field($model, 'LOGO')->widget(FileInput::classname(), [
                        'pluginOptions' =>
                            [
                                'showCaption' => false,
                                'showRemove' => false,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-primary btn-block',
                                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                'browseLabel' =>  'Select Photo',
                                'initialPreview'=>[
                                    Html::img("$model->LOGO", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                                ],
                                'maxFileSize'=>100
                            ],
                        'options' =>
                            ['accept' => 'image/*'],
                    ]);
                }else{
                    echo $form->field($model, 'LOGO')->widget(FileInput::classname(), [
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

                <?php
                if($model->img_member){
                    echo Html::hiddenInput('img_member-old',$model->img_member);
                    echo $form->field($model, 'img_member')->widget(FileInput::classname(), [
                        'pluginOptions' =>
                            [
                                'showCaption' => false,
                                'showRemove' => false,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-primary btn-block',
                                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                'browseLabel' =>  'Select Photo',
                                'initialPreview'=>[
                                    Html::img("$model->img_member", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                                ],
                                'maxFileSize'=>100
                            ],
                        'options' =>
                            ['accept' => 'image/*'],
                    ]);
                }else{
                    echo $form->field($model, 'img_member')->widget(FileInput::classname(), [
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
        </div>



        <?php
        /*if(!$model->isNewRecord){
            echo $form->field($model, 'AHAMOVE_ID')->textInput(['readonly' => true]);
        }*/
        ?>

        <div class="clearfix"></div>
    </div><!-- /.tab-pane -->
    <div class="tab-pane" id="tab_3">
        <?= $form->field($model, 'MOMO_MERCHANT_ID')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'MOMO_PUBLIC_KEY')->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'MOMO_PUBLIC_KEY_PM')->textarea(['rows' => 4]) ?>

        <?= $form->field($model, 'MOCA_MERCHANT_ID')->textInput(['maxlength' => false]) ?>

        <div class="clearfix"></div>
    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="tab_4">

        <?= $form->field($model, 'DIRECT_LIST')->widget(Select2::classname(), [
            'data' => $partnerIdMap,
            'language' => 'en',
            'options' => ['multiple' => true,'placeholder' => 'Chọn Parner...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>

        <?= $form->field($model, 'WS_SIP_SERVER')->textInput(['maxlength' => false]) ?>
        <?= $form->field($model, 'PASS_SIP_SERVER')->textInput(['maxlength' => false]) ?>
        <?= $form->field($model, 'CC_API_KEY')->textInput(['maxlength' => false]) ?>
        <?= $form->field($model, 'CC_API_SECRET')->textInput(['maxlength' => false]) ?>

        <?= $form->field($model, 'BRAND_NAME')->textInput(['maxlength' => false]) ?>
        <?= $form->field($model, 'SMS_PARTNER')->dropDownList($configSMSMap) ?>

        <div class="clearfix"></div>

    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="tab_5">
        <?php
            if($model->MAX_POS_NUMBER){
                echo $form->field($model, 'MAX_POS_NUMBER')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '9',
                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                ]);
            }else{
                $model->MAX_POS_NUMBER = 9;
                echo $form->field($model, 'MAX_POS_NUMBER')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '9',
                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                ]);
            }
        ?>
        <?php
        if($model->MAX_EMPLOYEE_NUMBER){
            echo $form->field($model, 'MAX_EMPLOYEE_NUMBER')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9',
                'clientOptions' => ['repeat' => 10, 'greedy' => false]
            ]);
        }else{
            $model->MAX_EMPLOYEE_NUMBER = 9;
            echo $form->field($model, 'MAX_EMPLOYEE_NUMBER')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9',
                'clientOptions' => ['repeat' => 10, 'greedy' => false]
            ]);
        }
        ?>
        <?php
        if($model->MAX_MANAGER_NUMBER){
            echo $form->field($model, 'MAX_MANAGER_NUMBER')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9',
                'clientOptions' => ['repeat' => 10, 'greedy' => false]
            ]);
        }else{
            $model->MAX_MANAGER_NUMBER = 9;
            echo $form->field($model, 'MAX_EMPLOYEE_NUMBER')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9',
                'clientOptions' => ['repeat' => 10, 'greedy' => false]
            ]);
        }
        ?>
    </div><!-- /.tab-pane -->
    <div class="tab-pane" id="tab_6">
        <?= $form->field($model, 'ZALO_PAGE_ID')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'ZALO_OA_KEY')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'ZALO_SUBMIT_KEY')->textInput(['maxlength' => true]) ?>

    </div><!-- /.tab-pane -->
    </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
