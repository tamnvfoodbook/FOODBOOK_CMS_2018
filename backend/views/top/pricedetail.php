<?php 
    use backend\assets\AppAsset;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;

    $this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('bootstrap/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('plugins/datatables/jquery.dataTables.min.js', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('plugins/datatables/dataTables.bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('plugins/slimScroll/jquery.slimscroll.min.js', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('plugins/fastclick/fastclick.min.js', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('dist/js/app.min.js', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('dist/js/demo.js', ['position' => \yii\web\View::POS_HEAD]);

    $this->registerCssFile('bootstrap/css/bootstrap.min.css',['position' => \yii\web\View::POS_HEAD]);
    //$this->registerCssFile('https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',['position' => \yii\web\View::POS_HEAD]);
    //$this->registerCssFile('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',['position' => \yii\web\View::POS_HEAD]);
    $this->registerCssFile('plugins/datatables/dataTables.bootstrap.css',['position' => \yii\web\View::POS_HEAD]);
    $this->registerCssFile('dist/css/AdminLTE.min.css',['position' => \yii\web\View::POS_HEAD]);
    $this->registerCssFile('dist/css/skins/_all-skins.min.css',['position' => \yii\web\View::POS_HEAD]);
//    echo '<pre>';
//    var_dump($priceDetail);
//    echo '</pre>';
//    die();
?>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">     
          <div class="row">
            <div class="col-xs-12">
              <div class="box">                
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <?php
                          echo '<th> Tên nhà hàng\ Ngày </th>';
                          foreach ($allDay as $key => $value) {
                            echo '<th>'.date('D', strtotime($value)).'</th>';
                          }
                        ?>                        
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($priceDetail){
                          foreach ($priceDetail as $key => $value){
                              foreach($posObj as $posName){
                                  if($key == $posName['ID']){
                                      $key = $posName['POS_NAME'];
                                      break;
                                  }
                              }
                              echo '<tr>';
                              echo '<td>'.$key.'</td>';
                              foreach ($value as $key1 => $value1) {
                                  echo '<td>'.number_format($value1).'</td>';
                              }
                              echo '</tr>';
                          }
                      }
                      ?>
                    </tbody>                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->                     
    </div><!-- ./wrapper -->
    <script type="text/javascript">      
        $("#example1").DataTable({
            "language": {
                "lengthMenu": "Hiển thị _MENU_ kết quả",
                "zeroRecords": "Không có kết quả",
                "info": "Trang _PAGE_ trong tổng số  _PAGES_ trang",
                "infoEmpty": "Không có kết quả",
                "infoFiltered": "(lọc từ _MAX_ tổng số bản ghi)",
                "sSearch": "Tìm kiếm",
                "oPaginate": {
                    "sFirst": "Trang đầu",
                    "sLast": "Trang cuối",
                    "sNext": "Trang tiếp",
                    "sPrevious": "Trang trước"
                }
            }
        });
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
            "language": {
                "lengthMenu": "Hiển thị _MENU_ kết quả",
                "zeroRecords": "Không có kết quả",
                "info": "Trang _PAGE_ trong tổng số  _PAGES_ trang",
                "infoEmpty": "Không có kết quả",
                "infoFiltered": "(lọc từ _MAX_ tổng số bản ghi)",
                "sSearch": "Tìm kiếm",
                "oPaginate": {
                    "sFirst": "Trang đầu",
                    "sLast": "Trang cuối",
                    "sNext": "Trang tiếp",
                    "sPrevious": "Trang trước"
                }
            }
        });
    </script>
