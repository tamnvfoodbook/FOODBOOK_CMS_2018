<?php
use yii\helpers\Html;

$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('bootstrap/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/datatables/jquery.dataTables.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/datatables/dataTables.bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('bootstrap/css/bootstrap.min.css',['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('plugins/datatables/dataTables.bootstrap.css',['position' => \yii\web\View::POS_HEAD]);
//echo '<pre>';
////var_dump($allPos);
//var_dump($POS_ID);
//echo '</pre>';

?>
<table id="facebookdetail" class="table table-bordered table-striped">
    <thead>
    <tr>
        <th ><input type="checkbox" name="check_all[]" value="" id="selecctall"></th>
        <th>Nhà hàng</th>
        <th>Thành phố</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $tmpFb = 1;
    if($allPos != null){
        foreach($allPos as $key => $value){
            if($value['ID'] != $POS_ID){
                echo '<tr>';
                echo '<td><input type="checkbox" name="pos[]" value="'.$value['ID'].'" class="check_list"></td>';
                echo '<td>'.$value['POS_NAME'].'</td>';
                echo '<td>'.@$value['city']['CITY_NAME'].'</td>';
                echo '</tr>';
                $tmpFb++;
            }
        }
    }
    ?>
    </tbody>
</table>

<script type="text/javascript">
    //$('#facebookdetail').DataTable();

    var table = $("#facebookdetail").DataTable();

    $('#selecctall').click(function () {
        $(':checkbox', table.rows().nodes()).prop('checked', this.checked);
    });

    //////////////////////////////////////////
</script>

