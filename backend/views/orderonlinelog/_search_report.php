<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AppAsset;
use kartik\select2\Select2;
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
                        <label>Thời gian</label>
                        <div class="no-padding" >
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" name="OrderonlinelogSearch[created_at]" id="reservation" readonly="readonly" value="<?= $timeRanger ?>"/>
                            </div><!-- /.input group -->
                        </div>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'pos_id')->widget(Select2::classname(), [
                        'data' => $allPosMap,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Chọn ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'manager_id')->widget(Select2::classname(), [
                        'data' => $userMap,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Chọn người tạo...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>



                <div class="col-md-3">
                    <?= $form->field($model, 'status')->widget(Select2::classname(), [
                        'data' => Yii::$app->params['statusArray'],
                        'options' => ['placeholder' => 'Chọn trạng thái...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
                    ?>
                </div>


                <div class="col-md-3">
                    <?= $form->field($model, 'created_by')->widget(Select2::classname(), [
                        'data' => $allSourceMap,
                        'options' => ['placeholder' => 'Chọn ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
                    ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'orders_purpose')->widget(Select2::classname(), [
                        'data' => $purposeMap,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Chọn mục đích...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>

                <div class="col-md-2">
                    <?= $form->field($model, 'province')->widget(Select2::classname(), [
                        'data' => $allCityMap,
                        'options' => ['placeholder' => 'Chọn tỉnh /thành phố...', 'id' => 'cat-id'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
                    ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'district')->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'data' => $allDistrictMap,
                        'options'=>[
                            'id'=>'subcat1-id',
                            'placeholder'=>'Chọn quận/ huyện...'

                        ],
                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                        'pluginOptions'=>[
                            'depends'=>['cat-id'],
                            'allowClear' => true,
                            'url'=>Url::to(['/orderonlinelog/filtercity'])
                        ],
                    ]); ?>
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
            '7 Ngày trước đây': [moment().subtract(7, 'days'), moment().subtract(1, 'days')],
            '30 Ngày trước đây': [moment().subtract(30, 'days'), moment().subtract(1, 'days')],
            'Tháng này': [moment().startOf('month'), moment().endOf('month')],
            'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        //opens: 'left',
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
        }

    });
</script>
