<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
    use backend\assets\AppAsset;
AppAsset::register($this);

//$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/datatables/jquery.dataTables.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/datatables/dataTables.bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('js/custom_dataTable.js', ['position' => \yii\web\View::POS_HEAD]);
//
////$this->registerCssFile('dist/css/AdminLTE.min.css',['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('plugins/datatables/dataTables.bootstrap.css',['position' => \yii\web\View::POS_HEAD]);
//echo '<pre>';
//var_dump($allMember);
//echo '</pre>';
//die();
//$allMember = array_merge($newMember,$oldMember);
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table id="member-detail" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Nhà hàng</th>
                        <th>Hóa đơn có thông tin khách hàng</th>
                        <th>Tổng số hòa đơn</th>
                        <th>Tỉ lệ</th>
                    </tr>
                    </thead>

                    <tbody>
                        <?php
                            foreach((array)@$bills as $bill){
//                                echo '<pre>';
//                                var_dump($bill->dm_pos->Pos_Name);
//                                echo '</pre>';
//                                die();

                                echo '<tr>';
                                echo '<td>1</td>';
                                echo '<td>'.@$bill->dm_pos->Pos_Name.'</td>';
                                echo '<td>'.@$bill->Total_Bill_CheckIn.'</td>';
                                echo '<td>'.@$bill->Total_Bill.'</td>';
                                if(@$bill->Total_Bill){
                                    echo '<td>'.number_format(@$bill->Total_Bill_CheckIn/@$bill->Total_Bill*100 ).' %</td>';
                                }else{
                                    echo '<td>0</td>';
                                }
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->


