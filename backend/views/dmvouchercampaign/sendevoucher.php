<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmposmasterSearch */
/* @var $allCityMap backend\controllers\DmposmasterController */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AppAsset;
use kartik\widgets\TypeaheadBasic;
use kartik\select2\Select2;

AppAsset::register($this);


$this->registerJsFile('js/jquery-2.1.1.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('js/validator.js', ['position' => \yii\web\View::POS_HEAD]);

$this->title = 'Tặng Voucher';
$this->params['breadcrumbs'][] = $this->title;

?>
<BR>
<?php $form = ActiveForm::begin([
        'id' => 'myForm',
        'method' => 'post',
    ]
); ?>

<div  class="grid-view" data-width="100%">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"></h3>
            <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Tặng Voucher</h3>
            <div class="clearfix"></div>
        </div>
        <div class="rc-handle-container"></div><div class="table-responsive kv-grid-container" id="w0-container">
            <div style="margin-top: 2%">
                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin cá nhân</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label">Số điện thoại</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <?=
                                        TypeaheadBasic::widget([
                                            'name' => 'textPhone',
                                            'data' =>  $userPhoneData,
                                            'id' => 'phoneNumber',
                                            'options' => [
                                                'autofocus' => true,
                                                'placeholder' => 'Số điện thoại',
                                            ],
                                            'pluginOptions' => ['highlight'=>true],
//                                                'pluginEvents' => [
//                                                    'typeahead:change' => 'function() { log("typeahead:initialized "); }',
//                                                ],
                                        ]);
                                        ?>
                                        <span class="input-group-btn">
                                              <button class="btn btn-info btn-flat" type="button" id="btnSearchMember">Tìm thông tin</button>
                                            </span>
                                    </div><!-- /input-group -->

                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label">Chọn Voucher</label>
                                <div class="col-sm-8">
                                    <?=
                                     Select2::widget([
                                        'name' => 'campaign_id',
                                        'value' => '',
                                        'data' => $dataCampainMap,
                                        //'options' => ['placeholder' => 'Vui lòng chọn Voucher ...']
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label">Kênh gửi</label>
                                <div class="col-sm-8">
                                    <?=
                                     Select2::widget([
                                        'name' => 'send_type',
                                        'value' => '',
                                        'data' => [1 => 'SMS', 2 => 'ZALO', 3 => 'Facebook'],
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="footer-button pull-right">
                            <?= Html::submitButton('Gửi tặng', ['id'=> 'create_btn','class' => 'btn btn-success form-group']) ?>
                            <div class="clearfix"></div>
                        </div>

                    </div><!-- /.box -->
                </div>
                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin khách hàng</h3>
                        </div><!-- /.box-header -->
                        <div id="searchresultdata1" class="faq-articles">
                            <table class="table table-striped table-bordered detail-view">
                                <tbody>
                                <tr>
                                    <th width="65%">Tên</th>
                                    <td width="35%"></td>
                                </tr>
                                <tr>
                                    <th>Số điện thoại</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Ngày sinh</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Giới tính</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Nhóm khách</th>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.box -->
                </div>

            </div>


        </div>


    </div>
</div>

<?php ActiveForm::end(); ?>


<script>

    var inputPhone = $("#phoneNumber");


    $('#create_btn').click(function(){
        var phone= $('#phoneNumber');
        if(phone.val() == ''){
            $(this).parents('p').addClass('warning');
            alert('Số điện thoại không được để trống');
            return false;
        }else{
            var r = confirm("Bạn muốn tặng e - Voucher này cho số điện thoại: "+ phone.val());
            if(r == true) {
                return true;
            } else {
                return false;
            }
        }
    });

    inputPhone.keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //$("#errmsg").html("Chỉ cho phép nhập số").show().fadeOut("slow");
            return false;
        }
    });


    function convertPhoneTo84(phone){
        if (phone.startsWith("084")){
            phone = phone.substring(1);
        }
        else if (phone.startsWith("0")){
            phone = "84" + phone.substring(1);
        }else if(!phone.startsWith("84")){
            phone = "84" + phone;
        }
        return phone;
    }

    $("#btnSearchMember").click(function(){
        log();
    });

    //    $(document).ready(function(){
    function log() {
        var faq_search_input = $("#phoneNumber").val(); // Lấy giá trị search của người dùng

        var dataString = 'keyword='+ faq_search_input;    // Lấy giá trị làm tham số đầu vào cho file ajax-search.php
        if(faq_search_input.length>9 && faq_search_input.length < 12)                    // Kiểm tra giá trị người nhập có > 2 ký tự hay ko
        {

            var url2 = "<?= \yii\helpers\Url::to(['/ajaxapi/member'])?>" + "&userphone=" + faq_search_input;

            $.ajax({
                type: "GET",                              // Phương thức gọi là GET
                url: url2,                  // File xử lý
                data: dataString,                        // Dữ liệu truyền vào

                success: function(server_response)        // Khi xử lý thành công sẽ chạy hàm này
                {
                    $('#searchresultdata1').html(server_response).show();      // Hiển thị dữ liệu vào thẻ div #searchresultdata1
                }
            });
        }else{
            alert("Vui lòng nhập đúng định dạng số điện thoại");
        }

        return false;        // Không chuyển trang

    }
    //  });
</script>