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
$timeNotCameback = [
    '7' => '1 tuần',
    '14' => '2 tuần',
    '21' => '3 tuần',
    '30' => '1 tháng',
    '60' => '2 tháng',
    '90' => '3 tháng',
    '120' => '4 tháng',
    '150' => '5 tháng',
    '180' => '6 tháng',
    '365' => '1 năm'
];

$month = [
    '1' => "Sinh tháng 1",
    '2' => 'Sinh tháng 2',
    '3' => "Sinh tháng 3",
    '4' => 'Sinh tháng 4',
    '5' => "Sinh tháng 5",
    '6' => 'Sinh tháng 6',
    '7' => "Sinh tháng 7",
    '8' => 'Sinh tháng 8',
    '9' => 'Sinh tháng 9',
    '10' => "Sinh tháng 10",
    '11' => 'Sinh tháng 11',
    '12' => "Sinh tháng 12",
];

?>


<?php $form = ActiveForm::begin([
    'action' => ['report','control' => 'report'],
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
                    <?= $form->field($model, 'EVENT_TYPE')->widget(Select2::classname(), [
                        'data' => Yii::$app->params['discountType'],
                        'language' => 'en',
                    ]);
                    ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'STATUS')->widget(Select2::classname(), [
                        'data' => ['1' => 'Hoàn thành', '0' => 'Chưa hoàn thành'],
                        'language' => 'en',
                        'options' => ['placeholder' => 'Trạng thái..'],
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
