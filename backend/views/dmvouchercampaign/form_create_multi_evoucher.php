<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\SwitchInput;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('plugins/timepicker/bootstrap-timepicker.min.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css', ['position' => \yii\web\View::POS_HEAD]);
$this->title = 'Tạo nhiều mã Voucher';

//$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'ID')->dropDownList($campaginsMap)->label('Chọn loại Voucher')?>

    <?= $form->field($model, 'QUANTITY_PER_DAY')->widget(MaskedInput::className(), [
        'mask' => '9',
        'value' => 100,
        'clientOptions' => ['repeat' => 10, 'greedy' => false]
    ])->label('Số lượng phát hành (tối đa 1000)');
    ?>

    <label> Thời gian có hiệu lực</label>
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control" id="reservation" readonly="readonly" name="Dmvouchercampaign[DATE_START]" value="<?= date('d/m/Y').' - '.date('d/m/Y') ?>"/>
    </div><!-- /.input group -->
    <br>

    <?= $form->field($model, 'MANY_TIMES_CODE')->textInput(['maxlength'=>2,'style' => 'text-transform:uppercase'])->label("Tiền tố của mã (nếu có - 2 kí tự)")?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>


<script>

    $('#dmvouchercampaign-quantity_per_day').val(100);
    var dp = {};

    function cb(start, end) {
        $('#reservation').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }

    cb(moment().subtract(0, 'days'), moment());

    dp = $('#reservation').daterangepicker({
        ranges: {
//            'Hôm nay': [moment(), moment()],
//            'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
//            '7 Ngày trước đây': [moment().subtract(6, 'days'), moment()],
//            '30 Ngày trước đây': [moment().subtract(29, 'days'), moment()],
//            'Tháng này': [moment().startOf('month'), moment().endOf('month')],
//            'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
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




    $( document ).ready(function() {

        var perday = $("#dmvouchercampaign-quantity_per_day");

        $("#dmvouchercampaign-quantity_per_day").change(function(){
            if(perday.val()> 1000){
                perday.val(1000)
            }
            if(perday.val() <= 0){
                perday.val(1)
            }
        });


        dp.on('apply.daterangepicker',function(event,picker){
            $.fn.ajaxData();
        });
    });



</script>


