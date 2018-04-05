<?php
//echo '<pre>';
//var_dump($allPos);
//echo '</pre>';
//die();

?>
<table id="poschoise" class="table table-bordered table-striped">
    <thead>
    <tr>
        <th width="60px">Chọn</th>
        <th>Nhà hàng</th>
        <th>Thành phố</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $tmpFb = 1;
    if($allPos != null){
        foreach($allPos as $key => $value){
            if($value['ID'] != $model->ID){
                echo '<tr>';
                echo '<td><input type="radio" name="pos" value="'.$value['ID'].'"></td>';
                echo '<td>'.$value['POS_NAME'].'</td>';
                echo '<td>'.$value['city']['CITY_NAME'].'</td>';
                echo '</tr>';
                $tmpFb++;
            }
        }
    }
    ?>
    </tbody>
</table>

<script type="text/javascript">
    $("#poschoise").DataTable();
</script>

