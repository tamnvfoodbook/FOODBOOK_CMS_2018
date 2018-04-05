<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;

use backend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $model backend\models\PmpurchaseSearch */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin([
    'method' => 'get',
    'id' => 'searchTime'
]); ?>

<!-- START PROGRESS BARS -->
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid ">
            <div class="box-header with-border">
                <h3 class="box-title">Công cụ lọc</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-3">
                    <label>Ngày sử dụng</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" name="DmvoucherlogSearch[DATE_HASH]" id="dmvoucherlogsearch-date_hash" readonly="readonly" value="<?= $model->DATE_HASH?>"/>
                        <!--<input type="text" class="form-control pull-right" name="DmvoucherlogSearch[DATE_HASH]" id="reservation" readonly="readonly" value="<?/*= @$timeRanger */?>"/>-->
                    </div><!-- /.input group -->
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'VOUCHER_CAMPAIGN_ID')->widget(Select2::classname(), [
                        'data' => $allCampaginMap,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Chọn..'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>

                <!--<div class="col-md-3">
                    <?/*= $form->field($model, 'USED_DATE')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Ngày sử dụng...'],
                        'pluginOptions' => [
                            'autoclose'=>true
                        ]
                    ]);
                    */?>
                </div>-->


                <!--<div class="col-md-2">
                    <?/*= $form->field($model, 'STATUS')->widget(Select2::classname(), [
                        'data' => Yii::$app->params['VOUCHER_LOG_STATUS'],
                        'language' => 'en',
                        'options' => ['placeholder' => 'Chọn..'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    */?>
                </div>-->

                <div class="col-md-2">
                    <?= $form->field($model, "USED_DATE")->checkbox(['label' => false])->label('Sử dụng cùng ngày'); ?>
                </div>


                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">Lọc báo cáo</button>
                    </div>
                </div>

            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div><!-- /.row -->
<!-- END PROGRESS BARS -->


<?php ActiveForm::end(); ?>

<script>
    var dp = {};
    function cb(start, end) {
        $('#dmvoucherlogsearch-date_hash').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }

    cb(moment().subtract(0, 'days'), moment());

    dp = $('#dmvoucherlogsearch-date_hash').daterangepicker({
        ranges: {
            'Hôm nay': [moment(), moment()],
            'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 Ngày trước đây': [moment().subtract(7, 'days'), moment().subtract(1, 'days')],
            '30 Ngày trước đây': [moment().subtract(30, 'days'), moment().subtract(1, 'days')],
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
            $("#dmvoucherlogsearch-date_hash").submit();
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