<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


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
            data.addColumn('string', 'Week'); // Implicit domain label col.
            data.addColumn('number',name); // Implicit series 1 data col.
            data.addColumn({type:'number', role:'annotation'});  // interval role col.    
            data.addColumn('number',name); // Implicit series 1 data col.
            data.addColumn({type:'number', role:'annotation'});  // interval role col.      
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
      loadChart(<?php echo json_encode($arrayCoupon);?>,'Coupon','coupon_chart');
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

    <!--Hang so 3-->
   

<!--End Java Script-->

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
                  <h3><?php echo $orderOnline + $orderOffline;?></h3>
                  <p>Đơn hàng</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>53<sup style="font-size: 20px">%</sup></h3>
                  <p>Doanh thu</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>44</h3>
                  <p>Yêu thích</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>65</h3>
                  <p>Share Facebook</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
          <!-- Main row -->
          <div class="row">

            <!--Form xem top-->
            <?= $this->render('dmtop', [
                'model' => $model,
            ]) ?>
            <!--End form xem top-->

            <!--Form xem top-->
            <?= $this->render('compare', [
                'model' => $model,
            ]) ?>
            <!--End form xem top-->

            
           <!--Row 1 -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-4 connectedSortable ui-sortable">            
        <!-- Chat box -->
        <div class="box box-success">
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
        <div class="box box-success">
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
        <div class="box box-success">
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
        <div class="box box-success">
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
        <div class="box box-success">
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
        <div class="box box-success">
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
        <div class="box box-success">
          <div class="box-header ui-sortable-handle" style="cursor: move;">
            <i class="fa fa-comments-o"></i>
            <h3 class="box-title">Coupon</h3>
          </div>
          <div id="coupon_chart"></div>
        </div><!-- ./col -->               
      </section>
      <!-- End /.Left col -->

      <!-- center col -->
      <section class="col-lg-4 connectedSortable ui-sortable">            
        <!-- Chat box -->
        <div class="box box-success">
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
        <div class="box box-success">
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

 

    
    
