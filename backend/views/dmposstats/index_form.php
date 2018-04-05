<?php

use yii\helpers\Url;
use backend\assets\AppAsset;

?>



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
