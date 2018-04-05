<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::register($this);

$this->registerJsFile('js/js-chart/fusioncharts.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/js-chart/themes/fusioncharts.theme.fint.js', ['position' => \yii\web\View::POS_HEAD]);
//Load js to draw chart
$this->registerJsFile('js/draw_chart.js', ['position' => \yii\web\View::POS_HEAD]);

/*echo '<pre>';
var_dump($dataOnWeek);
echo '</pre>';
die();*/


?>
<script type="text/javascript">
    loadChart(<?= json_encode(array_values((array)@$dataOnWeek['TA_Count']));?>,<?= json_encode($allDay_test)?>,'Đơn hàng mang về','orderOnline_chart');
    loadChart(<?= json_encode(array_values((array)@$dataOnWeek['OTS_Count']));?>,<?= json_encode($allDay_test)?>,'Đơn hàng tại chỗ','orderOffline_chart');

    loadChart(<?= json_encode(array_values((array)@$dataOnWeek['rate']));?>,<?= json_encode($allDay_test)?>,'Rate','coupon_chart');
    loadChart(<?= json_encode($arrayShareFB);?>,<?= json_encode($allDay_test)?>,'Facebook Share','shareFacebook_chart');
    loadChart(<?= json_encode($arrayWishlist);?>,<?= json_encode($allDay_test)?>,'Yêu thích','wishlist_chart');
    //
    //    *//**//*Load Pie Char*//**//*
    drawChart_pie(<?php echo json_encode($dataOnWeek['pieChart']);?>,'tpoder_chart');
</script>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Biểu đồ 7 ngày gần nhất</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <!--Row 2 -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-4 connectedSortable ui-sortable">
                <!-- Chat box -->
                <div class="box box-primary box-solid">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="fa fa-cart-plus"></i>
                        <h3 class="box-title">Đơn hàng mang về </h3>
                    </div>
                    <div id="orderOnline_chart"></div>
                </div><!-- ./col -->
            </section>
            <!-- End /.Left col -->

            <!-- center col -->
            <section class="col-lg-4 connectedSortable ui-sortable">
                <!-- Chat box -->
                <div class="box box-primary box-solid">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="fa fa-shopping-cart"></i>
                        <h3 class="box-title">Đơn hàng tại chỗ</h3>
                    </div>
                    <div id="orderOffline_chart"></div>
                </div><!-- ./col -->
            </section>
            <!-- End center col -->

            <!-- Right col -->
            <section class="col-lg-4 connectedSortable ui-sortable">
                <!-- Chat box -->
                <div class="box box-primary box-solid">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="fa fa-pie-chart"></i>
                        <h3 class="box-title">Tỉ lệ đơn hàng</h3>
                    </div>
                    <div id="tpoder_chart"></div>
                </div><!-- ./col -->
            </section>
            <!-- End Right col -->
        </div> <!-- End Row 2 -->

        <!--Row 3 -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-4 connectedSortable ui-sortable">
                <!-- Chat box -->
                <div class="box box-primary box-solid">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="fa fa-thumbs-o-up"></i>
                        <h3 class="box-title">Điểm bình chọn</h3>
                    </div>
                    <div id="coupon_chart"></div>
                </div><!-- ./col -->
            </section>
            <!-- End /.Left col -->

            <!-- center col -->
            <section class="col-lg-4 connectedSortable ui-sortable">
                <!-- Chat box -->
                <div class="box box-primary box-solid">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="fa fa-facebook-official"></i>
                        <h3 class="box-title">Chia sẻ Facebook</h3>
                    </div>
                    <div id="shareFacebook_chart"></div>
                </div><!-- ./col -->
            </section>
            <!-- End center col -->

            <!-- Right col -->
            <section class="col-lg-4 connectedSortable ui-sortable">
                <!-- Chat box -->
                <div class="box box-primary box-solid">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="fa fa-heart-o"></i>
                        <h3 class="box-title">Yêu thích</h3>
                    </div>
                    <div id="wishlist_chart"></div>
                </div><!-- ./col -->
            </section>
            <!-- End Right col -->
        </div>
        <!-- End Row 3 -->
    </div><!-- /.box-body -->
</div><!-- /.box -->


