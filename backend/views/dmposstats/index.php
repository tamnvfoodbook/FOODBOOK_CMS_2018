<?php

use yii\helpers\Url;
use backend\assets\AppAsset;

$this->title = 'Thống kê giao vận';

AppAsset::register($this);
//Load js to draw chart
$this->registerJsFile('js/js-chart/fusioncharts.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/js-chart/themes/fusioncharts.theme.fint.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/draw_chart.js', ['position' => \yii\web\View::POS_HEAD]);

$oderTrafic = $countStatusCANCELLED + $countStatusCOMPLETED + $countStatusACCEPTED + $countStatusASSINING + $countStatusIN_PROCESS;
$orderPie = [['label'=> 'Đơn hàng hủy','value'=>$countStatusCANCELLED ],['label'=> 'Đơn hàng thành công','value'=>$countStatusCOMPLETED]];


$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('bootstrap/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css', ['position' => \yii\web\View::POS_HEAD]);

//echo '<pre>';
////var_dump(array_sum(end($arrayOrderComplete)+ end($arrayOrderComplete)));
//echo '</pre>';
//die();
?>
<!-- Script Pie Thành phần đơn hàng-->
<script type="text/javascript">
    loadChartTrafic(<?php echo json_encode($arrayOrderCancel);?>,<?php echo json_encode($arrayOrderComplete);?>,<?php echo json_encode($allDay)?>,'order_chart');
    loadChartTrafic(<?php echo json_encode($arrayDistanceCanceled);?>,<?php echo json_encode($arrayDistanceCompleted);?>,<?php echo json_encode($allDay)?>,'distance_chart');
    loadChartTrafic(<?php echo json_encode($arrayTimeCanceled);?>,<?php echo json_encode($arrayTimeComplete);?>,<?php echo json_encode($allDay)?>,'time_chart');
    loadChart(<?php echo json_encode($arrayPayComplete);?>,<?php echo json_encode($allDay)?>,'Biểu đồ bình quân phí vận chuyển','totalpay_chart');
    /*drawChart_pie_trafic(<?php echo json_encode($orderPie);?>,'order_pie');*/
</script>
<!-- End Script Pie Thành phần đơn hàng-->

<!--Button function-->
<div class="row">
    <div class="col-md-3 col-md-offset-9">
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="reservation" readonly="readonly" value="<?= date('m/d/Y').' - '.date('m/d/Y') ?>"/>
        </div><!-- /.input group -->
    </div>
</div>
<br>


<div class="box box-success" id="sale_by_time">
    <div class="box-header with-border">
        <h3 class="box-title">Ngày hôm nay</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
    <!-- 4 Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <p>Đơn hàng </p>
                        <h3><?php echo array_sum(end($arrayOrderComplete))+ array_sum(end($arrayOrderCancel));?><span style="font-size: 20px"> Đơn</span></h3>
                        <h5>Thành công: <?php echo array_sum(end($arrayOrderComplete))?> </h5>
                        <h5>Hủy: <?php echo array_sum(end($arrayOrderCancel))?> </h5>
                    </div>
                    <!--<a href="#" class="small-box-footer">Chi tiết<i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner" id="tpOrder">
                        <p>Phí vận chuyển </p>
                        <h3><?php echo number_format($totalPayToday);?><span style="font-size: 20px"> vnđ</span></h3>
                        <h5><br></h5>
                        <h5><br></h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <!--<a href="#" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <p>Quãng đường </p>
                        <h3><?php echo (array_sum(end($arrayDistanceCompleted))+ array_sum(end($arrayDistanceCanceled)))*array_sum(end($arrayOrderComplete))+ array_sum(end($arrayOrderCancel));?><span style="font-size: 20px"> Km</span></h3>
                        <h5>Bình quân: <?php echo array_sum(end($arrayDistanceCompleted))+ array_sum(end($arrayDistanceCanceled)).' Km/order'; ?></h5>
                        <h5>Bình quân: <?php
                            if((array_sum(end($arrayTimeComplete))+ array_sum(end($arrayTimeCanceled)))){
                                echo number_format((array_sum(end($arrayDistanceCompleted))+ array_sum(end($arrayDistanceCanceled)))/(array_sum(end($arrayTimeComplete))+ array_sum(end($arrayTimeCanceled))),2).' km/phút' ;
                            }else{
                                echo '0 km/phút';
                            }
                            ?>
                        </h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <!--<a href="#" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <p>Thời gian </p>
                        <h3><?php echo (array_sum(end($arrayTimeComplete))+ array_sum(end($arrayTimeCanceled)))*array_sum(end($arrayOrderComplete))+ array_sum(end($arrayOrderCancel));?><span style="font-size: 20px"> phút</span></h3>
                        <h5>Bình quân: <?php echo array_sum(end($arrayTimeComplete))+ array_sum(end($arrayTimeCanceled)).' phút/ đơn hàng' ;?></h5>
                        <h5>Bình quân: <?php
                            if((array_sum(end($arrayDistanceCompleted))+ array_sum(end($arrayDistanceCanceled)))){
                                echo number_format((array_sum(end($arrayTimeComplete))+ array_sum(end($arrayTimeCanceled)))/(array_sum(end($arrayDistanceCompleted))+ array_sum(end($arrayDistanceCanceled))),2).' phút/km' ;
                            }else{
                                echo '0 phút/km';
                            }
                            ?>
                        </h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <!--<a href="#" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div><!-- ./col -->
        </div><!-- /.row -->
    </div>
</div>

<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Biểu đồ 7 ngày gần nhất</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
    <!--Row 1 -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable ui-sortable">
            <!-- Chat box -->
            <div class="box box-success  box-solid">
                <div class="box-header ui-sortable-handle" style="cursor: move;">
                    <i class="fa fa-comments-o"></i>
                    <h3 class="box-title">Biểu đồ đơn hàng</h3>
                </div>
                <div id="order_chart"></div>
            </div><!-- ./col -->
        </section>
        <!-- End /.Left col -->

        <!-- right col -->
        <section class="col-lg-6 connectedSortable ui-sortable">
            <!-- Chat box -->
            <div class="box box-success  box-solid">
                <div class="box-header ui-sortable-handle" style="cursor: move;">
                    <i class="fa fa-comments-o"></i>
                    <h3 class="box-title">Biểu đồ bình quân quãng đường - đơn hàng</h3>
                </div>
                <div id="distance_chart"></div>
            </div><!-- ./col -->
        </section>
        <!-- End right col -->
    </div>
    <!-- End Row 1 -->

    <!--Row 2 -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable ui-sortable">
            <!-- Chat box -->
            <div class="box box-success  box-solid">
                <div class="box-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="box-title">Biểu đồ bình quân phí vận chuyển</h3>
                </div>
                <div id="totalpay_chart"></div>
            </div><!-- ./col -->
        </section>
        <!-- End /.Left col -->

        <!-- right col -->
        <section class="col-lg-6 connectedSortable ui-sortable">
            <!-- Chat box -->
            <div class="box box-success  box-solid">
                <div class="box-header ui-sortable-handle" style="cursor: move;">
                    <i class="fa fa-comments-o"></i>
                    <h3 class="box-title">Biểu đồ bình quân thời gian - đơn hàng</h3>
                </div>
                <div id="time_chart"></div>
            </div><!-- ./col -->
        </section>
        <!-- End right col -->
    </div>
    <!-- End Row 2 -->
    </div>
</div>
<div class="row">
    <iframe width="100%" height="600px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"    src="<?php echo $linkTrafic;?>"></iframe>
</div>


<script>
    var dp = {};

    function cb(start, end) {
        $('#reservation').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }

    cb(moment().subtract(0, 'days'), moment());

    dp = $('#reservation').daterangepicker({
        ranges: {
            'Hôm nay': [moment(), moment()],
            'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            //'7 Ngày trước đây': [moment().subtract(7, 'days'), moment()],
            '7 Ngày trước đây': [moment().subtract(7, 'days'), moment().subtract(1, 'days')],
            //'30 Ngày trước đây': [moment().subtract(30, 'days'), moment()],
            '30 Ngày trước đây': [moment().subtract(30, 'days'), moment().subtract(1, 'days')],
            'Tháng này': [moment().startOf('month'), moment().endOf('month')],
            'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);


    dp.on('apply.daterangepicker',function(event,picker){
        $.fn.ajaxData();
    });


    $(document).ready(function() {
        $.fn.ajaxData = function() {

            $.ajax({type: "POST",
                url: "<?= Url::toRoute('/dmposstats')?>",
                data: {dateRanger: $("#reservation").val(), checkAjax : 1},

                beforeSend: function() {
                    //that.$element is a variable that stores the element the plugin was called on
                    $("#content_bill").addClass("fb-grid-loading");
                },
                complete: function() {
                    //$("#modalButton").removeClass("loading");
                    $("#content_bill").removeClass("fb-grid-loading");
                },

                success:function(result){
                    $("#sale_by_time").html(result);
                }
            });
        }

    });

</script>
