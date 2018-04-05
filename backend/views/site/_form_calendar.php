<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('plugins/daterangepicker/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css', ['position' => \yii\web\View::POS_HEAD]);
?>

<!--Button function-->
<div class="row">
    <!--<div class="col-md-2">
        <div id="btn_top">
            <?/*= Html::button( 'Top đầu' ,['class' => 'btn btn-success','onclick' => 'popupTopFunction();']); */?>
            <?/*= Html::button( 'Top cuối' ,['class' => 'btn btn-success','onclick' => 'popupBottomFunction();']); */?>
        </div>
    </div>

    <div class="col-md-7 no-padding" style="margin-top: 5px">
        <p id="topdiv" >
            <?php
/*            echo 'Chọn Top đầu:';
            for($countTop = $countIds; $countTop > 0; $countTop--){
                echo Html::a("$countTop", ['/top', 'top' => $countTop,'$bottom' => 0], ['class'=>'link-top']);
            }
            */?>
        </p>
        <p id="bottomdiv" >
            <?php
/*            echo 'Chọn Top cuối:';
            for($countBottom = $countIds; $countBottom > 0; $countBottom--){
                echo Html::a("$countBottom", ['/top','top' => 0, 'bottom' => $countBottom], ['class'=>'link-top']);
            }
            */?>
        </p>
    </div>-->

    <div class="col-md-3 col-md-offset-9">
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="reservation" readonly="readonly" value="<?= date('d/m/Y').' - '.date('d/m/Y') ?>"/>
        </div><!-- /.input group -->
    </div>
</div>
<br>

<style>
    #topdiv{
        display: none;
    }
    #bottomdiv{
        display: none;
    }
</style>

<script>
    //$('#reservation').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'DD/MM/YYYY'});

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
            var datechose =  $(".ranges ul li.active" ).text();

            $.ajax({type: "POST",
//                url: "<?//= Url::toRoute('/site')?>//",
                url: "<?= Url::toRoute('/site/index')?>",
                data: {dateRanger: $("#reservation").val(), checkAjax : 1, dateTextLabel: datechose},

                beforeSend: function() {
                    //that.$element is a variable that stores the element the plugin was called on
                    $("#sale_by_time").addClass("fb-grid-loading");
                },
                complete: function() {
                    //$("#modalButton").removeClass("loading");
                    $("#sale_by_time").removeClass("fb-grid-loading");
                },

                success:function(result){
                    $("#sale_by_time").html(result);
                }
            });
        }
    });
</script>



