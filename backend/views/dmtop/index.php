
    <!-- Script Line chart Đơn hàng -->        
    <script type="text/javascript"
          src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
          }"></script>

    <script type="text/javascript">
      google.setOnLoadCallback(drawChart_orderOnline);
      function drawChart_orderOnline(){
        var data = new google.visualization.DataTable();
          data.addColumn('string', 'Week'); // Implicit domain label col.
          data.addColumn('number', 'Đơn hàng Online'); // Implicit series 1 data col.
          data.addColumn({type:'number', role:'annotation'});  // interval role col.      
          data.addRows(<?php echo json_encode($arrayOrderOnline);?>);

        var options = {
          title: '',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('orderOnline_chart1'));

        chart.draw(data, options);
      }
    </script>
    <!--End Script Line Chart Đơn hàng Online-->

    

    <!-- Script Line chart Đơn hàng Ofline -->            
    <script type="text/javascript">
      google.setOnLoadCallback(drawChart_order);

      function drawChart_order() {
        var data = new google.visualization.DataTable();
          data.addColumn('string', 'Month'); // Implicit domain label col.
          data.addColumn('number', 'Sales'); // Implicit series 1 data col.
          data.addColumn({type:'number', role:'annotation'});  // interval role col.      
          data.addRows(<?php echo json_encode($arrayOrderOffline);?>);

        var options = {
          title: '',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('orderOffline_chart'));

        chart.draw(data, options);
      }
    </script>
    <!--End Script Line Chart Đơn hàng Offline-->

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

    <!--Doanh số-->
    <!-- Script Line chart Doanh số Online-->
    <script type="text/javascript">
      google.setOnLoadCallback(drawChart_priceOnline);

      function drawChart_priceOnline() {
        var data = new google.visualization.DataTable();
          data.addColumn('string', 'Tuần'); // Implicit domain label col.
          data.addColumn('number', 'Doanh số Online'); // Implicit series 1 data col.
          data.addColumn({type:'number', role:'annotation'});  // interval role col.      
          data.addRows(<?php echo json_encode($arrayPriceOnline);?>);

        var options = {
          title: '',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('priceOnline_chart'));

        chart.draw(data, options);
      }
    </script>
    <!--End Script Line Chart Doanh số Online-->

    <!-- Script Line chart Offline Ofline -->            
    <script type="text/javascript">
      google.setOnLoadCallback(drawChart_priceOffline);

      function drawChart_priceOffline() {
        var data = new google.visualization.DataTable();
          data.addColumn('string', 'Month'); // Implicit domain label col.
          data.addColumn('number', 'Sales'); // Implicit series 1 data col.
          data.addColumn({type:'number', role:'annotation'});  // interval role col.      
          data.addRows(<?php echo json_encode($arrayPriceOffline);?>);

        var options = {
          title: '',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('priceOffline_chart'));

        chart.draw(data, options);
      }
    </script>
    <!--End Script Line Chart Đơn hàng Offline-->

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
    <!-- Script Line chart Doanh số Online-->
    <script type="text/javascript">
      google.setOnLoadCallback(drawChart_coupon);

      function drawChart_coupon() {
        var data = new google.visualization.DataTable();
          data.addColumn('string', 'Tuần'); // Implicit domain label col.
          data.addColumn('number', 'Đơn hàng Online'); // Implicit series 1 data col.
          data.addColumn({type:'number', role:'annotation'});  // interval role col.      
          data.addRows(<?php echo json_encode($arrayCoupon);?>);

        var options = {
          title: '',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('coupon_chart'));

        chart.draw(data, options);
      }
    </script>
    <!--End Script Line Chart Doanh số Online-->

    <!-- Script Line chart Offline Ofline -->            
    <script type="text/javascript">
      google.setOnLoadCallback(drawChart_shareFacebook);

      function drawChart_shareFacebook() {
        var data = new google.visualization.DataTable();
          data.addColumn('string', 'Month'); // Implicit domain label col.
          data.addColumn('number', 'Sales'); // Implicit series 1 data col.
          data.addColumn({type:'number', role:'annotation'});  // interval role col.      
          data.addRows(<?php echo json_encode($arrayShareFB);?>);

        var options = {
          title: '',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('shareFacebook_chart'));

        chart.draw(data, options);
      }
    </script>
    <!--End Script Line Chart Đơn hàng Offline-->

    <!-- Script line wishList-->
    <script type="text/javascript">
      google.setOnLoadCallback(drawChart_wishlist);

      function drawChart_wishlist() {
        var data = new google.visualization.DataTable();
          data.addColumn('string', 'Month'); // Implicit domain label col.
          data.addColumn('number', 'Sales'); // Implicit series 1 data col.
          data.addColumn({type:'number', role:'annotation'});  // interval role col.      
          data.addRows(<?php echo json_encode($arrayWishlist);?>);
          
        var options = {
          title: '',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('wishlist_chart'));

        chart.draw(data, options);
      }
    </script>
    <!-- Script line wishList -->

  <!--<body class="skin-blue sidebar-mini">-->
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
                  <p>Coupon</p>
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
                  <p>Thành phần đơn hàng</p>
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

            <!--Hàng thong ke so mot-->
            <!-- Thong ke don hang Online -->
            <section class="col-lg-4 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">                  
                  <li class="pull-left header"><i class="fa fa-inbox"></i>Đơn hàng online</li>
                </ul>
                <div class="tab-content no-padding">
                  <div id="orderOnline_chart" style="width:330px; height: 220px"></div>
                </div>
              </div><!-- /.nav-tabs-custom -->
            </section><!-- /.Left col -->
            <!-- End Thong ke don hang Online -->

            <!-- Thong ke don hang Offline -->
            <section class="col-lg-4 connectedSortable">
                  <!-- Custom tabs (Charts with tabs)-->
                  <div class="nav-tabs-custom">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right">                  
                      <li class="pull-left header"><i class="fa fa-inbox"></i>Đơn hàng offilne</li>
                    </ul>
                    <div class="tab-content no-padding">
                      <!-- Morris chart - Sales -->
                      <div id="orderOffline_chart" style="width:330px; height: 220px"></div>
                    </div>
                  </div><!-- /.nav-tabs-custom -->
            </section><!-- /.Left col -->
            <!-- End Thong ke don hang Offline -->

            <!-- Thành phần đơn hàng-->
            <section class="col-lg-4 connectedSortable1">
              <!-- Map box -->
              <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range"><i class="fa fa-calendar"></i></button>
                    <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->
                  <!--Visitors or Checkin-->                  
                  <h3 class="box-title">Tỉ lệ đơn hàng</h3>
                </div>
                <div class="box-body">
                  <div id="tpoder_chart" style="height: 200px; width: 100%;"></div>                  
                </div><!-- /.box-body-->                
              </div>
              <!-- /.box -->
            </section><!-- right col -->
            <!--Hàng thong ke so 2 - Thống ke doanh số-->
            <!-- Thong ke Doanh số Online -->
            <section class="col-lg-4 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">                  
                  <li class="pull-left header"><i class="fa fa-inbox"></i>Doanh số online</li>
                </ul>
                <div class="tab-content no-padding">
                  <div id="priceOnline_chart" style="width:330px; height: 220px"></div>
                </div>
              </div><!-- /.nav-tabs-custom -->
            </section><!-- /.Left col -->
            <!-- End Thong ke don hang Online -->

            <!-- Thong ke don hang Offline -->
            <section class="col-lg-4 connectedSortable">
                  <!-- Custom tabs (Charts with tabs)-->
                  <div class="nav-tabs-custom">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right">                  
                      <li class="pull-left header"><i class="fa fa-inbox"></i>Doanh số offilne</li>
                    </ul>
                    <div class="tab-content no-padding">
                      <!-- Morris chart - Sales -->
                      <div id="priceOffline_chart" style="width:330px; height: 220px"></div>
                    </div>
                  </div><!-- /.nav-tabs-custom -->
            </section><!-- /.Left col -->
            <!-- End Thong ke don hang Offline -->

            <!-- Thành phần đơn hàng-->
            <section class="col-lg-4 connectedSortable1">
              <!-- Map box -->
              <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range"><i class="fa fa-calendar"></i></button>
                    <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->
                  <!--Visitors or Checkin-->                  
                  <h3 class="box-title">Thành phần đơn hàng</h3>
                </div>
                <div class="box-body">
                  <div id="tpPrice_pie" style="height: 200px; width: 100%;"></div>                  
                </div><!-- /.box-body-->                
              </div>
              <!-- /.box -->
            </section><!-- right col -->


            <!--Hàng thong ke so 3 - Thống kê Coupon/ Share Facebook/ Yêu thích-->
            <!-- Thong ke Doanh số Online -->
            <section class="col-lg-4 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">                  
                  <li class="pull-left header"><i class="fa fa-inbox"></i>Coupon</li>
                </ul>
                <div class="tab-content no-padding">
                  <div id="coupon_chart" style="width:330px; height: 220px"></div>
                </div>
              </div><!-- /.nav-tabs-custom -->
            </section><!-- /.Left col -->
            <!-- End Thong ke don hang Online -->

            <!-- Thong ke don hang Offline -->
            <section class="col-lg-4 connectedSortable">
                  <!-- Custom tabs (Charts with tabs)-->
                  <div class="nav-tabs-custom">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right">                  
                      <li class="pull-left header"><i class="fa fa-inbox"></i>Share Facebook</li>
                    </ul>
                    <div class="tab-content no-padding">
                      <!-- Morris chart - Sales -->
                      <div id="shareFacebook_chart" style="width:330px; height: 220px"></div>
                    </div>
                  </div><!-- /.nav-tabs-custom -->
            </section><!-- /.Left col -->
            <!-- End Thong ke don hang Offline -->

            <!-- Thành phần đơn hàng-->
            <section class="col-lg-4 connectedSortable1">
              <!-- Map box -->
              <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header">
                  <!-- tools box -->  
                  <div class="pull-right box-tools">
                    <button class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range"><i class="fa fa-calendar"></i></button>
                    <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->
                  <!--Visitors or Checkin-->                  
                  <h3 class="box-title">Yêu thích</h3>
                </div>
                <div class="box-body">
                  <div id="wishlist_chart" style="height: 200px; width: 100%;"></div>                  
                </div><!-- /.box-body-->                
              </div>
              <!-- /.box -->
            </section><!-- right col -->





          </div><!-- /.row (main row) -->          
        </section><!-- /.content -->        
          </div><!-- /.row (main row) -->          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->  
    </div><!-- ./wrapper -->

 

    
    
