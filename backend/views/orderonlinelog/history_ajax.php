<div class="box-body">
    <div class="form-group">
        <label class="col-sm-12 control-label clearfix">Lịch sử giao dịch: <?=  $total ?> đơn hàng</label>
        <?php
        if($complete){
            echo '<h5 class="col-sm-12 control-label">Số đơn hàng thành công: '.count($complete).'</h5>';
        }
        if($failed){
            echo '<h5 class="col-sm-12 control-label">Số đơn hàng thất bại: '.count($failed).'</h5>';
        }
        if($cancelled){
            echo '<h5 class="col-sm-12 control-label">Số đơn hàng hủy: '.count($cancelled).'</h5>';
        }
        if($assigning){
            echo '<h5 class="col-sm-12 control-label">Số đơn hàng đang chờ tài xế: '.count($assigning).'</h5>';
        }
        if($accepted){
            echo '<h5 class="col-sm-12 control-label">Số đơn hàng nhà hàng đã chấp nhận: '.count($accepted).'</h5>';
        }
        if($in_process){
            echo '<h5 class="col-sm-12 control-label">Số đơn hàng tài xế đang vận chuyển: '.count($in_process).'</h5>';
        }
        if($wait_confirm){
            echo '<h5 class="col-sm-12 control-label">Số đơn hàng đang chờ được xác nhận: '.count($wait_confirm).'</h5>';
        }
        if($comfirmed){
            echo '<h5 class="col-sm-12 control-label">Số đơn hàng đã được xác nhận: '.count($comfirmed).'</h5>';
        }
        ?>
    </div>
</div><!-- /.box-body -->