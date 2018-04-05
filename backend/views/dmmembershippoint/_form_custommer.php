<?php
use yii\bootstrap\Modal;
use backend\assets\AppAsset;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use \yii\helpers\Html;

$this->registerCssFile('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('css/style_flip.css',['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('js/js-chart/fusioncharts.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/js-chart/themes/fusioncharts.theme.fint.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/morris/morris.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/knob/jquery.knob.js', ['position' => \yii\web\View::POS_HEAD]);


//Load js to draw chart
$this->registerJsFile('js/draw_chart.js', ['position' => \yii\web\View::POS_HEAD]);

//    echo '<pre>';
//    var_dump($visitFreequency);
//    echo '</pre>';
//    die();

$this->title = 'CRM khách hàng';
echo '<pre>';
var_dump(json_encode(array_values($totalCustomer)));
//var_dump(json_encode(array_values($amountStatis)));
echo '</pre>';
die();

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.js"></script>

<script type="text/javascript">
    drawChart_columCRM(<?php echo json_encode(array_values(@$totalCustomer));?>,'chart_customer');
    drawChart_columCRM(<?php echo json_encode(array_values(@$totalCustomer));?>,'chart_customer_byweek');
    /*drawChart_pietansuatCRM(<?php echo json_encode(array_values(@$totalCustomer));?>,'sales-chart1');*/
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
            chartArea:{left:50,top:0,width:'80%',height:'90%'},
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
//            pieHole: 0.4,
            legend: 'show',
//            chartArea:{width:'80%',height:'90%'},
            backgroundColor :  'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chartAmount'));
        chart.draw(data, options);
    }

</script>

<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <!-- small box -->
        <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
            <div class="flipper">
                <div class="front">
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h4><b>TỔNG SỐ KHÁCH HÀNG </b></h4>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                                <h3><span style="font-size: 100%;"><?= number_format(@$customer->block_total->quantity_of_user);?></span></h3>
                                <br>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                                <div class="pull-right text-right">
                                    <h3><span style="font-size: 100%;color: red"><?php echo number_format(@$customer->block_total->amount);?> &#8363;</span></h3>
                                </div>
                            </div>

                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 no-padding">
                                <div id="chart_customer""></div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 no-padding">
                            <div class="pull-right text-right">
                                <div class="inline"><b><?php echo number_format(@$customer->block_total->quantity_of_bill);?></b><br> hóa đơn </div>
                                <div class="inline"><div class="bill_icon"></div>
                                </div>
                                <br>
                                <br>
                                <div class="inline"><b><?php echo number_format(@$customer->block_total->avenger_bill);?></b><br>  &#8363;/hóa đơn</div>
                                <div class="inline"><div class="bill_monney_icon"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                </div>
                <div class="back col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding" style="height: 235px" >
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h4><b>KHÁCH HÀNG TĂNG TRƯỞNG THEO TUẦN </b></h4>
                                <div id="chart_customer_byweek" ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- ./col -->

    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-chart">
            <div class="inner">
                <h4><b>TẦN SUẤT KHÁCH ĐẾN ĂN</b></h4>
                <div id="tpoder_chart" style="width: 100%; height: 157px;"></div>
                <br>
            </div>
        </div>
    </div><!-- ./col -->

</div><!-- /.row -->

<!--Row 2 -->
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h4><b>KHÁCH ĂN 3 LẦN TRỞ LÊN</b></h4>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                    <h3><span style="font-size: 100%;"><?= number_format(@$customer->block_eat_over_3_time->quantity_of_user);?></span></h3>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                    <div class="pull-right text-right">
                        <h3><span style="font-size: 90%;color: red"><?php echo number_format(@$customer->block_eat_over_3_time->amount);?> &#8363;</span></h3>
                    </div>
                </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 no-padding">
                    <!--<div id="donut-chart" style="height: 150px; position: relative;"></div>-->
                <canvas id="chartThreeTime" width="100%" height="100%" style="margin-top: 0"></canvas>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 no-padding">
                <div class="pull-right text-right">
                    <div class="inline"><b><?php echo number_format(@$customer->block_eat_over_3_time->quantity_of_bill);?>( <?php echo number_format(@$customer->block_eat_over_3_time->percent_bills * 100);?>%)</b><br> hóa đơn </div>
                    <div class="inline"><div class="bill_icon"></div>
                    </div>
                    <br>
                    <br>
                    <div class="inline"><b><?php echo number_format(@$customer->block_eat_over_3_time->avenger_bill);?></b><br>  &#8363;/hóa đơn</div>
                    <div class="inline"><div class="bill_monney_icon"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            </div>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h4><b>KHÁCH ĂN 2 LẦN</b></h4>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                    <h3><span style="font-size: 90%;"><?= number_format(@$customer->block_eat_2_time->quantity_of_user);?></span></h3>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                    <div class="pull-right text-right">
                        <h3><span style="font-size: 90%;color: red"><?php echo number_format(@$customer->block_eat_2_time->amount);?> &#8363;</span></h3>
                    </div>
                </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 no-padding">
                <canvas id="chartTwoTime" width="100%" height="100%" style="margin-top: 0"></canvas>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 no-padding">
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
    </div><!-- ./col -->

    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h4><b>KHÁCH ĂN 1 LẦN</b></h4>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                    <h3><span style="font-size: 90%;"><?= number_format(@$customer->block_eat_1_time->quantity_of_user);?></span></h3>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                    <div class="pull-right text-right">
                        <h3><span style="font-size: 90%;color: red"><?php echo number_format(@$customer->block_eat_1_time->amount);?> &#8363;</span></h3>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 no-padding">
                    <canvas id="chartOneTime" width="100%" height="100%" style="margin-top: 0"></canvas>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 no-padding">
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
    </div><!-- ./col -->

</div><!-- /.row -->
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h4><b>PHÂN BỐ GIỚI TÍNH</b></h4>
                    <!--<div id="donut-chart" style="height: 150px; position: relative;"></div>-->
                <!--<canvas id="chartgender" ></canvas>-->
                <div id="chartgender"></div>
            </div>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h4><b>PHÂN BỐ ĐỘ TUỔI</b></h4>
                <div id="chartold" ></div>
            </div>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h4><b>PHÂN BỐ CHI TIÊU</b></h4>
                <canvas id="chartAmount" width="100%" height="100%" style="margin-top: 0"></canvas>
            </div>
        </div>
    </div><!-- ./col -->

</div><!-- /.row -->





<style>
    .total_customer{
        background-image: url("images/people2.png");
        background-position: left bottom, left top;
        background-repeat: no-repeat, repeat;
    }
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


    var valueGender = [<?= @$customer->gender_statistical->Male?>,<?= @$customer->gender_statistical->Female ?>,<?= @$customer->gender_statistical->Unknown?>];
    var labelGender = ['Nam','Nữ','Khác'];
//    drawKnob(valueGender,labelGender,'chartgender');

    
    var valueOld = [<?= @$customer->age_statistical->Data_Value?>,<?= @$customer->age_statistical->Female ?>,<?= @$customer->age_statistical->Unknown?>];
    var labelOld = ['Nam','Nữ','Khác'];
//    drawKnob(valueGender,labelGender,'chartold');


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

</script>


