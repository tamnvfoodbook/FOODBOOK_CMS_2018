<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
use yii\bootstrap\Modal;
use backend\assets\AppAsset;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use \yii\helpers\Html;

$this->registerCssFile('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('js/js-chart/fusioncharts.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/js-chart/themes/fusioncharts.theme.fint.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('plugins/knob/jquery.knob.js', ['position' => \yii\web\View::POS_HEAD]);


//Load js to draw chart
$this->registerJsFile('js/draw_chart.js', ['position' => \yii\web\View::POS_HEAD]);

$this->title = 'Biểu đồ khách hàng';
//echo '<pre>';
//var_dump(json_encode(array_values($oldArr)));
//var_dump(json_encode(array_values($amountStatis)));
//echo '</pre>';
//die();

?>

<script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.js"></script>

<script type="text/javascript">
    drawChart_columCRM(<?php echo json_encode(array_values(@$totalCustomer));?>,'chart_customer');
    drawChart_columCRM(<?php echo json_encode(array_values(@$weekChart['Up_First_Time']));?>,'chart_customer_byweek');
    drawChart_columCRM(<?php echo json_encode(array_values(@$weekChart['Up_More_Times']));?>,'chart_customer_3time');
    drawChart_columCRM(<?php echo json_encode(array_values(@$weekChart['Up_Third_Times']));?>,'chart_customer_more2time');
    drawChart_columCRM(<?php echo json_encode(array_values(@$weekChart['Up_Second_Times']));?>,'chart_customer_more1time');
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart(){
        var data = google.visualization.arrayToDataTable(<?php echo json_encode(array_values($visitFreequency));?>);
        var options = {
            //title: 'My Daily Activities'
            pieHole: 0.4,
            legend: 'show',
            chartArea:{left:0,top:0,width:'100%',height:'90%'},
            backgroundColor :  'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('tpoder_chart'));
        chart.draw(data, options);
    }


    google.charts.setOnLoadCallback(drawChart1);
    function drawChart1(){

        var data = google.visualization.arrayToDataTable(<?php echo json_encode(array_values($genderJson));?>);
        console.log(data);
        var options = {
            //title: 'My Daily Activities'
            pieHole: 0.4,
            legend: 'show',
//            chartArea:{width:'80%',height:'90%'},
            backgroundColor :  'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chartgender'));
        chart.draw(data, options);
    }
    google.charts.setOnLoadCallback(drawChartOld);
    function drawChartOld(){

        var data = google.visualization.arrayToDataTable(<?php echo json_encode(array_values($oldArr));?>);
        console.log(data);
        var options = {
            //title: 'My Daily Activities'
            pieHole: 0.4,
            legend: 'show',
//            chartArea:{width:'80%',height:'90%'},
            backgroundColor :  'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chartold'));
        chart.draw(data, options);
    }
    google.charts.setOnLoadCallback(drawChartAmountStatis);
    function drawChartAmountStatis(){
        var data = google.visualization.arrayToDataTable(<?php echo json_encode(array_values($amountStatis));?>);
        console.log(data);
        var options = {
            //title: 'My Daily Activities'
            pieHole: 0.4,
            legend: 'show',
//            chartArea:{width:'80%',height:'90%'},
            backgroundColor :  'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chartAmount'));
        chart.draw(data, options);
    }

    google.charts.setOnLoadCallback(drawChartSource);
    function drawChartSource(){
        var data = google.visualization.arrayToDataTable(<?php echo json_encode(array_values($sourceJson));?>);
        console.log(data);
        var options = {
            //title: 'My Daily Activities'
            pieHole: 0.4,
            legend: 'show',
//            chartArea:{width:'80%',height:'90%'},
            backgroundColor :  'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chartSource'));
        chart.draw(data, options);
    }


    $("#card").flip();
</script>


<div class="row">
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 ">
        <!-- small box -->
        <div class="flipper">
            <div class="front">
                <div class="small-box bg-white">
                    <div class="inner">
                        <h4><b>TỔNG SỐ KHÁCH HÀNG </b></h4>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-9 col-xs-9">
                                <h3><span style="font-size: 100%;"><?= number_format(@$customer->block_total->quantity_of_user);?></span></h3>
                                <br>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-3 col-xs-3">
                                <div class="pull-right text-right">
                                    <h3><span style="font-size: 100%;color: red"><?php echo number_format(@$customer->block_total->amount);?> &#8363;</span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div id="chart_customer""></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="pull-right text-right">
                                    <div class="inline"><b><?php echo number_format(@$customer->block_total->quantity_of_bill);?></b><br> hóa đơn </div>
                                    <div class="inline"><div class="bill_icon"></div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="inline"><b><?php echo number_format(@$customer->block_total->avenger_bill);?></b><br>  &#8363;/hóa đơn</div>
                                    <div class="inline">
                                        <div class="bill_monney_icon"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="back col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding bg-white" style="height: 235px;" >
            <div class="small-box bg-white">
                <div class="inner" >
                    <h4><b>KHÁCH HÀNG TĂNG TRƯỞNG THEO TUẦN </b></h4>
                    <div id="chart_customer_byweek" style="margin-top: 52px"></div>
                </div>
            </div>
        </div>
    </div>
    </div><!-- ./col -->

    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-chart">
            <div class="inner">
                <h4><b>TẦN SUẤT KHÁCH ĐẾN ĂN</b></h4>
                <div id="tpoder_chart" style="width: 100%; height: 157px;"></div>
                <br>
            </div>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-chart">
            <div class="inner">
                <h4><b>TOP 5 KHÁCH HÀNG</b></h4>
                <table class="table">
                    <tbody>
                    <?php
                    $stt = 1;
                    foreach((array)@$customer->top_members_amount as $value){
                        /*echo '<pre>';
                        var_dump($value);
                        echo '</pre>';
                        die();*/
                        echo '<tr>';
                            echo '<td>'.$stt.'</td>';
                            echo '<td>'.$value->member_name.'</td>';
                            echo '<td>'.$value->membership_id.'</td>';
                            echo '<td>'.number_format($value->amount).' đ</td>';
                            echo '<td>'.number_format($value->eat_count).' lần</td>';
                        echo '</tr>';
                        $stt++;
                        if($stt == 6) break;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->

<!--Row 2 -->
<div class="row">
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 " >
        <div class="flipper">
            <div class="front">
                <div class="small-box bg-white">
                    <div class="inner">
                        <h4><b>KHÁCH ĂN 3 LẦN TRỞ LÊN</b></h4>
                        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6 no-padding">
                            <h3><span style="font-size: 100%;"><?= number_format(@$customer->block_eat_over_3_time->quantity_of_user);?></span></h3>
                            <br>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding">
                            <div class="pull-right text-right">
                                <h3><span style="font-size: 90%;color: red"><?php echo number_format(@$customer->block_eat_over_3_time->amount);?> &#8363;</span></h3>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                            <div style="height: 80%; width: 80%" >
                                <canvas id="chartThreeTime"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                            <div class="pull-right text-right">
                                <div class="inline">
                                    <b><?php echo number_format(@$customer->block_eat_over_3_time->quantity_of_bill);?>( <?php echo number_format(@$customer->block_eat_over_3_time->percent_bills * 100);?>%)</b><br> hóa đơn
                                </div>
                                <div class="inline">
                                    <div class="bill_icon"></div>
                                </div>
                                <br>
                                <br>
                                <div class="inline"><b><?php echo number_format(@$customer->block_eat_over_3_time->avenger_bill);?></b><br>  &#8363;/hóa đơn</div>
                                <div class="inline">
                                    <div class="bill_monney_icon"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>


            <div class="back" style="height: 235px;">
                <div class="small-box bg-white">
                    <div class="inner" >
                        <h4><b>KHÁCH ĂN TRÊN 3 LẦN VÀ ĂN THÊM </b></h4>
                        <div id="chart_customer_3time" width="100%" height="100%" style="margin-top: 48px"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- small box -->
    </div><!-- ./col -->


    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 ">
        <div class="flipper">
            <div class="front">
                <div class="small-box bg-white">
                    <div class="inner">
                        <h4><b>KHÁCH ĂN 2 LẦN</b></h4>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">
                                <h3><span style="font-size: 90%;"><?= number_format(@$customer->block_eat_2_time->quantity_of_user);?></span></h3>
                                <br>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <div class="pull-right text-right">
                                    <h3><span style="font-size: 90%;color: red"><?php echo number_format(@$customer->block_eat_2_time->amount);?> &#8363;</span></h3>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                            <div style="height: 80%; width: 80%" >
                                <canvas id="chartTwoTime" style="margin-top: 0"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                            <div class="pull-right text-right">
                                <div class="inline"><b><?php echo number_format(@$customer->block_eat_2_time->quantity_of_bill);?>( <?php echo number_format(@$customer->block_eat_2_time->percent_bills * 100);?>%)</b><br> hóa đơn </div>
                                <div class="inline"><div class="bill_icon"></div>
                                </div>
                                <br>
                                <br>
                                <div class="inline"><b><?php echo number_format(@$customer->block_eat_2_time->avenger_bill);?></b><br>  &#8363;/hóa đơn</div>
                                <div class="inline"><div class="bill_monney_icon"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="back" style="height: 235px;">
                <div class="small-box bg-white">
                    <div class="inner" >
                        <h4><b>KHÁCH ĂN TRÊN 2 LẦN VÀ ĂN THÊM </b></h4>
                        <div id="chart_customer_more2time" width="100%" height="100%" style="margin-top: 48px"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- small box -->
    </div><!-- ./col -->


    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 ">
        <div class="flipper">
            <div class="front">
                <div class="small-box bg-white">
                    <div class="inner">
                        <h4><b>KHÁCH ĂN 1 LẦN</b></h4>
                        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6 no-padding">
                            <h3><span style="font-size: 90%;"><?= number_format(@$customer->block_eat_1_time->quantity_of_user);?></span></h3>
                            <br>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding">
                            <div class="pull-right text-right">
                                <h3><span style="font-size: 90%;color: red"><?php echo number_format(@$customer->block_eat_1_time->amount);?> &#8363;</span></h3>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                            <div style="height: 80%; width: 80%" >
                                <canvas id="chartOneTime" style="margin-top: 0"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                            <div class="pull-right text-right">
                                <div class="inline"><b><?php echo number_format(@$customer->block_eat_1_time->quantity_of_bill);?>( <?php echo number_format(@$customer->block_eat_1_time->percent_bills * 100);?>%)</b><br> hóa đơn </div>
                                <div class="inline"><div class="bill_icon"></div>
                                </div>
                                <br>
                                <br>
                                <div class="inline"><b><?php echo number_format(@$customer->block_eat_1_time->avenger_bill);?></b><br>  &#8363;/hóa đơn</div>
                                <div class="inline"><div class="bill_monney_icon"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="back" style="height: 235px;">
                <div class="small-box bg-white">
                    <div class="inner" >
                        <h4><b>KHÁCH ĂN TRÊN 1 LẦN VÀ ĂN THÊM </b></h4>
                        <div id="chart_customer_more1time" width="100%" height="100%" style="margin-top: 48px"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- small box -->
    </div><!-- ./col -->
</div><!-- /.row -->


<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h4><b>PHÂN BỐ GIỚI TÍNH</b></h4>
                <div id="chartgender"></div>
            </div>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h4><b>PHÂN BỐ ĐỘ TUỔI</b></h4>
                <div id="chartold" style="height: 100%;width: 100%"></div>
            </div>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 ">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h4><b>PHÂN BỐ CHI TIÊU</b></h4>
                <div id="chartAmount"></div>
            </div>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 ">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h4><b>PHÂN BỐ NGUỒN</b></h4>
                <div id="chartSource"></div>
            </div>
        </div>
    </div><!-- ./col -->

</div><!-- /.row -->


<style>
    .bg-chart{
        background-image: url("images/bg_chart.jpg");
        background-repeat: no-repeat, repeat;
        color: #fff;
    }
    .bill_icon{
        height: 39px;
        width: 50px;
        padding-top: 5px;
        background-image: url("images/bill.png");
        background-repeat: no-repeat, repeat;
    }
    .bill_monney_icon{
        height: 39px;
        width: 50px;
        padding-top: 5px;
        background-image: url("images/bill_monney.png");
        background-repeat: no-repeat, repeat;
    }
    .bg-white {
        background-color: #FFF !important;
        color: #8b8b8b !important;
    }
    .inline{
        vertical-align: text-top;
        display: inline-block;
        margin-left: 5px;
    }

</style>



<script type="text/javascript">

    var value1Time = [<?= @$customer->block_eat_1_time->quantity_of_user?>,<?= @$customer->block_total->quantity_of_user - @$customer->block_eat_1_time->quantity_of_user?>];
    var label1Time = ['Khách ăn 1 lần','Khác'];
    drawKnob(value1Time,label1Time,'chartOneTime');

    var value2Time = [<?= @$customer->block_eat_2_time->quantity_of_user?>,<?= @$customer->block_total->quantity_of_user - @$customer->block_eat_2_time->quantity_of_user?>];

    var label2Time = ['Khách ăn 2 lần','Khác'];
    drawKnob(value2Time,label2Time,'chartTwoTime');

    var value3Time = [<?= @$customer->block_eat_over_3_time->quantity_of_user?>,<?= @$customer->block_total->quantity_of_user - @$customer->block_eat_over_3_time->quantity_of_user?>];

    var label3Time = ['Khách ăn trên 3 lần','Khác'];
    drawKnob(value3Time,label3Time,'chartThreeTime');



    function drawKnob(valueArr,labelArr,divid){
        var data = {
            labels: labelArr,
            datasets: [
                {
                    data: valueArr,
                    backgroundColor: ["#3cb879","#5888ae"]
                }]
        };


        Chart.pluginService.register({
            beforeDraw: function(chart) {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx,
                    type = chart.config.type;

                if (type == 'doughnut')
                {
                    var percent = Math.round((chart.config.data.datasets[0].data[0] * 100) /
                    (chart.config.data.datasets[0].data[0] +
                    chart.config.data.datasets[0].data[1]));
                    var oldFill = ctx.fillStyle;
                    var fontSize = ((height - chart.chartArea.top) / 100).toFixed(2);

                    ctx.restore();
                    ctx.font = fontSize + "em sans-serif";
                    ctx.textBaseline = "middle"

                    var text = percent + "%",
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = (height + chart.chartArea.top) / 2;

                    ctx.fillStyle = chart.config.data.datasets[0].backgroundColor[0];
                    ctx.fillText(text, textX, textY);
                    ctx.fillStyle = oldFill;
                    ctx.save();
                }
            }
        });

        var myChart = new Chart(document.getElementById(divid), {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                legend: {
                    display: false
                }
            }
        });
    }

    $(".flipper").flip();

</script>
<style>
    td{
        font-size: 11px;
        font-weight: 100;

    }
    tr{
        margin-bottom: 5px;
    }
</style>