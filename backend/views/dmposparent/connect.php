<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use backend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/iCheck/icheck.min.js', ['position' => \yii\web\View::POS_HEAD]);

//$this->registerCssFile('plugins/iCheck/all.css',['position' => \yii\web\View::POS_HEAD]);



/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmposparentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kết nối';
$this->params['breadcrumbs'][] = $this->title;
?>

<br>
<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable ui-sortable">
        <?php $form = ActiveForm::begin([
            'id' => 'voip'
        ]); ?>
        <!-- Chat box -->
        <div class="box  box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Tổng đài Voice-ip</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-8 col-md-8">
                    <div>
                        Két nối tổng đài Voice - ip cho phép bạn nghe cuộc gọi của khách hàng ngay trên máy tính và được tích hợp với hệ thống CMS của IPOS giúp cho việc nhận đơn hàng trở lên dễ dàng và nhanh chóng hơn rất nhiều
                    </div>
                    <br>
                    <div>
                        <!-- radio -->
                        <div class="form-group">
                            <label>
                                <input type="radio" name="voiceip" class="minimal-red voip-setup"  value="0" />
                                Không kết nối
                            </label>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="radio" name="voiceip" class="minimal-red voip-setup"  value="1"/>
                                Kết nối
                            </label>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4 col-md-4" id="calcenter_content">
                    <?= $form->field($model, 'WS_SIP_SERVER') ?>
                    <?= $form->field($model, 'PASS_SIP_SERVER') ?>
                </div>

                <div class="form-group col-lg-4 col-md-4 col-lg-offset-4 col-md-offset-4">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary form-control']) ?>
                </div>

            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <?php ActiveForm::end(); ?>
    </section>
    <!-- End /.Left col -->
</div>


<div class="row">
    <!-- Left col -->
    <section class="col-lg-12  ui-sortable">
        <?php $form = ActiveForm::begin([
            'id' => 'smsbrandname'
        ]); ?>
        <!-- Chat box -->
        <div class="box  box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">SMS Brand name</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-8 col-md-8">
                    <div>
                        Kết nối Sms brandname cho phép bạn gửi sms truyền thông tới khách hàng đã ăn tại cửa hàng của bạn với mục đích quảng cáo sự kiện hoặc gửi tặng.
                    </div>
                    <br>

                    <div>
                        <?php
                        foreach($configSMSMap as $key => $value){
                            echo '<div class="form-group">';
                            echo '<label>';
                                echo '<input type="radio" name="smsbrand" class="minimal-red sms-style"  value="'.$key.'" /> '.$value;
                            echo '</label>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4" id="sms_content">
                    <?= $form->field($model, 'CC_API_KEY') ?>
                    <?= $form->field($model, 'CC_API_SECRET') ?>
                    <?= $form->field($model, 'BRAND_NAME') ?>
                    <div id="cp_code_vietel">
                        <?= $form->field($model, 'CP_CODE') ?>
                    </div>
                </div>

                <div class="form-group col-lg-4 col-md-4 col-lg-offset-4 col-md-offset-4">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary form-control']) ?>
                </div>

            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <?php ActiveForm::end(); ?>
    </section>
    <!-- End /.Left col -->
</div>



<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable ui-sortable">
        <?php $form = ActiveForm::begin([
            'id' => 'zaloForm'
        ]); ?>
        <!-- Chat box -->
        <div class="box  box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Zalo</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-8 col-md-8">
                    <div>
                        Kết nối zalo cho phép thương hiệu xuất hiện trên Zalo và các tính năng hơn thế nữa.
                        <br>
                        + Check-in tại nhà hàng bằng Zalo App <br>
                        + Nhập E- voucher khi yêu thích Zalo page <br>
                        + Theo dõi tích điểm tại hệ thống của bạn. <br>
                        + Xem danh sách và dẫn đường tới cửa hàng.<br>
                    </div>
                    <br>
                    <div>
                        <!-- radio -->
                        <div class="form-group">
                            <label>
                                <input type="radio" name="zalo" class="minimal-red zalo-setup" checked value="0" />
                                Không kết nối
                            </label>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="radio" name="zalo" class="minimal-red zalo-setup"  value="1"/>
                                Kết nối
                            </label>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4 col-md-4" id="zalo_content">
                    <?= $form->field($model, 'ZALO_OA_KEY') ?>
                    <?= $form->field($model, 'ZALO_PAGE_ID') ?>
                    <?= $form->field($model, 'ZALO_SUBMIT_KEY') ?>
                </div>

                <div class="form-group col-lg-4 col-md-4 col-lg-offset-4 col-md-offset-4">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary form-control']) ?>
                </div>

            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <?php ActiveForm::end(); ?>
    </section>
    <!-- End /.Left col -->
</div>


<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable ui-sortable">
        <?php $form = ActiveForm::begin([
            'id' => 'facebookForm'
        ]); ?>
        <!-- Chat box -->
        <div class="box  box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Facedbook</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-8 col-md-8">
                    <div>
                        Kết nối Facebook cho phép thương hiệu xuất hiện trên Zalo và các tính năng hơn thế nữa.
                        <br>
                        + Check-in tại nhà hàng trên Facebook Page <br>
                        + Nhập E- voucher khi yêu thích Facebook page <br>
                        + Theo dõi tích điểm tại hệ thống của bạn. <br>
                        + Xem danh sách và dẫn đường tới cửa hàng.<br>
                    </div>
                    <br>
                    <div>
                        <!-- radio -->
                        <div class="form-group">
                            <label>
                                <input type="radio" name="zalo" class="minimal-red zalo-setup" checked value="0" />
                                Không kết nối
                            </label>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="radio" name="zalo" class="minimal-red zalo-setup"  value="1"/>
                                Kết nối
                            </label>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4 col-md-4" id="zalo_content">
                    <?= $form->field($model, 'ZALO_OA_KEY') ?>
                    <?= $form->field($model, 'ZALO_PAGE_ID') ?>
                    <?= $form->field($model, 'ZALO_SUBMIT_KEY') ?>
                </div>

                <div class="form-group col-lg-4 col-md-4 col-lg-offset-4 col-md-offset-4">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary form-control']) ?>
                </div>

            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <?php ActiveForm::end(); ?>
    </section>
    <!-- End /.Left col -->
</div>



<script>
    //Red color scheme for iCheck
    /*$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });*/
    function confirmdata(){
        var r = confirm("Các dữ liệu kết nối sẽ bị xóa, bạn có chắc chắn muốn bỏ kết nối ?");
        if(r == true) {
            return true;
        } else {
            return false;
        }
    }

    var wssip = $('#dmposparent-ws_sip_server').val();
    var pssip =  $('#dmposparent-pass_sip_server').val();


    function showSetupVoiceip(wssip,pssip){
        var value = 0;
        if(wssip.length > 0 && pssip.length > 0){
            value = 1;
            $("input[name=voiceip][value=" + value + "]").attr('checked', 'checked');
            $('#calcenter_content').show();
        }else{
            $("input[name=voiceip][value=" + value + "]").attr('checked', 'checked');
            $('#calcenter_content').hide();
        }

        var config = $('input[name=voiceip]:checked', '#voip').val();
        if(config == 0){
            $('#calcenter_content').hide();
        }else{
            $('#dmposparent-ws_sip_server').val(wssip);
            $('#dmposparent-pass_sip_server').val(pssip);
            $('#calcenter_content').show();
        }
    }

    showSetupVoiceip(wssip,pssip);

    $(".voip-setup" ).on( "click", function() {
        var voipvalue = $("input:checked").val();
        if(voipvalue == 0){
            if(confirmdata() == true){
                $('#dmposparent-ws_sip_server').val('');
                $('#dmposparent-pass_sip_server').val('');
                showSetupVoiceip(wssip,pssip);
            }
        }else{
            showSetupVoiceip(wssip,pssip);
        }


    });


    function showSetupSms(){

        var value = '<?= $model->SMS_PARTNER?>';
        $("input[name=smsbrand][value=" + value + "]").attr('checked', 'checked');

        if(value != 0){
            $('#sms_content').show();
        }else{
            $('#sms_content').hide();
        }

        var smsvalue = $('input[name=smsbrand]:checked', '#smsbrandname').val();

        if(smsvalue == 0){
            $('#sms_content').hide();
        }else{
            $('#sms_content').show();
            if(smsvalue == 'VIETTEL_SMS'){
                $('#cp_code_vietel').show();
            }else{
                $('#cp_code_vietel').hide();
            }
        }
    }

    showSetupSms();
    $( ".sms-style" ).on( "click", function() {
        showSetupSms();
    });

    ///Zalo
    var zalo_oa_key = '<?= $model->ZALO_OA_KEY ?>';
    var zalo_page_id = '<?= $model->ZALO_PAGE_ID ?>';
    var zalo_submit_key = '<?= $model->ZALO_SUBMIT_KEY ?>';

    function showSetupZalo(zalo_oa_key,zalo_page_id,zalo_submit_key){

        var value = 0;
        if(zalo_oa_key.length > 0 && zalo_page_id.length > 0 && zalo_submit_key.length > 0){
            value = 1;
            $("input[name=zalo][value=" + value + "]").attr('checked', 'checked');
            $('#zalo_content').show();
        }else{
            $("input[name=zalo][value=" + value + "]").attr('checked', 'checked');
            $('#zalo_content').hide();
        }


        var config = $('input[name=zalo]:checked', '#zaloForm').val();
        if(config == 0){
            $('#zalo_content').hide();
        }else{
            $('#dmposparent-zalo_oa_key').val(zalo_oa_key);
            $('#dmposparent-zalo_page_id').val(zalo_page_id);
            $('#dmposparent-zalo_submit_key').val(zalo_submit_key);
            $('#zalo_content').show();
        }
    }

    showSetupZalo(zalo_oa_key,zalo_page_id,zalo_submit_key);

    $( ".zalo-setup" ).on( "click", function() {
        var config = $('input[name=zalo]:checked', '#zaloForm').val();

        if(config == 0){
            if(confirmdata() == true){
                $('#dmposparent-zalo_oa_key').val('');
                $('#dmposparent-zalo_page_id').val('');
                $('#dmposparent-zalo_submit_key').val('');
                showSetupZalo(zalo_oa_key,zalo_page_id,zalo_submit_key);
            }
        }else{
            showSetupZalo(zalo_oa_key,zalo_page_id,zalo_submit_key);
        }

    });


</script>
