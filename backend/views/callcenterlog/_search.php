<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('bootstrap/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('plugins/daterangepicker/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);

//$this->registerJsFile('plugins/timepicker/bootstrap-timepicker.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/select2/select2.full.min.js', ['position' => \yii\web\View::POS_HEAD]);

//$this->registerCssFile('plugins/timepicker/bootstrap-timepicker.min.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css', ['position' => \yii\web\View::POS_HEAD]);


/* @var $this yii\web\View */
/* @var $model backend\models\PmpurchaseSearch */
/* @var $form yii\widgets\ActiveForm */
?>



<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'id' => 'searchTime'
]); ?>
<div class="no-padding" style="width: 180px">
    <input type="text" class="form-control" name="CallcenterlogSearch[dateTime]" id="reservation" readonly="readonly" value="<?= $timeRanger ?>"/>
</div>

<?php ActiveForm::end(); ?>

<script>
    var dp = {};
    function cb(start, end) {
        $('#reservation').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }

    cb(moment().subtract(0, 'days'), moment());

    dp = $('#reservation').daterangepicker({
        ranges: {
            'Hôm nay': [moment(), moment()],
            'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 Ngày trước đây': [moment().subtract(6, 'days'), moment()],
            '30 Ngày trước đây': [moment().subtract(29, 'days'), moment()],
            'Tháng này': [moment().startOf('month'), moment().endOf('month')],
            'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },opens: 'left',
        format: 'DD/MM/YYYY',
        locale: {
            "separator": " - ",
            "applyLabel": "Áp dụng",
            "cancelLabel": "Bỏ qua",
            "fromLabel": "Từ ngày",
            "toLabel": "Đến ngày",
            "customRangeLabel": "Tùy chọn"
//            "daysOfWeek": [
//                "Cn",
//                "Mo",
//                "Tu",
//                "We",
//                "Th",
//                "Fr",
//                "Sa"
//            ]
        }
    }, cb);


    dp.on('apply.daterangepicker',function(event,picker){
        $.fn.ajaxData();
    });

    $(document).ready(function() {

        $.fn.ajaxData = function() {
            //('#searchTime').submit();
            $("#searchTime").submit();
//            $.ajax({type: "GET",
//                url: "<?//= Url::toRoute('/saleposmobile/purchaseorder/')?>//",
//                data: {dateTime: $("#reservation").val(), checkAjax : 1,id : '<?//= @$id?>//'},
//
//                beforeSend: function() {
//                    //that.$element is a variable that stores the element the plugin was called on
//                    $("#table-body").addClass("fb-grid-loading");
//                },
//                complete: function() {
//                    //$("#modalButton").removeClass("loading");
//                    $("#table-body").removeClass("fb-grid-loading");
//                },
//
//                success:function(result){
//                    $("#table-body").html(result);
//                }
//            });
        }

    });
</script>
