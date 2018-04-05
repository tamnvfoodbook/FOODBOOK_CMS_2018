<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;


use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);


/* @var $this yii\web\View */
/* @var $model backend\models\Dmpos */
/* @var $form yii\widgets\ActiveForm */
$arrayStatus = array('Deative','Active');

//echo '<pre>';
//var_dump($model->IMAGE_PATH_THUMB);
//echo '</pre>';
//die();
?>

<div class="dmpos-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Tạo và đồng bộ' : 'Cập nhật và đồng bộ LALA POS', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success','name' => 'update_sync', 'value' => 1]) ?>
    </div>

<!-- Custom Tabs -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Thông tin chính</a></li>
        <li><a href="#tab_2" data-toggle="tab">Vị trí - địa điểm</a></li>
        <li><a href="#tab_3" data-toggle="tab">Mô tả mở rộng</a></li>
        <li><a href="#tab_4" data-toggle="tab">Cơ sở vật chất</a></li>
        <li><a href="#tab_5" data-toggle="tab">Ảnh</a></li>
        <li><a href="#tab_6" data-toggle="tab">Thanh toán điện tử</a></li>
        <li><a href="#tab_7" data-toggle="tab">Cấu hình thời gian</a></li>
    </ul>
    <div class="tab-content">

    <div class="tab-pane active" id="tab_1">

        <?= $form->field($model, 'DEVICE_ID', [
            'addon' => [
                'append' => [
                    'content' => Html::button('Sửa Device ID', ['class'=>'btn btn-warning','id' => 'btn_edit_deviceid']),
                    'asButton' => true
                ]
            ],
        ])->textInput(['readonly' => true]) ?>

        <?= $form->field($model, 'POS_NAME')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'POS_PARENT')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($posparents,'ID','NAME'),
            'language' => 'en',
            'options' => ['placeholder' => 'Chọn Posparent...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>

        <div class="col-md-3">
            <?= $form->field($model, 'ACTIVE')->dropDownList(['0' => 'Deactive','2' => 'Active Pos Mobile','1' => 'Active Pos Mobile & FOODBOOK']); ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'DELIVERY_SERVICES')->widget(Select2::classname(), [
                'data' => $allDeliveryMap,
                'options' => ['multiple' => true]
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'POS_MASTER_ID')->dropDownList(ArrayHelper::map($posmaster,'ID','POS_MASTER_NAME','city.CITY_NAME'))?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'IS_POS_MOBILE')->dropDownList(['0' => 'POS PC','1' => 'Pos Mobile','2' => 'LALA POS','3' => 'POS LALA PC Hybrid']); ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'VAT_TAX_RATE')->textInput(['maxlength' => true, 'type' => 'number']) ?>
        </div>
        <div class="clearfix"></div>




    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="tab_2">
        <div style="width: 47%; float: left;">
            <?= $form->field($model, 'CITY_ID')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($city,'ID','CITY_NAME'),
            ]) ?>
            <?= Html::hiddenInput('input-type-1', 'Additional value 1', ['id'=>'input-type-1'])?>
            <?= Html::hiddenInput('input-type-2', 'Additional value 2', ['id'=>'input-type-2'])?>

            <?=
                $form->field($model, 'DISTRICT_ID')->widget(DepDrop::classname(), [
                    'type'=>DepDrop::TYPE_SELECT2,
                    'data'=> ArrayHelper::map($district,'ID','DISTRICT_NAME'),
                    'options'=>['id'=>'subcat-id', 'placeholder'=>'Select ...'],
                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                    'pluginOptions'=>[
                        'depends'=>['dmpos-city_id'],
                        'url'=>Url::to(['/dmpos/subcat']),
                        'params'=>['input-type-1', 'input-type-2']
                    ]
                ]);
            ?>

            <?= $form->field($model, 'PHONE_NUMBER')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'POS_ADDRESS')->textInput(['maxlength' => true]) ?>
        </div>

        <div style="width: 47%; float: right;">
            <?= $form->field($model, 'POS_LONGITUDE')->textInput() ?>

            <?= $form->field($model, 'POS_LATITUDE')->textInput() ?>

            <?= $form->field($model, 'PHONE_MANAGER')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'POS_RADIUS_DETAL')->textInput() ?>

            <?= $form->field($model, 'LOCALE_ID')->widget(Select2::classname(), [
                'data' => $country_codes,
                'options' => ['placeholder' => 'Chọn Mã vùng...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
                ?>
        </div>
        <div class="clearfix"></div>
    </div><!-- /.tab-pane -->
    <div class="tab-pane" id="tab_3">
        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
            <table class="table table-condensed">
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                </tr>
                <tr>
                    <td>1.</td>
                    <td>Gọi đồ Online</td>
                    <td>
                        <?= $form->field($model, 'IS_ORDER_ONLINE')->checkbox(['label' => null])?>
                    </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Gọi món</td>
                    <td>
                        <?= $form->field($model, 'IS_ORDER')->checkbox(['label' => null])?>
                    </td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Cho phép đạt bàn</td>
                    <td>
                        <?= $form->field($model, 'IS_BOOKING')->checkbox(['label' => null])?>
                    </td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Chỗ để ô tô</td>
                    <td>
                        <?= $form->field($model, 'IS_CAR_PARKING')->checkbox(['label' => null])?>
                    </td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>Visa</td>
                    <td>
                        <?= $form->field($model, 'IS_VISA')->checkbox(['label' => null])?>
                    </td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>Sticky</td>
                    <td>
                        <?= $form->field($model, 'IS_STICKY')->checkbox(['label' => null])?>
                    </td>
                </tr>
            </table>
        </div><!-- /.box-body -->
        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
            <table class="table table-condensed">
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                </tr>
                <tr>
                    <td>7.</td>
                    <td>Hot</td>
                    <td>
                        <?= $form->field($model, 'IS_HOT')->checkbox(['label' => null])?>
                    </td>
                </tr>
                <tr>
                    <td>8.</td>
                    <td>Hiển thị loại món</td>
                    <td>
                        <?= $form->field($model, 'IS_SHOW_ITEM_TYPE')->checkbox(['label' => null])?>
                    </td>
                </tr>

                <tr>
                    <td>9.</td>
                    <td>Share sự kiện Facebook</td>
                    <td>
                        <?= $form->field($model, 'IS_ACTIVE_SHAREFB_EVENT')->checkbox(['label' => null])?>
                    </td>
                </tr>
                <tr>
                    <td>10.</td>
                    <td>Is order Later</td>
                    <td>
                        <?= $form->field($model, 'IS_ORDER_LATER')->checkbox(['label' => null])?>
                    </td>
                </tr>
                <tr>
                    <td>11.</td>
                    <td>Is Call Center</td>
                    <td>
                        <?= $form->field($model, 'IS_CALL_CENTER')->checkbox(['label' => null])?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="tab_4">
        <div style="width: 47%; float: left;">
            <?= $form->field($model, 'OPEN_TIME')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'ESTIMATE_PRICE_MAX')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'ESTIMATE_PRICE')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'WIFI_PASSWORD')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'SORT')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9',
                'clientOptions' => ['repeat' => 10, 'greedy' => false]
            ]) ?>

            <?= $form->field($model, 'WIFI_SERVICE_PATH')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'LAST_READY')->textInput() ?>

            <?= $form->field($model, 'WEBSITE_URL')->textInput(['maxlength' => true]) ?>


        </div>

        <div style="width: 47%; float: right;">
            <?= $form->field($model, 'SHIP_PRICE')->textInput() ?>

            <?= $form->field($model, 'MORE_INFO')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'WORKSTATION_ID')->textInput() ?>

            <?= $form->field($model, 'WS_ORDER_ONLINE')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'MIN_ORDER_PRICE')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'SHAREFB_EVENT_RATE')->textInput() ?>
        </div>

        <div class="clearfix"></div>

    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="tab_5">
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
                            'maxFileSize'=>250
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
                            'maxFileSize'=>250
                        ],
                    'options' =>
                        ['accept' => 'image/*'],
                ]);
            }
            ?>


        <?php
        if($model->IMAGE_PATH_THUMB){
        echo Html::hiddenInput('image-thumb-old',$model->IMAGE_PATH_THUMB);
            echo $form->field($model, 'IMAGE_PATH_THUMB')->widget(FileInput::classname(), [
                'pluginOptions' =>
                    [

                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Select Photo',
                        'initialPreview'=>[
                            Html::img("$model->IMAGE_PATH_THUMB", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                        ],
                        'maxFileSize'=>250
                    ],
                'options' =>
                    ['accept' => 'image/*'],
            ]);
        }else{
            echo $form->field($model, 'IMAGE_PATH_THUMB')->widget(FileInput::classname(), [
                'pluginOptions' =>
                    [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Select Photo',
                        'maxFileSize'=>250
                    ],
                'options' =>
                    ['accept' => 'image/*'],
            ]);
        }
        ?>

    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="tab_6">
        <?= $form->field($model, 'MOMO_MERCHANT_ID')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'MOMO_PUBLIC_KEY')->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'MOMO_PUBLIC_KEY_PM')->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'MOCA_MERCHANT_ID')->textInput(['maxlength' => false]) ?>
    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="tab_7">


        <?php

        /*echo '<label class="control-label">Thời gian nhà hàng Active</label>';
        echo DatePicker::widget([
            'name' => 'Dmpos[TIME_START]',
            'value' => $model->TIME_START,
            'type' => DatePicker::TYPE_RANGE,
            'name2' => 'Dmpos[TIME_END]',
            'value2' => $model->TIME_END,
            'pluginOptions' => [
                'pluginEvents' => [
                    "changeYear" => 'function(e) {  return false }',
                ],
                'autoclose'=>true,
                //'format' => 'yyyy-mm-dd'
                'format' => 'dd-mm-yyyy'
            ]
        ]);*/
        if($model->TIME_START){
            $model->TIME_START = date('d/m/Y',strtotime($model->TIME_START)).' - '.date('d/m/Y',strtotime($model->TIME_END));
        }
        echo $form->field($model, 'TIME_START', [
            'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
            'options'=>['class'=>'drp-container form-group']
        ])->widget(DateRangePicker::classname(), [
            'useWithAddon'=>true,
            'value'=>date('d/m/Y',strtotime($model->TIME_START)),
            'convertFormat'=>true,
            'pluginOptions'=>[
                'autoclose'=>true,
                'format'=>'d/m/Y',
                'opens'=>'left'
            ]

        ]);

        ?>

        <?php
        if($model->TIME_START_FB){
            $model->TIME_START_FB = date('d/m/Y',strtotime($model->TIME_START_FB)).' - '.date('d/m/Y',strtotime($model->TIME_END_FB));
        }

        echo $form->field($model, 'TIME_START_FB', [
            'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
            'options'=>['class'=>'drp-container form-group']
        ])->widget(DateRangePicker::classname(), [
            'useWithAddon'=>true,
            'value'=>date('d/m/Y',strtotime($model->TIME_START_FB)),
            'convertFormat'=>true,
            'pluginOptions'=>[
                'autoclose'=>true,
                'format'=>'d/m/Y',
                'opens'=>'left'
            ]

        ]);
        ?>
        <?php /*$form->field($model, 'TIME_END')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Ngày hết hạn của POS ...'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd-mm-yyyy'
            ],
        ]); */?>
        <?php /*$form->field($model, 'TIME_END_FB')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Ngày hết hạn trên FB...'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd-mm-yyyy'
            ]
        ]); */?>
    </div><!-- /.tab-pane -->
    </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->


    <?php ActiveForm::end(); ?>

</div>


<script>
    $('#btn_edit_deviceid').on('click', function() {
        if( !confirm('Bạn có chắc chắn muốn sửa Divice ID ?')) {
            return false;
        }else{
            $("#dmpos-device_id").attr("readonly", false);
        }
    });
</script>