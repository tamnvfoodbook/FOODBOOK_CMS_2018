<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;


?>
<!-- Script Line chart Đơn hàng -->
<script type="text/javascript"
        src="https://www.google.com/jsapi?autoload={
        'modules':[{
          'name':'visualization',
          'version':'1',
          'packages':['corechart']
        }]
      }">
</script>


<script type="text/javascript">
    function loadChart(arr,name,div_id){
        google.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            <?php 
            if (isset($idRank)) {?>
            data.addColumn('string', 'Week'); // Implicit domain label col.
            <?php
                foreach($idRank as $key => $value){?>
                    data.addColumn('number','<?php echo  (string)$value;?>'); // Implicit series 1 data col.
                    data.addColumn({type:'number', role:'annotation'});  // interval role col.*/
            <?php
                }
            }else{
              ?>
            data.addColumn('string', 'Week'); // Implicit domain label col.
            data.addColumn('number',name); // Implicit series 1 data col.
            data.addColumn({type:'number', role:'annotation'});  // interval role col.
            <?php
            }            
            ;
            ?>

            data.addRows(arr);

            var options = {
                title: '',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById(div_id));
            chart.draw(data, options);
        }

    }
</script>
<script type="text/javascript">
    loadChart(<?php echo json_encode($arrayOrderOnline);?>,'Order Online','orderOnline_chart');
    loadChart(<?php echo json_encode($arrayOrderOffline);?>,'Order Offline','orderOffline_chart');
    loadChart(<?php echo json_encode($arrayPriceOnline);?>,'Price Online','priceOnline_chart');
    loadChart(<?php echo json_encode($arrayPriceOffline);?>,'Price Offline','priceOffline_chart');
    loadChart(<?php echo json_encode($arrayRate);?>,'Rate','coupon_chart');
    loadChart(<?php echo json_encode($arrayShareFB);?>,'Facebook Share','shareFacebook_chart');
    loadChart(<?php echo json_encode($arrayWishlist);?>,'Yêu thích','wishlist_chart');
</script>
<!--End Script Line Chart Đơn hàng Online-->

<!-- Script Pie Chart thành phần khách hàng-->
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart_tpOrder);
    function drawChart_tpOrder() {
        var data = google.visualization.arrayToDataTable([
            ['Đơn hàng', 'Checkin'],
            ['Order Online',<?php echo $orderOnline;?>],
            ['Order Offline', <?php echo $orderOffline; ?>],
        ]);

        var options = {
            title: '',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('tpoder_chart'));
        chart.draw(data, options);
    }
</script>
<!-- End Script Pie Chart thành phần khách hàng-->

<!-- Script Pie Chart thành phần khách hàng-->
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart_tpPrice);
    function drawChart_tpPrice() {
        var data = google.visualization.arrayToDataTable([
            ['Doanh số', 'Detail'],
            ['Online',<?php echo $priceOnline;?>],
            ['Offline',<?php echo $priceOffline;?>],
        ]);

        var options = {
            title: '',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('tpPrice_pie'));
        chart.draw(data, options);
    }
</script>
<!-- End Script Pie Chart thành phần Doanh số-->
<script>
    function showDivTop() {
        $('#viewCompare').fadeOut('fast');
        $('#viewTop').fadeIn('slow');

    }

    function showDivLeast() {
        $('#viewLeast').fadeIn('slow');

    }

    function showDivCompare() {
        $('#viewTop').fadeOut('fast');
        $('#viewCompare').fadeIn('slow');
    }

    // Script Popup Rating
    $(function(){
        $('#modalButton').click(function(){
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        });
    });

    // Script Popup Price Detail
    $(function(){
        $('#buttonPriceDetail').click(function(){
            $('#modal1').modal('show')
                .find('#pricedetailContent')
                .load($(this).attr('value'));
        });
    });

    // Script Popup Price Detail
    $(function(){
        $('#buttonOrderDetail').click(function(){
            $('#modal2').modal('show')
                .find('#orderdetailContent')
                .load($(this).attr('value'));
        });
    });

    // Script Popup shareFB Detail
    $(function(){
        $('#buttonshareDetail').click(function(){
            $('#modal3').modal('show')
                .find('#sharefbdetailContent')
                .load($(this).attr('value'));
        });
    });

    // Script Popup shareFB Detail
    $(function(){
        $('#buttonTopDetail').click(function(){
            $('#modaltop').modal('show')
                .find('#topContent')
                .load($(this).attr('value'));
        });
    });

    // Script Popup Least
    $(function(){
        $('#buttonLeastDetail').click(function(){
            $('#modalleast').modal('show')
                .find('#leastContent')
                .load($(this).attr('value'));
        });
    });

    // Script Popup xem theo thời gian
    $(function(){
        $('#buttonTimeDetail').click(function(){
            $('#modaltime').modal('show')
                .find('#timeContent')
                .load($(this).attr('value'));
        });
    });


    // Script Popup So sánh
    $(function(){
        $('#buttonCompareDetail').click(function(){
            $('#modalcompare').modal('show')
                .find('#timeContent')
                .load($(this).attr('value'));
        });
    });
</script>

<!--End Java Script-->
<div>
<?= Html::button( 'Tất cả' ,['value'=>'index.php','class' => 'btn btn-primary','id' => 'modalAllButton']) ?>
<?= Html::button( 'Xem Top' ,['class' => 'btn btn-primary','id' => 'buttonTopDetail']) ?>
<?= Html::button( 'Xem Bottom' ,['class' => 'btn btn-primary','id' => 'buttonLeastDetail']) ?>
<?= Html::button( 'Xem theo thời gian' ,['class' => 'btn btn-primary','id' => 'buttonTimeDetail']) ?>
<?= Html::button( 'So sánh' ,['class' => 'btn btn-primary','id' => 'buttonCompareDetail']) ?>
<div>
<!--Form xem so sánh-->
<div id="viewCompare"  style="display:none;" >
    <?= $this->render('compare', [
        'model' => $model,
    ]) ?>
</div>
<!--End form xem so sánh-->

<body class="skin-blue sidebar-mini">
<div class="wrapper-tamnv">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper-tamnv">

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo number_format($orderOnline + $orderOffline);?><sup style="font-size: 15px"> Order</sup></h3>
                            <p>Đơn hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer" id="buttonOrderDetail" >Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php echo number_format($priceOnline + $priceOffline);?><sup style="font-size: 15px"> Vnđ</sup></h3>
                            <p>Doanh thu</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer" id="buttonPriceDetail">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo $scoreRate ;?><sup style="font-size: 15px"> Điểm</sup></h3>
                            <p>Rating bình quân: <?php echo round((float)($scoreRate/$rate),2);?> điểm</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer" id="modalButton">Chi tiết<i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php echo $shareFacebook;?><sup style="font-size: 15px"> Lượt</sup></h3>
                            <p>Share Facebook</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer" id="buttonshareDetail" >Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
            </div><!-- /.row -->
            <!-- Main row -->
            <div class="row">

                <!--Row 1 -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-4 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-success box-solid">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-comments-o"></i>
                                <h3 class="box-title">Order Online</h3>
                            </div>
                            <div id="orderOnline_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End /.Left col -->

                    <!-- center col -->
                    <section class="col-lg-4 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-success box-solid">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-comments-o"></i>
                                <h3 class="box-title">Order Offline</h3>
                            </div>
                            <div id="orderOffline_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End center col -->

                    <!-- Right col -->
                    <section class="col-lg-4 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-success box-solid">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-comments-o"></i>
                                <h3 class="box-title">Tỉ lệ đơn hàng</h3>
                            </div>
                            <div id="tpoder_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End Right col -->
                </div>
                <!-- End Row 1 -->

                <!--Row 2 -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-4 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-default box-solid">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-comments-o"></i>
                                <h3 class="box-title">Doanh thu Online</h3>
                            </div>
                            <div id="priceOnline_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End /.Left col -->

                    <!-- center col -->
                    <section class="col-lg-4 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-default box-solid">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-comments-o"></i>
                                <h3 class="box-title">Doanh thu Offline</h3>
                            </div>
                            <div id="priceOffline_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End center col -->

                    <!-- Right col -->
                    <section class="col-lg-4 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-default box-solid">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-comments-o"></i>
                                <h3 class="box-title">Tỉ lệ doanh thu</h3>
                            </div>
                            <div id="tpPrice_pie"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End Right col -->
                </div>
                <!-- End Row 2 -->

                <!--Row 2 -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-4 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-warning box-solid">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-comments-o"></i>
                                <h3 class="box-title">Rating</h3>
                            </div>
                            <div id="coupon_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End /.Left col -->

                    <!-- center col -->
                    <section class="col-lg-4 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-warning box-solid">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-comments-o"></i>
                                <h3 class="box-title">Share Facebook</h3>
                            </div>
                            <div id="shareFacebook_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End center col -->

                    <!-- Right col -->
                    <section class="col-lg-4 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-warning box-solid">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-comments-o"></i>
                                <h3 class="box-title">Yêu thích</h3>
                            </div>
                            <div id="wishlist_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End Right col -->
                </div>
                <!-- End Row 3 -->


            </div><!-- /.row (main row) -->
        </section><!-- /.content -->
    </div><!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
</div><!-- ./wrapper -->



<?php
Modal::begin([
    'header' => '<h4>Rating Detail</h4>',
    //'footer' => '<h4>Footer Detail</h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo '<div id="modalContent">';?>
<?= $this->render('ratingdetail', [
    'model' => $model,
    'oderRateSorted' => $oderRateSorted,
]) ?>
<?php echo '</div>';
Modal::end();
?>


<?php
Modal::begin([
    'header' => '<h4>Rating Detail</h4>',
    //'footer' => '<h4>Footer Detail</h4>',
    'id' => 'modal1',
    'size' => 'modal-lg',
]);
echo '<div id="pricedetailContent">';?>
<?= $this->render('pricedetail', [
    'model' => $model,
    'priceDetail' => $priceDetail,
    'allDay' => $allDay,
]) ?>
<?php echo '</div>';
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Order Detail</h4>',
    //'footer' => '<h4>Footer Detail</h4>',
    'id' => 'modal2',
    'size' => 'modal-lg',
]);
echo '<div id="orderdetailContent">';?>
<?= $this->render('pricedetail', [
    'model' => $model,
    'priceDetail' => $orderDetail,
    'allDay' => $allDay,
]) ?>
<?php echo '</div>';
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Share Facebook Detail</h4>',
    'id' => 'modal3',
    'size' => 'modal-lg',
]);
echo '<div id="sharefbdetailContent">';?>
<?= $this->render('pricedetail', [
    'model' => $model,
    'priceDetail' => $shareFbDetail['sum'],
    'allDay' => $allDay,
]) ?>
<?php echo '</div>';
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Lựa chọn Top</h4>',
    'id' => 'modaltop',
    'size' => 'modal-sm',
]);
echo '<div id="topContent">';?>
<?= $this->render('dmtop', [
    'model' => $model,
]) ?>
<?php echo '</div>';
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Lựa chọn Least</h4>',
    'id' => 'modalleast',
    'size' => 'modal-sm',
]);
echo '<div id="leastContent">';?>
<?= $this->render('leastform', [
    'model' => $model,
]) ?>
<?php echo '</div>';
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Lựa chọn Theo thời gian</h4>',
    'id' => 'modaltime',
    'size' => 'modal-lg',
]);
echo '<div id="timeContent">';?>
<?= $this->render('compare', [
    'model' => $model,
]) ?>
<?php echo '</div>';
Modal::end();
?>



<?php
Modal::begin([
    'header' => '<h4>So Sánh</h4>',
    'id' => 'modalcompare',
    'size' => 'modal-lg',
]);
echo '<div id="compareContent">';?>
<?= $this->render('comparetwoposform', [
    'model' => $model,
]) ?>
<?php echo '</div>';
Modal::end();
?>
