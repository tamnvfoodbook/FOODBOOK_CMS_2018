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
$this->registerJsFile('js/custom.js', ['position' => \yii\web\View::POS_END]);

$campainType = [
    1 => 'Chỉ qua SMS',
    2 => 'Chỉ qua Zalo',
    3 => 'Chỉ qua Facebook'
];

//echo '<pre>';
//var_dump($paramData);
//echo '</pre>';
//die();
$today = date('d-m-Y');

?>


<?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'EVENT_NAME')?>
    <?= $form->field($model, 'SEND_TYPE')->dropDownList($campainType) ?>
    <?= Html::hiddenInput('predata',json_encode($paramData))?>

    <?= $form->field($model, 'EVENT_TYPE')->dropDownList(Yii::$app->params['discountType'])->label('Chọn loại chiến dịch')?>
    <div id="discount-content">
        <?= $form->field($model, 'CAMPAIGN_ID')->dropDownList($campaginsMap)->label('Chọn loại Voucher')?>
    </div>

    <?= Html::checkBox('check_in_week',false,array()); ?> <label> Loại bỏ khách hàng đã gửi tin trong vòng một tuần </label>
    <div id="sms-content">
        <?= $form->field($model, 'CONTENT_MESSAGE')->textarea(['row' => 3])?>
    </div>

    <div id="parten-mess">
        <label for="basic-url">Nội dung SMS</label>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon3">Ma VC: XXXXXXXX. HSD <p id="dateApply">dd/mm/yyyy</p></span>
            <textarea class="form-control sms-content" rows="2"  id="dmvouchercampaign-sms_content" name="sms-for-voucher"></textarea>
        </div>
        <div class="help-sms-content"></div>
    </div>
    <br>


    <?= $form->field($model, 'DATE_START')->widget(DatePicker::classname(), [
        'options' => [
            'readonly' => true,
            'placeholder' => 'Ngày gửi tin ...',
            'value' => date('d-m-Y'),
        ],
        'pluginOptions' => [
            'format' => 'dd-mm-yyyy',


            'autoclose'=>true
        ],
        'pluginEvents' => [
            'change' => 'function () {
            var today = "'.$today.'";
            var dateselect = $("#dmevent-date_start").val();

            if(dateselect == today){
                var mes = "Tin nhắn sẽ được gửi trong vòng 60 phút nữa";
            }else{
                mes = "Tin nhắn sẽ được gửi trong khoảng 8h-10h sáng ngày " + dateselect ;
            }
            $("#mes-checkdate").html(mes);
            console.log(today);
            }',
        ]

    ])->label('Ngày gửi tin');
    ?>
    <p id="mes-checkdate"></p>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'btn-creat-event', 'data-loading-text' => '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...' ]) ?>
    </div>

<?php ActiveForm::end(); ?>


<script type="text/javascript">

    $("#btn-creat-event").on("click",function(e) {
        var $this = $(this);
        $this.button('loading');
        setTimeout(function() {
            $this.button('reset');
        }, 5000);
    });


    $('#sms-content').hide();
    $('#dmevent-event_type').change(function() {
        // $(this).val() will work here
        if($(this).val() == 2){
            $('#sms-content').show();
            $('#discount-content').hide();
            $('#parten-mess').hide();

        }else{
            $('#sms-content').hide();
            $('#discount-content').show();
            $('#parten-mess').show();

        }
    });

</script>
