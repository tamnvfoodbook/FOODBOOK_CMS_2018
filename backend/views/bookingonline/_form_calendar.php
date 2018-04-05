<?php

use yii\helpers\Url;

use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('plugins/daterangepicker/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css', ['position' => \yii\web\View::POS_HEAD]);


/* @var $this yii\web\View */
/* @var $searchModel backend\models\BookingonlinelogSearch */
/* @var $allPosMap backend\controllers\BookingonlineController */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="col-md-3 col-md-offset-9">
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="reservation" readonly="readonly" value="<?= $timeRanger ?>"/>
    </div><!-- /.input group -->
</div>

<br>
<br>


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
            //'7 Ngày trước đây': [moment().subtract(7, 'days'), moment()],
            '7 Ngày trước đây': [moment().subtract(7, 'days'), moment().subtract(1, 'days')],
            //'30 Ngày trước đây': [moment().subtract(30, 'days'), moment()],
            '30 Ngày trước đây': [moment().subtract(30, 'days'), moment().subtract(1, 'days')],
            'Tháng này': [moment().startOf('month'), moment().endOf('month')],
            'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
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
            $.ajax({type: "GET",
                url: "<?= Url::toRoute('index')?>",
                data: { dateRanger: $("#reservation").val()},

                beforeSend: function() {
                    //that.$element is a variable that stores the element the plugin was called on
                    $("#booking_order").addClass("fb-grid-loading");
                },
                complete: function() {
                    //$("#modalButton").removeClass("loading");
                    $("#booking_order").removeClass("fb-grid-loading");
                },

                success:function(result){
                    $("#booking_order").html(result);
                }
            });
        };
    });
</script>
