<?php
    use backend\assets\AppAsset;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;

?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table id="price-detail" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Tên nhà hàng</th>
                          <th>Doanh thu</th>
                          <th>Đơn hàng</th>
                          <th>Bình quân doanh thu</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sumorder = 0;
                            $sumprice = 0;
                            foreach((array)$orderpriceDetail as $value){
                                echo '<tr>';
                                echo '<td>'.$posNameMap[$value->Pos_Id].'</td><td>'.number_format((int)$value->Amount).'</td><td>'.(int)$value->Order_Count.'</td>';
                                $sumprice = (int)$value->Amount + $sumprice;
                                $sumorder = (int)$value->Order_Count + $sumorder;
                                if($value->Order_Count){
                                    echo '<td>'.number_format($value->Amount/$value->Order_Count,0).'</td>';
                                }else{
                                    echo '<td>0</td>';
                                }
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                  <?php
                      echo '<tr>';
                      echo '<td><b>Tổng</b></td><td>'.number_format($sumprice,0).'</td><td>'.$sumorder.'</td>';
                      if($sumorder){
                          echo '<td>'.number_format($sumprice/$sumorder).'</td>';
                      }else{
                          echo '<td>0</td>';
                      }
                      echo '</tr>';
                      ?>
              </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->


<script type="text/javascript">
    $("#price-detail").DataTable({
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
