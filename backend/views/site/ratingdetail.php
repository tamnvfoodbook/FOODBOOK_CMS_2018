<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/datatables/jquery.dataTables.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/datatables/dataTables.bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/custom_dataTable.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('dist/css/AdminLTE.min.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/datatables/dataTables.bootstrap.css',['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('css/rating.min.css',['position' => \yii\web\View::POS_HEAD]);


//echo '<pre>';
//var_dump(json_encode(@array_values($rateArrayByStat[5])));
//echo '</pre>';

if($oderRateSorted){
    $arrayName = ArrayHelper::map($oderRateSorted,'_id','className','score');

    function countName($arrayName){
        $showName = NULL;
        foreach ($arrayName as $key => $value){
            foreach ($value as $key1 => $value1) {
                $showName[$key][$value1][] = $value1;
            }
        }
        return $showName;
    }


    $totalScore = $oderRateSorted->total_rate;

    $totalRepon = $oderRateSorted->count_reason_bad_food + $oderRateSorted->count_reason_expensive_price + $oderRateSorted->count_reason_bad_service + $oderRateSorted->count_reason_bad_shipper + $oderRateSorted->count_reason_other;

    ?>

    <div class="rating-box">
        <div class="score-container">
            <div class="score"><?= round(($oderRateSorted->total_rate),2);?></div>
            <div class="score-container-star-rating">
                <div class="small-star star-rating-non-editable-container">
                    <div style="width: <?php echo ($oderRateSorted->avg_rate/5)*100; ?>%;" class="current-rating"></div>
                </div>
            </div>
            <div class="reviews-stats">
                <span class="reviewers-small"></span>
                <span class="reviews-num"><?= number_format($oderRateSorted->avg_rate,2) ?></span> Lượt
            </div>
        </div>
        <div class="rating-histogram">
            <div class="rating-bar-container five">
                    <span class="bar-label"><span class="star-tiny star-full"></span>5</span>
                    <a id="popoverOption5" onclick="popupTopFunction(5)" href="#">
                        <span style="width:<?php if($oderRateSorted->count_5_star){echo ($oderRateSorted->count_5_star/$totalScore)*80;}else{echo 0;} ?>%" class="bar"></span>
                        <span aria-label=" 5 ratings " class="bar-number"><?= $oderRateSorted->count_5_star ?></span>
                    </a>
            </div>

            <div class="rating-bar-container four">
                    <span class="bar-label">
                        <span class="star-tiny star-full"></span>4
                    </span>
                <a id="popoverOption4" onclick="popupTopFunction(4)" href="#">
                    <span style="width:<?php if($oderRateSorted->count_4_star){echo ($oderRateSorted->count_4_star/$totalScore)*80;}else{echo 0;} ?>%" class="bar"></span>
                    <span aria-label=" 4 ratings " class="bar-number"><?= $oderRateSorted->count_4_star ?></span>
                </a>
            </div>

            <div class="rating-bar-container three">
                <span class="bar-label"> <span class="star-tiny star-full"></span>3 </span>
                <a id="popoverOption3" onclick="popupTopFunction(3)" href="#">
                    <span style="width:<?php if($oderRateSorted->count_3_star){echo ($oderRateSorted->count_3_star/$totalScore)*80;}else{echo 0;} ?>%" class="bar"></span>
                    <span aria-label=" 3 ratings " class="bar-number"><?= $oderRateSorted->count_3_star ?></span>
                </a>
            </div>

            <div class="rating-bar-container two">
                <span class="bar-label"> <span class="star-tiny star-full"></span>2</span>
                <a id="popoverOption2" onclick="popupTopFunction(2)" href="#">
                    <span style="width:<?php if($oderRateSorted->count_2_star){echo ($oderRateSorted->count_2_star/$totalScore)*80;}else{echo 0;} ?>%" class="bar"></span>
                    <span aria-label=" 2 ratings " class="bar-number"><?= $oderRateSorted->count_2_star ?></span>
                </a>
            </div>

            <div class="rating-bar-container one">
                <span class="bar-label"> <span class="star-tiny star-full"></span>1 </span>
                <a id="popoverOption1" onclick="popupTopFunction(1)" href="#">
                    <span style="width:<?php if($oderRateSorted->count_1_star){echo ($oderRateSorted->count_1_star/$totalScore)*80;}else{echo 0;} ?>%" class="bar"></span>
                    <span aria-label=" 1 ratings " class="bar-number"><?= $oderRateSorted->count_1_star ?></span>
                </a>
            </div>
        </div>
    </div>


        <!--Chi tiết Rating-->
        <!--5 sao-->
    <?php
        $body_table = '<thead>
                <tr>
                    <th></th>
                    <th>Tên khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Nhà hàng</th>
                    <th>Ngày tạo</th>
                    <th>Nhận xét</th>
                </tr>
                </thead>';
    ?>
    <div class="table_style">
        <div id="sao5">
            <h4>Danh sách khách hàng bình chọn 5 sao</h4>
            <table id="div_5sao" class="table table-bordered table-striped">
                <?= $body_table?>
            </table>
        </div>
        <!--./5 sao-->

        <!--4 sao-->
        <div id="sao4">
            <h4>Danh sách khách hàng bình chọn 4 sao</h4>
            <table id="div_4sao" class="table table-bordered table-striped">
                <?= $body_table?>
            </table>
        </div>
        <!--./4 sao-->


        <!--3 sao-->
        <div id="sao3">
            <h4>Danh sách khách hàng bình chọn 3 sao</h4>
            <table id="div_3sao" class="table table-bordered table-striped">
                <?= $body_table?>
            </table>
        </div>
        <!--./3 sao-->

        <!--2 sao-->
        <div id="sao2">
            <h4>Danh sách khách hàng bình chọn 2 sao</h4>
            <table id="div_2sao" class="table table-bordered table-striped">
                <?= $body_table?>
            </table>
        </div>
        <!--./2 sao-->

        <!--1 sao-->
        <div id="sao1">
            <h4>Danh sách khách hàng bình chọn 1 sao</h4>
            <table id="div_1sao" class="table table-bordered table-striped">
                <?= $body_table?>
            </table>
        </div>
        <!--./1 sao-->
    </div>


    <br><br>
    <div class="rating-box">
        <div itemscope="itemscope" itemprop="aggregateRating" class="score-container">
            <div aria-label=" Rated 4.3 stars out of five stars " class="score"><?= $totalRepon?></div>
            <div class="reviews-stats">
                <span class="reviewers-small"></span>
                <span aria-label=" 12,704,866 ratings " class="reviews-num"><?= $totalRepon?></span> Lượt bình chọn
            </div>
        </div>
        <div class="rating-histogram">
            <div class="rating-bar-container five">
                <span class="bar-label1" >Đồ ăn không ngon</span>
                <a id="popoverOption15" onclick="popupTopFunctionSeason(10)" href="#" style="margin-left: 41px;">
                    <span style="width:<?php if($totalRepon){ echo ($oderRateSorted->count_reason_bad_food/$totalRepon)*75;}else{ echo 0;};?>%;" class="bar"></span>
                    <span class="bar-number" style="margin-left: 41px"><?= $oderRateSorted->count_reason_bad_food?></span>
                </a>
            </div>

            <div class="rating-bar-container four">
                <span class="bar-label1">Giá đắt</span>
                <a id="popoverOption14" onclick="popupTopFunctionSeason(9)"  href="#" style="margin-left: 41px">
                    <span style="width:<?php if($totalRepon){ echo ($oderRateSorted->count_reason_expensive_price/$totalRepon)*75;}else{ echo 0;};?>%" class="bar"></span>
                    <span class="bar-number" style="margin-left: 41px"><?= $oderRateSorted->count_reason_expensive_price ?></span>
                </a>
            </div>

            <div class="rating-bar-container three">
                <span class="bar-label1">Giao hàng kém</span>
                <a id="popoverOption13" onclick="popupTopFunctionSeason(8)" href="#" style="margin-left: 41px">
                    <span style="width:<?php if($totalRepon){ echo ($oderRateSorted->count_reason_bad_shipper/$totalRepon)*75;}else{ echo 0;};?>%" class="bar"></span>
                    <span aria-label=" 3 ratings " class="bar-number" style="margin-left: 41px"><?= $oderRateSorted->count_reason_bad_shipper  ?></span>
                </a>
            </div>

            <div class="rating-bar-container two">
                    <span class="bar-label1">Dịch vụ kém</span>
                <a id="popoverOption12" onclick="popupTopFunctionSeason(7)" href="#" style="margin-left: 41px">
                    <span style="width:<?php if($totalRepon){ echo ($oderRateSorted->count_reason_bad_service/$totalRepon)*75;}else{ echo 0;};?>%" class="bar"></span>
                    <span aria-label=" 2 ratings " class="bar-number" style="margin-left: 41px"><?= $oderRateSorted->count_reason_bad_service?></span>
                </a>
            </div>

            <div class="rating-bar-container one">
                <span class="bar-label1">Lý do khác</span>
                <a id="popoverOption12" onclick="popupTopFunctionSeason(6)" href="#" style="margin-left: 41px">
                    <span style="width:<?php if($totalRepon){ echo ($oderRateSorted->count_reason_other/$totalRepon)*75;}else{ echo 0;};?>%" class="bar"></span>
                    <span aria-label=" 1 ratings " class="bar-number" style="margin-left: 41px"><?= $oderRateSorted->count_reason_other ?></span>
                </a>
            </div>
        </div>
    </div>


    <!--Chi tiết Rating-->
    <!--  Bad Food-->
    <div id="sao10">
        <h4>Danh sách khách hàng đánh giá đồ ăn không ngon</h4>
        <table id="div_10sao" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th></th>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Nhà hàng</th>
            </tr>
            </thead>
        </table>
    </div>
    <!--./Bad Food -->

    <!--Expensive-->
    <div id="sao9">
        <h4>Danh sách khách hàng đánh giá đồ ăn đắt</h4>
        <table id="div_9sao" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th></th>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Nhà hàng</th>
            </tr>
            </thead>
        </table>
    </div>
    <!--./Expensive-->

    <!--Bad Shiper-->
    <div id="sao8">
        <h4>Danh sách khách hàng đánh giá giao hàng kém</h4>
        <table id="div_8sao" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th></th>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Nhà hàng</th>
            </tr>
            </thead>
        </table>
    </div>
    <!--./Bad Shiper-->

    <!--Bad Service -->
    <div id="sao7">
        <h4>Danh sách khách hàng đánh giá dịch vụ kém</h4>
        <table id="div_7sao" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th></th>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Nhà hàng</th>
            </tr>
            </thead>
        </table>
    </div>
    <!--./Bad Service -->

    <!--Other-->
    <div id="sao6">
        <h4>Danh sách khách hàng có ý kiến khác</h4>
        <table id="div_6sao" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th></th>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Nhà hàng</th>
            </tr>
            </thead>
        </table>
    </div>
    <!--./Other-->
<?php
}else{
    echo '<h2>Không có lượt bình chọn nào!</h2>';
}
?>

<style>
    #sao10, #sao9, #sao8, #sao7, #sao6, #sao5, #sao4, #sao3, #sao2,#sao1{
        padding: 10px;
        display: none;
    }

    .table_style{
        -webkit-box-shadow: 3px 6px 21px 0px rgba(69,50,69,0.17);
        -moz-box-shadow: 3px 6px 21px 0px rgba(69,50,69,0.17);
        box-shadow: 3px 6px 21px 0px rgba(69,50,69,0.17);
    }
</style>

<script>
    var date_start = "<?= $date_start?>";
    var date_end = "<?= $date_end?>";
    var posnamemap = '<?= json_encode($posNameMap)?>';
    var dataRate = new Array();

    function getDataRate(star,date_start,date_end,posnamemap){
        $.ajax({type: "POST",
                url: "<?= Url::toRoute('/ajaxapi/ratedetail')?>",
                data: { star: star, date_start : date_start, date_end  : date_end, posnamemap : posnamemap},
                success:function(result){
                    var obj = JSON.parse(result);
                    if(star<6){
                        startDataTable("#div_"+star+"sao",obj);
                    }else{
                        var resonArr = {
                            '10' : 'reson_bad_food',
                            '9' :'reson_expensive_price',
                            '8' : 'reson_bad_shipper',
                            '7' :'reson_bad_service',
                            '6' : 'reson_other'
                    };
                        dataTableCustomerBase("#div_"+star+"sao",obj,resonArr[star]);
                    }
                    dataRate[star] = 1;
                }}
        );
    }

    function popupTopFunction(star) {
        if(dataRate[star] != 1){
            getDataRate(star,date_start,date_end,posnamemap);
        }
        for (i = 1; i < 6; i++) {
            if(i == star){
                $('#sao'+i).toggle('slow'); // Hien
            }else{
                $('#sao'+i).hide(); // Hien
            }
        }
    }



    function popupTopFunctionSeason(star) {
        if(dataRate[star] != 1){
            getDataRate(star,date_start,date_end,posnamemap);
        }
        for (i = 6; i < 11; i++) {
            if(i == star){
                $('#sao'+i).toggle('slow'); // Hien
            }else{
                $('#sao'+i).hide(); // Hien
            }
        }
    }

</script>

<?php
//    echo '<pre>';
//    var_dump($rateArrayByStat);
//    echo '</pre>';
?>


<style>
    td.details-control {
        background: url('images/icon-hop-qua.png') no-repeat center center;
        cursor: pointer;
        width: 50px;
    }
    tr.shown td.details-control {
        background: url('images/icon-hop-qua-open.png') no-repeat center center;
        width: 50px;
    }
    .warning_text{
        color: red;
    }
    .text_success{
        color: #007700;
    }

    .info_member{
        display: none;
    }
    .warning_text{
        color: red;
    }

</style>