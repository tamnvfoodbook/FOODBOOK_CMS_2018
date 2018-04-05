<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\assets\AppAsset;
use kartik\select2\Select2;
use kartik\field\FieldRange;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
AppAsset::register($this);

$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $model backend\models\PmpurchaseSearch */
/* @var $form yii\widgets\ActiveForm */
$purposeMap = Yii::$app->params['purposeMap'];

?>


<?php $form = ActiveForm::begin([
    'action' => ['statistics'],
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
                    <?= $form->field($model, 'CAMPAIGN_TYPE')->widget(Select2::classname(), [
                        'data' => Yii::$app->params['campainType'],
                        'language' => 'en',
                        'options' => ['placeholder' => 'Tất cả..'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>

                <div class="col-md-3 no-padding">
                    <label> Thời gian tạo</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="reservation" readonly="readonly" name="DmvouchercampaignSearch[DATE_START]" value="<?= $model->DATE_START ?>"/>
                        <div class="input-group-addon">
                            <div id="clear-time"><i class="fa fa-eraser"></i></div>
                        </div>
                    </div><!-- /.input group -->
                </div>

                <div class="col-md-2">
                    <?= $form->field($model, 'VOUCHER_NAME') ?>
                </div>
                <div class="col-md-2 no-padding">
                    <?= $form->field($model, 'ACTIVE')->widget(Select2::classname(), [
                        'data' => ['0' => 'Đã dừng', '1' => 'Đang hoạt động'],
                        'language' => 'en',
                        'options' => ['placeholder' => 'Tất cả..'],
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
        },
        format: 'DD/MM/YYYY',
        locale: {
            "separator": " - ",
            "applyLabel": "Áp dụng",
            "cancelLabel": "Bỏ qua",
            "fromLabel": "Từ ngày",
            "toLabel": "Đến ngày",
            "customRangeLabel": "Tùy chọn"
        }
    }, cb);

    dp.on('apply.daterangepicker',function(event,picker){
        $.fn.ajaxData();
    });


    $( "#clear-time" ).click(function() {
        $("#reservation").val('');
    });
</script>
