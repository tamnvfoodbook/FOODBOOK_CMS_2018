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

$campainType = [
    1 => 'Chỉ qua SMS',
    2 => 'Chỉ qua Zalo'
];
$discountType = [
    1 => 'Sự kiện gửi Evoucher theo lịch',
    2 => 'Sự kiện gửi tin nhắn theo lịch'
];

//echo '<pre>';
//var_dump($paramData);
//echo '</pre>';
//die();

?>


<?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'VOUCHER_NAME')?>
    <?= $form->field($model, 'CAMPAIGN_TYPE')->dropDownList($campainType) ?>
    <?= $form->field($model, 'LIST_POS_ID')->hiddenInput(['value' => json_encode($paramData)])->label(false) ?>

    <?= $form->field($model, 'DISCOUNT_TYPE')->dropDownList($discountType)->label('Chọn loại sự kiện')?>
    <div id="discount-content">
        <?= $form->field($model, 'DISCOUNT_EXTRA')->dropDownList($campaginsMap)->label('Chọn voucher')?>
    </div>

    <?= Html::checkBox('check_in_week',true,array()); ?> <label> Loại bỏ khách hàng đã gửi tin trong vòng một tuần </label>
    <div id="sms-content">
        <?= $form->field($model, 'SMS_CONTENT')->textarea(['row' => 3])?>

        <div>
            <label> Nội dung mẫu (2 SMS)</label>
            <div>
                Mã VC XXXXXXXX. HSD dd/mm/yyyy. Nhân dịp (Voucher tặng vào hè). (Gamer Beer) tặng bạn mã VC giảm giá (50%) cho lần ăn tiếp theo.
            </div>
        </div>
        <br>
    </div>

    <br>


    <?= $form->field($model, 'DATE_LOG_START')->widget(DatePicker::classname(), [
        'options' => [
            'readonly' => true,
            'placeholder' => 'Ngày bắt đầu ...'
        ],
        'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'autoclose'=>true
        ]
    ])->label('Ngày gửi tin');
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>


<script type="text/javascript">
    $('#sms-content').hide();
    $('#dmvouchercampaign-discount_type').change(function() {
        // $(this).val() will work here
        if($(this).val() == 2){
            $('#sms-content').show();
            $('#discount-content').hide();
        }else{
            $('#sms-content').hide();
            $('#discount-content').show();
        }
    });
</script>
