<?php

use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\field\FieldRange;

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

/*echo '<pre>';
var_dump($model);
echo '</pre>';*/
//die();
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
                <div class="col-md-3 no-padding">
                    <label> Thời gian tạo</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="reservation" readonly="readonly" name="CommissionSearch[created_at]" value="<?= @$model->created_at ?>"/>

                    </div><!-- /.input group -->
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'partner_id')->widget(Select2::classname(), [
                        'data' => $partnerMap,
                        'options' => [
                            'placeholder' => 'Chọn đối tác...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'pos_id')->widget(Select2::classname(), [
                        'data' => $posMapWithParent,
                        'options' => [
                            'placeholder' => 'Chọn nhà hàng...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
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
        },opens: 'right',

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
//            $("#searchTime").submit();
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

