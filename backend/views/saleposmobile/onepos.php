<?php
/**
 * Created by PhpStorm.
 * User: NguyenVanTam
 * Date: 11/3/2015
 * Time: 2:51 PM
 */
//echo $id;
//echo '<pre>';
//var_dump($data);
//echo '</pre>';
//die();
//$this->title = 'Nhà hàng'
//$this->params['breadcrumbs'][] = $this->title;$this->title = 'Nhà hàng'
//$this->params['breadcrumbs'][] = $this->title;

$this->title = 'Nhà hàng'/*.$model->id*/;
$this->params['breadcrumbs'][] = ['label' => 'Các nhà hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<BR>

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <p>Doanh thu nhà hàng trong ngày</p>
                <h3><?= number_format($data['foodbookData']['amount']
                        + $data['taData']['amount']
                        + $data['otsData']['amount'])?></h3>
                <p> <?= $data['foodbookData']['order'] + $data['taData']['order'] + $data['otsData']['order']?> Đơn hàng</p>
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
                <p>Doanh thu FB trong ngày</p>
                <h3><?= number_format($data['foodbookData']['amount'])?></h3>
                <p> <?= $data['foodbookData']['order']?> Đơn hàng</p>
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
                <p>Doanh thu bán mang về trong ngày</p>
                <h3><?= number_format($data['taData']['amount'])?></h3>
                <p> <?= $data['taData']['order']?> Đơn hàng</p>
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
                <p>Doanh thu bán tại chỗ trong ngày</p>
                <h3><?= number_format($data['otsData']['amount'])?></h3>
                <p> <?= $data['otsData']['order']?> Đơn hàng</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->


<!--Detail -->

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table id="member-detail" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Tên mặt hàng</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach((array)$data['dataItem'] as $key => $value){
                            echo '<tr>';
                            echo '<td>'.$value['item_name'].'</td><td>'.$value['quantity'].'</td><td>'.$value['amount'].'</td>';
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->

