<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('js/html5shiv.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/respond.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('js/js-chart/fusioncharts.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/js-chart/themes/fusioncharts.theme.fint.js', ['position' => \yii\web\View::POS_HEAD]);
//Load js to draw chart
$this->registerJsFile('js/draw_chart.js', ['position' => \yii\web\View::POS_HEAD]);


$this->registerJsFile('bootstrap/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/datatables/jquery.dataTables.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/datatables/dataTables.bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('js/custom_dataTable.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('css/rating.min.css',['position' => \yii\web\View::POS_HEAD]);



if(isset($top) && $top != '0'){
    $this->title = 'Top '. count($idRank).'  đầu';
}else if(isset($bottom) && $bottom != '0'){
    $this->title = 'Top'. count($idRank).'  cuối';
}else{
    $this->title = 'So sánh 2 nhà hàng ';
}
?>

    <script type="text/javascript">
        loadChartTop(<?php echo json_encode($arrayOrderOnline);?>,<?php echo json_encode($allDay);?>,'orderOnline_chart');
        loadChartTop(<?php echo json_encode($arrayOrderOffline);?>,<?php echo json_encode($allDay);?>,'orderOffline_chart');
        loadChartTop(<?php echo json_encode($arrayPriceOnline);?>,<?php echo json_encode($allDay);?>,'priceOnline_chart');
        loadChartTop(<?php echo json_encode($arrayPriceOffline);?>,<?php echo json_encode($allDay);?>,'priceOffline_chart');
        loadChartTop(<?php echo json_encode($arrayRate);?>,<?php echo json_encode($allDay);?>,'coupon_chart');
        loadChartTop(<?php echo json_encode($arrayShareFB);?>,<?php echo json_encode($allDay);?>,'shareFacebook_chart');
        loadChartTop(<?php echo json_encode($arrayWishlist);?>,<?php echo json_encode($allDay);?>,'wishlist_chart');
    </script>
    <!--End Script Line Chart Đơn hàng Online-->

    <script>

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
                $('#modal2').modal('show')
                    .find('#pricedetailContent')
                    .load($(this).attr('value'));
            });
        });

        // Script Popup Price Detail
        $(function(){
            $('#buttonOrderDetail').click(function(){
                $('#modal1').modal('show')
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

        // Script hiện lựa chọn Top
        function popupTopFunction() {
            $('#topdiv').fadeIn('slow'); // Hien
            $('#bottomdiv').hide();
        }

        // Script hiện lựa chọn Bottom
        function popupBottomFunction() {
            $('#bottomdiv').fadeIn('slow'); // Hien
            $('#topdiv').hide();
        }
    </script>
    <!--End Java Script-->

    <style>
        #topdiv{
            display: none;
        }
        #bottomdiv{
            display: none;
        }
    </style>

    <body class="skin-green-light sidebar-mini">
    <div style="padding-bottom: 1%;  float: left">
        <?= Html::button( 'Top đầu' ,['class' => 'btn btn-success','onclick' => 'popupTopFunction();']); ?>
        <?= Html::button( 'Top cuối' ,['class' => 'btn btn-success','onclick' => 'popupBottomFunction();']); ?>
    </div>
    <div style="float: left;margin-top:7px; min-width:350px">
        <p id="topdiv" style="float: left; margin-left: 2%;">
            <?php
            echo 'Chọn top đầu:';

            for($countTop = $maxNumber; $countTop > 0; $countTop--){

                echo Html::a("$countTop", ['/top', 'top' => $countTop,'$bottom' => 0], ['class'=>'link-top']);
            }
            ?>
        </p>

        <p id="bottomdiv" style="float: left; margin-left: 2%;">
            <?php
            echo 'Chọn top cuối:';
            for($countBottom = $maxNumber; $countBottom > 0; $countBottom--){
                echo Html::a("$countBottom", ['/top','top' => 0, 'bottom' => $countBottom], ['class'=>'link-top']);
            }
            ?>
        </p>
    </div>
    <div class="clearfix"></div>
    <!-- Wraper -->
    <div>
        <!-- Main content -->
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <p>Doanh số ngày hôm nay</p>
                        <h3><?php echo number_format($orderOnToday + $orderOffToday);?><span style="font-size: 15px; margin-left: 5%;">Đơn hàng</span></h3>
                        <h4>Doanh thu: <?php echo number_format($priceOnToday + $priceOffToday);?><span style="font-size: 15px"> vnđ</span>
                        </h4>

                    </div>
                    <div class="icon"><i class="ion ion-bag"></i></div>
                    <a href="#" class="small-box-footer" id="buttonOrderDetail" >Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->


            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <p>Khách hàng ngày hôm nay</p>
                        <h3><?php echo number_format( @count($newMember) + @count($oldMember));?><span style="font-size: 15px; margin-left: 5%"> Khách hàng</span></h3>
                        <h4>
                            <p>Khách Mới: <?php if(!$newMember){echo 0;}else{echo @count($newMember);};?> - Khách Cũ: <?php if(!$oldMember){echo 0;}else{echo @count($oldMember);};?></p>
                        </h4>
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

                        <p>Bình chọn ngày hôm nay</p>
                        <h3><?php echo count($oderRateSorted);?><span style="font-size: 15px"> Lượt</span></h3>
                        <h4>
                            <?php
//                            echo '<pre>';
//                            var_dump($scoreRate);
//                            echo '</pre>';
//                            die();
                            if($oderRateSorted != NULL){
                                echo 'Điểm bình quân: '.number_format($scoreRate/count($oderRateSorted),2);
                            }else{
                                echo 'Điểm bình quân: 0';
                            };
                            ?>
                        </h4>

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
                        <p>Chia sẻ Facebook ngày hôm nay</p>
                        <h3><?= array_sum($facebookDetail)?><span style="font-size: 15px"> Lượt</span></h3>
                        <p><br></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer" id="buttonshareDetail" >Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
        </div><!-- /.row -->

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Biểu đồ 7 ngày gần nhất</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-4 connectedSortable ui-sortable" >
                        <!-- Chat box -->
                        <div class="box box-success box-solid" style="min-height: 300px;">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-cart-plus"></i>
                                <h3 class="box-title">Đơn hàng mang về</h3>
                            </div>
                            <div id="orderOnline_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End /.Left col -->

                    <!-- center col -->
                    <section class="col-lg-4 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-success box-solid" style="min-height: 300px;">
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
                        <div class="box box-success box-solid" style="min-height: 347px;">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-bar-chart"></i>
                                <h3 class="box-title">Các nhà hàng</h3>
                            </div>
                            <?php
                            $count = 1;
                            echo '<div class="detail-pos-full">';
                            foreach($arrayNote as $name => $value){
                                echo '<div class="progress-group">';
                                echo '<span class="progress-text">'.$name.'</span>';
                                echo '<span class="progress-number"><b>'.$value.'</b></span>';
                                echo '<div class="progress xxs">';
                                switch ($count) {
                                    case 1:
                                        echo '<div class="progress-bar progress-bar-aqua" style="width: 100%"></div>';
                                        break;
                                    case 2:
                                        echo '<div class="progress-bar progress-bar-red" style="width: 100%"></div>';
                                        break;
                                    case 3:
                                        echo '<div class="progress-bar progress-bar-yellow" style="width: 100%"></div>';
                                        break;
                                    case 4:
                                        echo '<div class="progress-bar progress-bar-green" style="width: 100%"></div>';
                                        break;
                                    case 5:
                                        echo '<div class="progress-bar progress-bar-tim" style="width: 100%"></div>';
                                        break;
                                    case 6:
                                        echo '<div class="progress-bar progress-bar-violet" style="width: 100%"></div>';
                                        break;
                                }

                                echo '</div>';
                                echo '</div><!-- /.progress-group -->';
                                $count++;
                            }
                            echo '</div>';
                            ?>

                        </div><!-- ./col -->
                    </section>
                    <!-- End Right col -->
                </div> <!-- End Row 1 -->

                <!--Row 2 -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-6 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-success box-solid" style="min-height: 300px;">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-money"></i>
                                <h3 class="box-title">Doanh thu mang về</h3>
                            </div>
                            <div id="priceOnline_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End /.Left col -->

                    <!-- center col -->
                    <section class="col-lg-6 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-success box-solid" style="min-height: 300px;">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-money"></i>
                                <h3 class="box-title">Doanh thu tại chỗ</h3>
                            </div>
                            <div id="priceOffline_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End center col -->

                    <!-- Right col -->

                    <!-- End Right col -->
                </div>
                <!-- End Row 2 -->

                <!--Row 3 -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-4 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-success box-solid">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-thumbs-o-up"></i>
                                <h3 class="box-title">Bình chọn</h3>
                            </div>
                            <div id="coupon_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End /.Left col -->

                    <!-- center col -->
                    <section class="col-lg-4 connectedSortable ui-sortable">
                        <!-- Chat box -->
                        <div class="box box-success box-solid">
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
                        <div class="box box-success box-solid">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-heart-o"></i>
                                <h3 class="box-title">Yêu thích</h3>
                            </div>
                            <div id="wishlist_chart"></div>
                        </div><!-- ./col -->
                    </section>
                    <!-- End Right col -->
            </div>
        </div><!-- /.box -->

        </div>
        <!-- End Row 3 -->
    </div> <!-- /.Wraper -->
    </body>


<?php
Modal::begin([
    'header' => '<h4>Chi tiết bình chọn</h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo '<div id="modalContent">';?>
<?= $this->render('../site/ratingdetail', [
    'model' => $model,
    'oderRateSorted' => $oderRateSorted,
    'posNameMap' => $posNameMap,
]) ?>
<?php echo '</div>';
Modal::end();
?>


<?php
Modal::begin([
    'header' => '<h4>Chi tiết doanh số trong ngày</h4>',
    'id' => 'modal1',
    'size' => 'modal-lg',
]);
echo '<div id="orderdetailContent">';?>
<?= $this->render('../site/pricedetail', [
    'model' => $model,
    'orderpriceDetail' => $orderpriceDetail,
    'posNameMap' => $posNameMap,
]) ?>
<?php echo '</div>';
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Chi tiết khách hàng trong ngày</h4>',
    //'footer' => '<h4>Footer Detail</h4>',
    'id' => 'modal2',
    'size' => 'modal-lg',
]);
echo '<div id="pricedetailContent">';?>
<?= $this->render('../site/memberdetail', [
    'model' => $model,
    'newMember' => $newMember,
    'oldMember' => $oldMember,
    'memberName' => $memberName,
    'posNameMap' => $posNameMap,
]) ?>
<?php echo '</div>';
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Chi tiết chia sẻ Facebook ngày hôm nay</h4>',
    'id' => 'modal3',
    'size' => 'modal-lg',
]);
echo '<div id="sharefbdetailContent">';?>
<?= $this->render('../site/facebookdetail', [
    'model' => $model,
    'facebookDetail' => $facebookDetail,
    'memberNameMap'=>$memberNameMap,
]) ?>
<?php echo '</div>';
Modal::end();
?>
