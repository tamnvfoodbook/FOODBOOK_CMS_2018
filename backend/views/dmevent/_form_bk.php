<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\field\FieldRange;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use \yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $model backend\models\Dmevent */
/* @var $form yii\widgets\ActiveForm */

$dataEatCount = [
    '0' => '0 lần',
    '10' => '10 lần',
    '20' => '20 lần',
    '30' => '30 lần',
    '40' => '40 lần',
    '50' => '50 lần',
    '99999' => 'Không giới hạn',
];
?>
<br>
<div class="grid-view" ><div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-book-icon"></i> <?= $this->title ?></h3>
            <div class="clearfix"></div>
        </div>
        <div class="rc-handle-container" style="padding: 20px">
            <div class="dmevent-form">
                <?php $form = ActiveForm::begin([
                    'id' => 'form_event',

                ]); ?>
                <?= FieldRange::widget([
                    'form' => $form,
                    'model' => $model,
                    'label' => 'Khách hàng đã ăn từ bao nhiêu lần đến bao nhiêu lần',
                    'separator' => '← đến →',
                    'attribute1' => 'MIN_EAT_COUNT',
                    'attribute2' => 'MAX_EAT_COUNT',
                    'type' => FieldRange::INPUT_SPIN,
                    'widgetOptions1' => ['pluginOptions'=>[
                        'initval' => 0,
                        'min' => 0,
                        'max' => 100000,
                        'step' => 1,
                        'boostat' => 5,
                        'maxboostedstep' => 10,
                        //'prefix' => 'Từ',
                    ]],
                    'widgetOptions2' => ['pluginOptions'=>[
                        'initval' => 100,
                        'min' => 0,
                        'max' => 100000,
                        'step' => 1,
                        'boostat' => 5,
                        'maxboostedstep' => 10,
                    ]],
                ]);
                ?>

                <?= FieldRange::widget([
                    'form' => $form,
                    'model' => $model,
                    'label' => 'Khách hàng đã chi tiêu khoảng từ',
                    'attribute1' => 'MIN_PAY_AMOUNT',
                    'attribute2' => 'MAX_PAY_AMOUNT',
                    'separator' => '← đến →',
                    'type' => FieldRange::INPUT_SPIN,
                    'widgetOptions1' => ['pluginOptions'=>[
                        'initval' => 0,
                        'min' => 0,
                        'max' => 1000000000,
                        'step' => 10000,
                        'boostat' => 5,
                        'maxboostedstep' => 10,
                        'prefix' => '$',
                    ]],
                    'widgetOptions2' => ['pluginOptions'=>[
                        'initval' => 100000,
                        'min' => 0,
                        'max' => 1000000000,
                        'step' => 10000,
                        'boostat' => 5,
                        'maxboostedstep' => 10,
                        'prefix' => '$',
                    ]],
                ]);
                ?>

                <?= $form->field($model, 'LAST_VISIT_FREQUENCY')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '9',
                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                ]) ?>
                <?= $form->field($model, 'DATE_START')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Ngày bắt đầu ...'],
                    'value' => date('m-d-Y'),
                    'pluginOptions' => [
                        'autoclose'=>true
                    ]
                ])->label('Ngày chạy sự kiện');
                ?>
                <?= $form->field($model, 'CAMPAIGN_ID')->widget(Select2::classname(), [
                    'data' => $campains,
                    'options' => ['placeholder' => 'Chọn chiến dịch...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Chọn e - Vourcher cho CSKH');
                ?>
                <?= $form->field($model, 'EVENT_NAME')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick' => 'getExpectedApproach()']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <?php
    Modal::begin([
        'header' => '<h4>Thông báo</h4>',
        'footer' => Html::button(Yii::t('app', 'Bỏ qua'),['class' => 'btn btn-default pull-left','data-dismiss' => 'modal']).Html::button(Yii::t('app', 'Đồng ý'),['class' => 'btn btn-success','id' => 'acceptBtn', ]),
        'id' => 'modal3',
    ]);
    echo '<div id="confirmContent"></div>';
    Modal::end();
    ?>


<script>


    $('form').attr('onsubmit','return false;');
    function getExpectedApproach(){
        var min_eat_count = $('#dmevent-min_eat_count').val();
        var max_eat_count = $('#dmevent-max_eat_count').val();
        var min_eat_payment = $('#dmevent-min_pay_amount').val();
        var max_eat_payment = $('#dmevent-max_pay_amount').val();
        var last_visit_frequency = $('#dmevent-last_visit_frequency').val();
        var date_start = $('#dmevent-date_start').val();
        var campaign_id = $("#dmevent-campaign_id option:selected" ).val();
        var event_name = $('#dmevent-event_name').val();

        if(min_eat_count.length !== 0 && max_eat_count.length !== 0 && min_eat_payment.length !== 0 && max_eat_payment.length !== 0 && last_visit_frequency.length !== 0 && date_start.length !== 0 /*&& campaign_id.length !== 0*/ && event_name.length !== 0){

            $.ajax({type: "GET",
                url: "<?= Url::toRoute('dmevent/getexpected')?>",
                data: {  min_eat_count : min_eat_count, max_eat_count : max_eat_count , min_eat_payment : min_eat_payment , max_eat_payment : max_eat_payment , last_visit_frequency: last_visit_frequency, campaign_id: campaign_id , date_start: date_start, event_name: event_name},

                success:function(result){
                    if(result && result !=""){
                        var dataCampainCreat = JSON.parse(result);
                        if(dataCampainCreat.data){
//                            var r = confirm("Số khách hàng tiếp cận là "+ dataCampainCreat.data.expected_approach + "\nNội dung tin nhắn SMS tới khách hàng:"+
//                            "\n"+dataCampainCreat.data.sms_event +"\n"+"\n"+"Bạn có chắc chắn muốn tạo sự kiện này không?");
                            var r = "Số khách hàng tiếp cận là "+ dataCampainCreat.data.expected_approach + "<br>Nội dung tin nhắn SMS tới khách hàng:"+
                            "<br>"+dataCampainCreat.data.sms_event +"<br>"+"<br>"+"Bạn có chắc chắn muốn tạo sự kiện này không?";
                            $('#confirmContent').html(r);
                            $('#modal3').modal('show').find('#confirmContent');
                            return false;
                            /*
                            if(r == true) {
                                myForm.attr('onsubmit','return true;');
                                myForm.submit();
                                return true;
                            } else {
                                myForm.attr('onsubmit','return false;');
                                return false;
                            }*/
                        }else{
                            alert(dataCampainCreat.error.message);
                            return false;
                        }
                    }else{
                        alert('Sự cố kết nối server không thể tạo được sự kiện, vui lòng thử lại sau');
                        return false;
                    }
                }
            });
        }
    }

    $("#acceptBtn").click(function(){
        var myForm = $('form');
        myForm.attr('onsubmit','return true;');
        myForm.submit();
    });

</script>





