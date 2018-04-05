<?php
    if($complete){
        //echo '<h5 class="col-sm-12 control-label">Số đơn hàng thành công: '.count($complete).'</h5>';
    }
    $sum_fail = 0;
    if($failed != null || $cancelled != null || $assigning != null || $accepted != null || $in_process != null || $wait_confirm != null || $comfirmed != null){
        $sum_fail = count($failed) + count($cancelled) + count($assigning) + count($accepted) + count($in_process) + count($wait_confirm) + count($comfirmed);
        //echo '<h5 class="col-sm-12 control-label">Số đơn hàng chưa thành công: '.$sum_fail.'</h5>';
    }
    ?>
    <table class="table table-striped table-bordered detail-view">
        <tbody>
        <tr>
            <th width="65%">Tổng số đơn hàng</th>
            <td width="35%"><?= $total?></td>
        </tr>
        <tr>
            <th>Số đơn hàng thành công</th>
            <td><?= count($complete) ?></td>
        </tr>
        <tr>
            <th>Số đơn hàng chưa thành công</th>
            <td><?= $sum_fail?></td>
        </tr>
        </tbody>
    </table>
