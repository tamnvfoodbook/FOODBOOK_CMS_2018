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

AppAsset::register($this);


$this->registerJsFile('js/jquery-2.1.1.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('js/validator.js', ['position' => \yii\web\View::POS_HEAD]);

$this->title = 'Tạo đơn hàng';
$this->params['breadcrumbs'][] = $this->title;

?>
<BR>
    <?php $form = ActiveForm::begin([
            'id' => 'myForm',
            'method' => 'post',
            'action' => ['create'],
        ]
    ); ?>

    <div  class="grid-view" data-width="100%">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
                <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Thông tin khách hàng</h3>
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
                                                'value' => $phoneNumber,
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
                                              <button class="btn btn-info btn-flat" type="button" id="btnSearchMember">Tìm kiếm</button>
                                            </span>
                                        </div><!-- /input-group -->

                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Tên khách hàng</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Tên khách hàng" name="textName" value="<?php  if(isset($modelMember->MEMBER_NAME)){echo $modelMember->MEMBER_NAME;}?>"  id="textName"  required>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <div class="footer-button pull-right">
                                <?= Html::submitButton('Tạo đơn hàng', ['id'=> 'create_btn','class' => 'btn btn-success form-group']) ?>
                                <div class="clearfix"></div>
                            </div>

                        </div><!-- /.box -->
                    </div>
                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Đơn hàng gần đây nhất</h3>
                            </div><!-- /.box-header -->
                            <div id="searchresultdata1" class="faq-articles">

                                <?php
                                if($model->created_at){
                                    $created_at = date(Yii::$app->params['DATE_TIME_FORMAT'],strtotime($model->created_at));
                                }else{
                                    $created_at = $model->created_at;
                                }

                                echo DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        'order_data_item',
                                        [
                                            'attribute' => 'created_at',
                                            'value' => $created_at
                                        ],
                                        [
                                            'attribute' => 'status',
                                            'value' => Yii::t('yii',$model->status)
                                        ],
                                        'pos_id',
                                        //'duration',
                                        'to_address',
                                        //'status',
                                        //'distance',
                                        //'total_fee',
                                    ],
                                ]) ?>
                                <?= Html::hiddenInput('lastorder',json_encode($model->oldAttributes))?>
                            </div>
                        </div><!-- /.box -->

                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Lịch sử giao dịch</h3>
                            </div><!-- /.box-header -->
                            <div id="searchresultdata" class="faq-articles">
                                <?php
                                    $sum_fail = 0;
                                    if($failed != null || $cancelled != null || $assigning != null || $accepted != null || $in_process != null || $wait_confirm != null || $comfirmed != null){
                                        $sum_fail = count($failed) + count($cancelled) + count($assigning) + count($accepted) + count($in_process) + count($wait_confirm) + count($comfirmed);
                                    }
                                ?>
                                <table class="table table-striped table-bordered detail-view">
                                    <tbody>
                                    <tr>
                                        <th width="65%">Tổng số đơn hàng</th>
                                        <td width="35%"><?= $total?></td>
                                    </tr>
                                    <tr>
                                        <th>Số đơn hàng thành công</th>
                                        <td><?= count($complete) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Số đơn hàng chưa thành công</th>
                                        <td><?= $sum_fail?></td>
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

    inputPhone.keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //$("#errmsg").html("Chỉ cho phép nhập số").show().fadeOut("slow");
            return false;
        }
    });


//    $(document).ready(function () {
//        $("#phoneNumber:text:visible:enabled:first").focus();
//    });


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
            if(faq_search_input.length>9)                    // Kiểm tra giá trị người nhập có > 2 ký tự hay ko
            {
                var url1 = "<?= \yii\helpers\Url::to(['/ajaxapi/userphone'])?>" + "&userphone=" + faq_search_input;
                var url2 = "<?= \yii\helpers\Url::to(['/ajaxapi/lastorder'])?>" + "&userphone=" + faq_search_input;
                var url3 = "<?= \yii\helpers\Url::to(['/ajaxapi/getname'])?>" + "&userphone=" + faq_search_input;

                $.ajax({
                    type: "GET",                              // Phương thức gọi là GET
                    url: url1,                  // File xử lý
                    data: dataString,                        // Dữ liệu truyền vào
                    beforeSend:  function() {                // add class "loading" cho khung nhập
                        $('input#phoneNumber').addClass('loading');
                    },
                    success: function(server_response)        // Khi xử lý thành công sẽ chạy hàm này
                    {
                        $('#searchresultdata').html(server_response).show();      // Hiển thị dữ liệu vào thẻ div #searchresultdata

                        var phoneconverted = convertPhoneTo84(faq_search_input);
                        $('#phoneNumber').val(phoneconverted);      // Hiển thị dữ liệu vào thẻ div #searchresultdat

                        //$('span#faq_category_title').html(faq_search_input);    // Hiển thị giá trị search của người dùng
                        if ($('input#phoneNumber').hasClass("loading")) {        // Kiểm tra class "loading"
                            $("input#phoneNumber").removeClass("loading");        // Remove class "loading"
                        }
                    }
                });

                $.ajax({
                    type: "GET",                              // Phương thức gọi là GET
                    url: url2,                  // File xử lý
                    data: dataString,                        // Dữ liệu truyền vào

                    success: function(server_response)        // Khi xử lý thành công sẽ chạy hàm này
                    {
                        $('#searchresultdata1').html(server_response).show();      // Hiển thị dữ liệu vào thẻ div #searchresultdata1
                    }
                });

                $.ajax({
                    type: "GET",                              // Phương thức gọi là GET
                    url: url3,                  // File xử lý
                    data: dataString,                        // Dữ liệu truyền vào
                    success: function(server_response)        // Khi xử lý thành công sẽ chạy hàm này
                    {
                        $('#textName').val(server_response);      // Hiển thị dữ liệu vào thẻ div #searchresultdata

                    }
                });

            }return false;        // Không chuyển trang

        }
  //  });
</script>