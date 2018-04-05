<?php

use backend\assets\AppAsset;
use yii\helpers\Url;


AppAsset::register($this);
$this->registerJsFile('js/html5shiv.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/respond.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('js/js-chart/fusioncharts.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/js-chart/themes/fusioncharts.theme.fint.js', ['position' => \yii\web\View::POS_HEAD]);
//Load js to draw chart
$this->registerJsFile('js/draw_chart.js', ['position' => \yii\web\View::POS_HEAD]);

$this->title = 'Thống kê tổng quan Pos Mobile';
//echo '<pre>';
//var_dump($data);
//echo '</pre>';
//die();
?>
<script type="text/javascript">
    <?php
        foreach($data as $key => $dataPosToChartJS){
        ?>
            //echo 'loadChart('.json_encode(array_values($dataPosToChartJS['datachart'])).','.json_encode($allDayToChart).','.$key.','.$key.')';
            loadChart(<?php echo json_encode(array_values($dataPosToChartJS['datachart']));?>,<?php echo json_encode($allDayToChart)?>,"<?php echo $dataPosToChartJS['POS_NAME']; ?>",'<?php echo 'div-id'.$key?>');
        <?php
        }
    ?>
</script>


<!-- Small boxes (Stat box) -->
<div class="row">
    <?php
        foreach($data as $key => $dataPos){

            if($key == 'allPos'){
                $bg = 'bg-green';
            }else{
                $bg = 'bg-aqua';
            }


            if($dataPos[$yesterday]['price'] == 0){
                $balanceYesterday = 100;
                $iconVsYesterday = 'fa-arrow-up';
            }else{
                $priceTodayVsYesterday = $dataPos[$today]['price']/$dataPos[$yesterday]['price']*100;
                if($priceTodayVsYesterday >= 100/* || $priceTodayVsYesterday == 100*/){
                    $iconVsYesterday = 'fa-arrow-up';
                }else{
                    $iconVsYesterday = 'fa-arrow-down';
                }
                $balanceYesterday = number_format($priceTodayVsYesterday - 100,1); // Tính phần dư
            }

            if($dataPos[$dateStartDay]['order'] || $dataPos[$dateStartDay]['price']){
                $iconVsLastWeek = 'fa-arrow-up';
                $balanceLastWeek = 100;
                $average = 0;
            }else{
                if($dataPos[$dateStartDay]['price']){
                    $priceTodayVsLastWeek = $dataPos[$today]['price']/$dataPos[$dateStartDay]['price']*100;
                }else{
                    $priceTodayVsLastWeek = 0;
                }

                if($dataPos[$today]['order']){
                    $average = $dataPos[$today]['price']/$dataPos[$today]['order'];
                }else{
                    $average = 0;
                }


                if($priceTodayVsLastWeek >= 100/* || $priceTodayVsYesterday == 100*/){
                    $iconVsLastWeek = 'fa-arrow-up';
                }else{
                    $iconVsLastWeek = 'fa-arrow-down';
                }
                $balanceLastWeek = number_format($priceTodayVsLastWeek - 100,1); // Tính phần dư
            }
            ?>

            <div class="col-lg-3 col-xs-12">
                <!-- small box -->
                <div class="small-box <?= $bg?>">
                    <div class="inner">
                        <p>Doanh thu <?= $dataPos["POS_NAME"]?></p>
                        <h3><?= number_format($dataPos[$today]['price']) ?></h3>
                        <p><i class="fa fa-bookmark"></i> <?= number_format($dataPos[$today]['order'])?> Đơn hàng  | <?=number_format($average)?> Đ/Đơn hàng</p>
                        <!--<p><i class="fa fa-bookmark"></i> <?/*= number_format($average)*/?> Đ/Đơn hàng</p>-->
                        <p><i class="fa <?= $iconVsYesterday ?>"></i> <?= $balanceYesterday ?> % vs hôm trước</p>
                        <p><i class="fa <?= $iconVsLastWeek ?>"></i> <?= $balanceLastWeek ?> % vs cùng ngày tuần trước</p>
                    </div>
                    <a href="<?= Url::to(['/saleposmobile/tabs-pos','id'=>57]) ?>" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
        <?php
        }
    ?>
</div><!-- /.row -->



<!--Row 2 -->
<div class="row">
    <!-- Left col -->

    <?php
        foreach($data as $keyView => $posDataView){
            if($keyView == 'allPos'){
                $bgBox = 'success';
            }else{
                $bgBox = 'primary';
            }

            ?>
            <section class="col-lg-4 connectedSortable ui-sortable">
                <!-- Chat box -->
                <div class="box box-<?=$bgBox?>  box-solid">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="fa fa-cart-plus"></i>
                        <h3 class="box-title"> <?= $posDataView['POS_NAME'] ?></h3>
                    </div>
                    <div id="<?= 'div-id'.$keyView?>"></div>
                </div><!-- ./col -->
            </section>
        <?php
        }
    ?>
</div> <!-- End Row 2 -->


