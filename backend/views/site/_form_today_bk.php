<?php

use yii\bootstrap\Modal;
use yii\web\JqueryAsset;
$this->registerJsFile('plugins/datatables/jquery.dataTables.min.js',  ['depends' => JqueryAsset::className()]);
$this->registerJsFile('plugins/datatables/dataTables.bootstrap.min.js',  ['depends' => JqueryAsset::className()]);
?>
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
                .find('#memberdetailContent')
                .load($(this).attr('value'));
        });
    });

    // Script Popup Order Detail
    $(function(){
        $('#buttonOrderDetail').click(function(){
            $('#modal1').modal('show')
                .find('#orderdetailContent')
                .load($(this).attr('value'));
        });
    });

    // Script Popup Comment Detail
    $(function(){
        $('#buttonRateDetail').click(function(){
            $('#modal3').modal('show')
                .find('#commentContent')
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

<!--./Button function-->
    <div class="box-header with-border">
        <h3 class="box-title"><?= $dateTextLabel ?></h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <!-- Main content -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 ">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner" id="total_content">
                        <p>DOANH SỐ </p>
                        <h3><?php echo number_format($priceToday);?><span style="font-size: 15px"> &#8363</span></h3>
                        <p><b><?php echo number_format($orderToday);?></b> Đơn hàng</p>
                        <p><?php if(!$TA_Count){echo 0;}else{echo $TA_Count; };?> Bán mang về</p>
                        <p><b><?php if(!$OTS_Count){echo 0;}else{echo $OTS_Count; };?></b> Bán tại chỗ</p>
                    </div>
                    <a href="#" class="small-box-footer" id="buttonOrderDetail" >Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->


            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner" id="total_customer">
                        <p>KHÁCH HÀNG </p>
                        <h3><?php echo number_format($newMember + $oldMember);?><span style="font-size: 15px;"> Khách</span></h3>
                        <p>Khách mới: <?php if(!$newMember){echo 0;}else{echo $newMember; };?></p>
                        <p>Khách cũ: <?php if(!$oldMember){echo 0;}else{echo $oldMember; };?></p>
                        <p>&nbsp;</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer" id="buttonPriceDetail">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->

            <div class="col-lg-3  col-md-6 col-sm-6 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner" id="rate_content">
                        <p>BÌNH CHỌN </p>
                        <h3><?php echo $totalRate ?><span style="font-size: 15px"> Lượt</span></h3>
                        <p><?= 'Điểm bình quân: '.number_format($avg_rate,1); ?></p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>

                    </div>

                    <a href="#" class="small-box-footer" id="modalButton">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner" id="commnet_content">
                        <p>BÌNH LUẬN</p>
                        <div class="content_commnet">
                            <span class="h3_custom"><?= @$Comment_In_Fb_Count + @$Comment_In_Rate_Count?></span><span style="font-size: 15px"> Lượt</span><br>
                            <p><?= @$Comment_In_Fb_Count ?> Lượt bình luận Foodbook</p>
                            <p><?= @$Comment_In_Rate_Count ?> Lượt bình luận khi Rate</p>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer" id="buttonRateDetail" >Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
        </div><!-- /.row -->
    </div><!-- /.box-body -->

<?php
Modal::begin([
    'header' => '<h4>Chi tiết doanh thu theo điểm</h4>',
    'id' => 'modal1',
    'size' => 'modal-lg',
]);
echo '<div id="orderdetailContent">';?>
<?= $this->render('pricedetail', [
    //'model' => $model,
    'orderpriceDetail' => $orderpriceDetail,
    'posNameMap' => $posNameMap,
]) ?>
<?php echo '</div>';
Modal::end();
?>


<?php
Modal::begin([
    'header' => '<h4>Chi tiết bình chọn</h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo '<div id="modalContent">';?>
<?= $this->render('ratingdetail', [
    //'model' => $model,
    'oderRateSorted' => $oderRateSorted,
//    'rateArrayByStat' => $rateArrayByStat,
//    'rateArrayByReson' => $rateArrayByReson,
    'date_start' => $date_start,
    'date_end' => $date_end,
    'posNameMap' => $posNameMap,
]) ?>
<?php echo '</div>';
Modal::end();
?>


<?php
Modal::begin([
    'header' => '<h4>Tần suất khách đến nhà hàng</h4>',
    //'footer' => '<h4>Footer Detail</h4>',
    'id' => 'modal2',
    'size' => 'modal-lg',
]);
echo '<div id="memberdetailContent">';?>
<?= $this->render('memberdetail', [
    //'model' => $model,
    'newMember' => $newMember,
    'oldMember' => $oldMember,
    'allMember' => $allMember,
    //'posNameMap' => $posNameMap
]) ?>
<?php echo '</div>';
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Chi tiết bình luận</h4>',
    'id' => 'modal3',
    'size' => 'modal-lg',
]);
echo '<div id="commentContent">';
    echo $this->render('commentdetail', [
        'comment' => $comment
    ]);
echo '</div>';
Modal::end();
?>

<script>
//    $.ajax({
//        url: 'bootstrap/js/bootstrap.min.js',
//        dataType: "script"
//    });
    var checkAjax = '<?= @$checkAjax ?>';
    if(checkAjax){
        $.ajax({
            url: 'plugins/datatables/jquery.dataTables.min.js',
            dataType: "script"
        });

        $.ajax({
            url: 'plugins/datatables/dataTables.bootstrap.min.js',
            dataType: "script"
        });
    }

    var datelabel = '<?= $dateTextLabel ?>';
    if(datelabel != 'Hôm nay'){
        $('#btn_top').hide();
    }else{
        $('#btn_top').show();
    }

</script>

<style>
    .h3_custom{
        font-size: 28px;
        font-weight: bold;
        margin: 0 3px 10px 3px;
        padding: 0;
        white-space: nowrap;
    }

    #total_content{
        background-image: url("images/vnd.png");
        background-position: right bottom, left top;
        background-repeat: no-repeat, repeat;
    }
    #total_customer{
        background-image: url("images/people.png");
        background-position: right bottom, left top;
        background-repeat: no-repeat, repeat;
    }

    #rate_content{
        background-image: url("images/star.png");
        background-position: right bottom, left top;
        background-repeat: no-repeat, repeat;
    }
    #commnet_content{
        background-image: url("images/comment.png");
        background-position: right bottom, left top;
        background-repeat: no-repeat, repeat;
    }
</style>