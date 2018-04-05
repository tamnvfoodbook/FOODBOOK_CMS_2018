<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\checkbox\CheckboxX;

use kartik\field\FieldRange;

use backend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $model backend\models\Dmpartner */
/* @var $form yii\widgets\ActiveForm */
$mapEvent = [
        'birthday' => 'Sinh nhật',
        'membership_money_spent' => 'Thay đổi mức chi tiêu',
        'bill_printed' => 'Khi in hóa đơn',
        'remind_voucher' => 'Voucher sắp hết hạn',
        'remind_return' => 'Lâu ngày không trở lại',
        'membership_card_changed' => 'Thay đổi loại thành viên',
];
$this->title = 'Sự kiện '.$mapEvent[$model->trigger_name];

$this->params['breadcrumbs'][] = ['label' => 'Sự kiện', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['create', 'triggername' => $model->trigger_name]];
$this->params['breadcrumbs'][] = 'Thêm mới';
?>
<br>

<div class="dmpartner-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-12">
            <div class="panel box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            Hình thức gửi
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">
                        <?= $form->field($model, 'trigger_name')->hiddenInput()->label(false) ?>

                        <?php
                            echo $form->field($model, 'trigger_message')->textInput(['placeholder'=>' Nội dung tin nhắn...']);
                        ?>

                        <?php
                            echo $form->field($model, 'trigger_voucher_campaign', [
                                'addon' => [
                                    'prepend' => [
                                        'content' => '<span class=""><input type="checkbox" name="Event[trigger_type]" id="trigger_type_1" class="trigger_type_cl" value="1"></span>'
                                    ]
                                ]
                            ])->widget(Select2::classname(), [
                                'data' => $campaginMap,
                                /*'options' => [
                                    'placeholder' => 'Chọn voucher...',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                                */
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel box box-primary chanel">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            Kênh gửi
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">
                        <?= $form->field($model, 'send_via_sms')->widget(CheckboxX::classname(), [
                            'pluginOptions'=>['threeState'=>false],
                            'autoLabel'=>true
                        ])->label(false);
                        ?>

                        <?= $form->field($model, 'send_via_zalo')->widget(CheckboxX::classname(), [
                            'pluginOptions'=>['threeState'=>false],
                            'autoLabel'=>true
                        ])->label(false);
                        ?>
                        <?= $form->field($model, 'send_via_facebook')->widget(CheckboxX::classname(), [
                            'pluginOptions'=>['threeState'=>false],
                            'autoLabel'=>true
                        ])->label(false);
                        ?>
                    </div>
                </div>
            </div>
        </div>

    <?php
        if($model->trigger_name == 'birthday' || $model->trigger_name == 'remind_voucher'){
        ?>
        <div class="col-md-6">
            <div class="panel box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            Điều kiện
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">
                        <?php
                        echo $form->field($model, 'trigger_pre', [
                            'addon' => [
                                'prepend' => [
                                    'content' => '<span class=""><input type="radio" name="Event[trigger_time]" value="1"></span>'
                                ]
                            ]
                        ])->textInput(['placeholder'=>'Trước X ngày ( Nhập số ngày)','type' => 'number' ])->label('');


                        echo $form->field($model, 'trigger_birthday',[
                            'addon' => [
                                'prepend' => [
                                    'content' => '<span class=""><input type="radio" name="Event[trigger_time]" value="0" checked></span>'
                                ]
                            ],
                        ])->textInput(['placeholder'=>'Đúng ngày','readonly' => true])->label(false);

                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }elseif($model->trigger_name == 'membership_card_changed'){
        ?>
            <div class="col-md-6">
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                Điều kiện
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="box-body">
                            <?php
                            echo FieldRange::widget([
                                'form' => $form,
                                'model' => $model,
                                'label' => 'Nâng hạng thẻ',
                                'attribute1' => 'card_before',
                                'attribute2' => 'card_after',
                                'type' => FieldRange::INPUT_DROPDOWN_LIST,
                                'items1' => $membershipsMap,
                                'items2' => $membershipsMap,
                            ]);
                            ?>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }elseif($model->trigger_name == 'remind_return'){
        ?>
            <div class="col-md-6">
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                Điều kiện
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="box-body">
                            <?php
                                echo $form->field($model, 'trigger_pre')->textInput(['placeholder'=>'Khách hàng không trở lại sau (X) ngày ','type' => 'number' ])->label('');
                            ?>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }elseif($model->trigger_name == 'bill_printed'){
        ?>
            <div class="col-md-6 clause">
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                Điều kiện
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="box-body">
                            <?php
                                echo FieldRange::widget([
                                    'form' => $form,
                                    'model' => $model,
                                    'label' => 'Khách hàng chi tiêu trong khoảng',
                                    'separator' => 'đến',
                                    'attribute1' => 'min_amount',
                                    'attribute2' => 'max_amount',
                                    'type' => FieldRange::INPUT_SPIN,
                                    'widgetOptions1' => [
                                        'pluginOptions' => [
                                            'verticalbuttons' => true,
//                                'step' => 5,
                                            'min' => 0,
                                            'max' => 10000000000,

                                        ]
                                    ],
                                    'widgetOptions2' => [
                                        'pluginOptions' => [
                                            'verticalbuttons' => true,
//                                'step' => 5,
                                            'min' => 0,
                                            'max' => 10000000000,

                                        ]
                                    ],
                                ]);
                            ?>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }elseif($model->trigger_name == 'membership_money_spent'){
        ?>
            <div class="col-md-6 ">
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                Điều kiện
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="box-body">
                            <?= $form->field($model, 'trigger_pre')->textInput(['placeholder'=>'Số điểm khách chi tiêu vượt quá (X) vnđ tiền đã chi tiêu','type' => 'number' ])->label(''); ?>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    ?>

    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="clearfix">

    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
//    var trigger_type = $('#trigger_type_0:checked').val();
/*
    $('input[class=trigger_type_cl]').change(function(){
        var value = $( 'input[class=trigger_type_cl]:checked' ).val();
        if(value == 1){

        }else{
            if($('#event-trigger_message').val() == '' ){
                $('.field-event-trigger_message').addClass('has-error');
                $('.field-event-trigger_message').find('.help-block').html('Nội dung tin nhắn không được để trống.');
            }

        }
    });*/

    var trigger_name = '<?= $model->trigger_name ?>';
    if(trigger_name === 'remind_voucher'){
        $('.field-event-trigger_voucher_campaign').hide();
    }
    if(trigger_name === 'bill_printed'){
        $('.chanel').hide();
        $('.clause').removeClass('col-md-6');
        $('.clause').addClass('col-md-12');
    }



</script>

