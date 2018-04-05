<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
    use backend\assets\AppAsset;
AppAsset::register($this);

//$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/datatables/jquery.dataTables.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/datatables/dataTables.bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/custom_dataTable.js', ['position' => \yii\web\View::POS_HEAD]);


//$this->registerCssFile('dist/css/AdminLTE.min.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/datatables/dataTables.bootstrap.css',['position' => \yii\web\View::POS_HEAD]);
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
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Số lần tới hệ thống</th>
                        <th>Nhà hàng</th>
                        <th>Loại khách</th>
                    </tr>
                    </thead>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->

<style>
    .info_member{
        display: none;
    }
</style>

<script type="text/javascript">
    var customer = <?= json_encode(array_values($allMember)) ?>;
    dataTable_customer("#member-detail",customer);
</script>
