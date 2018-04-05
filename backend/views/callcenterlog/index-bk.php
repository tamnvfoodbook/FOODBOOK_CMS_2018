<?php

use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/datatables/jquery.dataTables.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/datatables/dataTables.bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('bootstrap/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/slimScroll/jquery.slimscroll.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/fastclick/fastclick.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('dist/js/app.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('dist/js/demo.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/datatables/dataTables.bootstrap.css', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CallcenterlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Callcenterlogs';
$this->params['breadcrumbs'][] = $this->title;
?>

<br>
<div class="box">
<div class="box-header">
    <h3 class="box-title">Quản lý cuộc gọi</h3>
</div><!-- /.box-header -->
<div class="box-body">
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
    <th>Người gọi đến</th>
    <th>Số nhánh</th>
    <th>Thời gian bắt đầu</th>
    <!--<th>Thời điểm bắt đầu tính</th>-->
    <th>Thời gian thoại</th>
    <!--<th>Ghi âm cuộc gọi</th>-->
    <th>Pdd</th>
    <th>mos</th>
    <th>Trạng thái</th>
</tr>
</thead>
<tbody>

    <?php
        foreach($dataCallcenter as $record){
            echo '<tr>';
                echo '<td>'.$record['cid_name'].'</td>';
                echo '<td>'.$record['source'].'</td>';
                echo '<td>'.$record['start'].'</td>';
                /*echo '<td>'.$record['tta'].'</td>';*/
                echo '<td>'.$record['duration'].'</td>';
                //echo '<td><a href="'.$record['recording'].'">'.$record['recording'].'</td>';
                echo '<td>'.$record['pdd'].'</td>';
                echo '<td>'.$record['mos'].'</td>';
                echo '<td>'.$record['status'].'</td>';
            echo '</tr>';
        }
    ?>
</tbody>
<tfoot>
<tr>
    <th>Người gọi đến</th>
    <th>Số nhánh</th>
    <th>Thời gian bắt đầu</th>
    <!--<th>Thời điểm bắt đầu tính</th>-->
    <th>Thời gian thoại</th>
    <!--<th>Ghi âm cuộc gọi</th>-->
    <th>Pdd</th>
    <th>mos</th>
    <th>Trạng thái</th>
</tr>
</tfoot>
</table>
</div><!-- /.box-body -->
</div><!-- /.box -->

<!-- page script -->
<script type="text/javascript">
        $("#example1").DataTable(

        );
        /*$('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });*/

</script>

