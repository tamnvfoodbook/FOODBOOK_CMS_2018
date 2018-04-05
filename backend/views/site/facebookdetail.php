<?php
use backend\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

//$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('bootstrap/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/datatables/jquery.dataTables.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/datatables/dataTables.bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
//    $this->registerJsFile('plugins/slimScroll/jquery.slimscroll.min.js', ['position' => \yii\web\View::POS_HEAD]);
//    $this->registerJsFile('plugins/fastclick/fastclick.min.js', ['position' => \yii\web\View::POS_HEAD]);
//    $this->registerJsFile('dist/js/app.min.js', ['position' => \yii\web\View::POS_HEAD]);
//    $this->registerJsFile('dist/js/demo.js', ['position' => \yii\web\View::POS_HEAD]);

//$this->registerCssFile('bootstrap/css/bootstrap.min.css',['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('plugins/datatables/dataTables.bootstrap.css',['position' => \yii\web\View::POS_HEAD]);
//    $this->registerCssFile('dist/css/AdminLTE.min.css',['position' => \yii\web\View::POS_HEAD]);
//    $this->registerCssFile('dist/css/skins/_all-skins.min.css',['position' => \yii\web\View::POS_HEAD]);

//echo '<pre>';
//var_dump($facebookDetail);
//echo '</pre>';
?>



<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table id="facebookdetail" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Nhà hàng</th>
                    </tr>
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
    var customerFacebook = <?= json_encode(array_values((array)$facebookDetail)) ?>;
    dataTableCustomerBase("#facebookdetail",customerFacebook,"facebookShare");
</script>
