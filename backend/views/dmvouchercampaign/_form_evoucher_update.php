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
?>

<div class="campaign-form">

<?php $form = ActiveForm::begin();?>


<div class="row">
    <section class="col-md-12 connectedSortable ui-sortable">
        <!-- Chat box -->
        <div class="box box-primary box-solid">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
                <h3 class="box-title">Loại voucher</h3>
            </div>
            <div class="box-body">

                <div class="col-md-6">
                    <?= $form->field($model, 'CAMPAIGN_TYPE')->dropDownList(Yii::$app->params['campainTypeSelectCreat']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'VOUCHER_TYPE')->dropDownList(['1' => 'Giảm giá', '2' => "Mua X tặng Y", '3' => 'Đồng giá']) ?>
                </div>

                <div class="sent-gift-one-to-one">
                    <div class="col-md-6">
                        <?= $form->field($model, 'NUMBER_ITEM_BUY')?>
                        <?= $form->field($model, 'APPLY_ITEM_ID')?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'NUMBER_ITEM_FREE')?>
                        <?= $form->field($model, 'APPLY_ITEM_TYPE')->widget(Select2::classname(), [
                            'data' => $iteTypemMap,
                            'options' => [
                                'placeholder' => 'Chọn món ăn ...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true
                            ],
                        ]); ?>
                    </div>
                </div>

                <div class="col-md-12" id="number-content">
                    <?= $form->field($model, 'SAME_PRICE')?>
                </div>

            </div><!-- /.box-body -->
        </div><!-- ./col -->
    </section>
</div>

<div class="row">
    <section class="col-md-6 connectedSortable ui-sortable">
        <!-- Chat box -->
        <div class="box box-primary box-solid">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
                <h3 class="box-title">Chung</h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'VOUCHER_NAME')?>


                <div id="sms-content">
                    <label for="basic-url">Nội dung SMS</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">Ma VC: XXXXXXXX. HSD <p id="dateApply">dd/mm/yyyy</p></span>
                        <textarea class="form-control sms-content" rows="2"  id="dmvouchercampaign-sms_content" name="Dmvouchercampaign[SMS_CONTENT]"></textarea>
                    </div>
                    <div class="help-sms-content"></div>
                </div>

                <?php /* echo $form->field($model, 'REQUIED_MEMBER')->dropDownList(['0' => 'Không', '1' => 'Có']); */?>
                <?php /* echo $form->field($model, 'ONLY_COUPON')->dropDownList(['0' => 'Không', '1' => 'Có']); */?>

                <?= $form->field($model, 'IS_COUPON')->dropDownList(['0' => 'Giảm %', '1' => 'Giảm tiền']); ?>


                <?= $form->field($model, 'AMOUNT_ORDER_OVER')->widget(MaskedInput::className(), [
                    'mask' => '9',
                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                ])?>

                <?= $form->field($model, 'AFFILIATE_ID')->widget(Select2::classname(), [
                    'data' => $partnerMap,
                    'options' => [
                        'placeholder' => 'Chọn ...'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
//                        'multiple' => true
                    ],
                ]); ?>


                <div id="many_time_code">
                    <label for="basic-url">Mã Voucher (Tối đa 6 kí tự)</label>
                    <div class="input-group">
                        <span class="input-group-addon">FB</span>
                        <input id="dmvouchercampaign-many_times_code" type="text"  maxlength="6" class="form-control" name="Dmvouchercampaign[MANY_TIMES_CODE]" placeholder="Mã Voucher" style="text-transform: uppercase">
                    </div>
                    <br>
                </div>


                <?= $form->field($model, 'LIST_POS_ID',[
                    'addon' => ['prepend' => ['content'=>'<input type="checkbox" id="ck_sel_all_pos" name="ck_all_pos"> Tất cả']]
                ])->widget(Select2::classname(), [
                    'data' => $allPosMap,
                    'options' => [
                        'id'=>'pos_list',
                        'placeholder' => 'Chọn nhà hàng ...'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'multiple' => true
                    ],
                ]); ?>

                <?= $form->field($model, 'ITEM_TYPE_ID_LIST',[
                    'addon' => ['prepend' => ['content'=>'<input type="checkbox" id="ck_sel_all_itemtype" name="ck_all_itemtype"> Tất cả']]
                ])->widget(DepDrop::classname(), [
                    'type'=>DepDrop::TYPE_SELECT2,
                    'options'=>[
                        'id'=>'subcat2-id',
                        'multiple' => true,
                    ],
                    'select2Options'=>[
                        'pluginOptions'=>[

                            'allowClear'=>true
                        ]
                    ],
                    'pluginOptions'=>[
                        'placeholder' => 'Chọn loại món ...',
                        'allowClear' => true,
                        'depends'=>['pos_list'],
                        'url'=>Url::to(['/dmvouchercampaign/filteritemtype'])
                    ],
                ]); ?>

                <?= $form->field($model, 'ITEM_ID_LIST')->label('Danh sách mã món ăn (các mã món ngăn cách nhau bằng dấu phẩy )')?>
                <?= $form->field($model, 'LIMIT_DISCOUNT_ITEM')?>
                <?= $form->field($model, 'MIN_QUANTITY_DISCOUNT')?>
                <?= $form->field($model, 'APPLY_ONCE_PER_USER')->dropDownList(['0' => 'Không', '1' => 'Có']); ?>

            </div><!-- /.box-body -->
        </div><!-- ./col -->
    </section>

    <section class="col-md-6 connectedSortable ui-sortable">
        <!-- Chat box -->
        <div class="box box-primary box-solid">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
                <h3 class="box-title">Thời gian</h3>
            </div>
            <div class="box-body">


                <div id="content-quantity_per_day"><?= $form->field($model, 'QUANTITY_PER_DAY')->widget(MaskedInput::className(), [
                        'mask' => '9',
                        'clientOptions' => [
                            'repeat' => 10,
                            'greedy' => false
                        ]
                    ])->label('Số lượng phát hành tối đa mỗi ngày ( Bỏ trống nếu như không giới hạn)'); ?>
                </div>

                <?php
                echo '<label class="control-label">Thời gian có hiệu lực loại voucher</label>';
                echo DatePicker::widget([
                    'name' => 'Dmvouchercampaign[DATE_START]',
                    'value' => date('d-m-Y'),
                    'type' => DatePicker::TYPE_RANGE,
                    'name2' => 'Dmvouchercampaign[DATE_END]',
                    'value2' => date('d-m-Y'),
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose'=>true
                    ]
                ]);

                ?>

                <?= $form->field($model, 'DATE_LOG_START')->widget(DatePicker::classname(), [
                    'options' => [
                        'value' => date('d-m-Y'),
                        'placeholder' => 'Ngày bắt đầu ...'
                    ],
                    'pluginOptions' => [

                        'format' => 'dd-mm-yyyy',
                        'autoclose'=>true
                    ]
                ]);
                ?>

                <?= $form->field($model, 'DURATION')->widget(MaskedInput::className(), [
                    'mask' => '9',
                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                ])->label('Số ngày voucher có hiệu lực (ngày)'); ?>


                <br/>
                <div id="dmvouchercampaign-time_date_week">
                    <label>Ngày áp dụng (Bỏ trống nếu áp dụng tất cả các ngày)</label>
                    <?= Html::checkboxList('Dmvouchercampaign[TIME_DATE_WEEK][]',null,['1'=>'Chủ nhật','2'=>'Thứ 2', '3'=>'Thứ 3','4'=>'Thứ 4', '5'=>'Thứ 5','6'=>'Thứ 6','7'=>'Thứ 7']) ?>
                </div>
                <br/>

                <div id="dmvouchercampaign-time_sale_date_week">
                    <label>Giờ áp dụng (Bỏ trống nếu áp dụng tất cả các giờ)</label>
                    <?= Html::checkboxList('Dmvouchercampaign[TIME_HOUR_DAY]',null,['0'=>'0h','1'=>'1h', '2'=>'2h','3'=>'3h', '4'=>'4h','5'=>'5h','6'=>'6h','7'=>'7h','8'=>'8h', '9'=>'9h','10'=>'10h', '11'=>'11h','12'=>'12h','13'=>'13h','14'=>'14h','15'=>'15h', '16'=>'16h','17'=>'17h', '18'=>'18h','19'=>'19h','20'=>'20h','21'=>'21h','22'=>'22h', '23'=>'23h']) ?>
                </div>
                <?php /*= $form->field($model, 'TIME_DATE_WEEK')->checkboxlist(['1'=>'Chủ nhật','2'=>'Thứ 2', '3'=>'Thứ 3','4'=>'Thứ 4', '5'=>'Thứ 5','6'=>'Thứ 6','7'=>'Thứ 7']);*/?>
                <?php /*= $form->field($model, 'TIME_HOUR_DAY')->checkboxlist(['1'=>'0h','2'=>'1h', '3'=>'2h','4'=>'3h', '5'=>'4h','6'=>'5h','7'=>'6h','8'=>'7h','9'=>'8h', '10'=>'9h','11'=>'10h', '12'=>'11h','13'=>'12h','14'=>'13h','15'=>'14h','16'=>'15h', '17'=>'16h','18'=>'17h', '19'=>'18h','20'=>'19h','21'=>'20h','22'=>'21h','23'=>'22h', '24'=>'23h']);*/?>

            </div><!-- /.box-body -->
        </div><!-- ./col -->
    </section>

    <section class="col-md-6 connectedSortable ui-sortable">
        <!-- Chat box -->
        <div class="box box-primary box-solid" id="price-down-content">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
                <h3 class="box-title">Giảm giá</h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'DISCOUNT_AMOUNT', [
                    'addon' => [
                        'append' => [
                            'content' => $form->field($model, 'DISCOUNT_TYPE')->widget(SwitchInput::classname(), [
                                'pluginOptions' => [
                                    'onText' => 'đ',
                                    'offText' => '%',
                                    'onColor' => 'primary',
                                    'offColor' => 'primary',
                                ],
                                'pluginEvents' => [
                                    //"switchChange.bootstrapSwitch" => "function() { console.log('switchChange'); }",
                                    "switchChange.bootstrapSwitch" => "function() {
                        checkswitch()
                        } ",
                                ]
                            ])->label(false),
                            'asButton' => true
                        ]
                    ]
                ])->widget(MaskedInput::className(), [
                    'mask' => '9',
                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                ])->label('% giảm giá');
                ?>

                <?= $form->field($model, 'DISCOUNT_MAX'
                /*,[
                'addon' => ['prepend' => ['content'=>'<input type="checkbox" id="no_limited" > Không giới hạn'],'append' => ['content'=>'đ']]
            ]*/
                )->widget(MaskedInput::className(), [
                    'mask' => '9',
                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                ])->label('Giới hạn giảm giá (bỏ trống nếu như không giới hạn)');
                ?>

                <?= $form->field($model, 'DISCOUNT_ONE_ITEM')->dropDownList(['0' => 'Không', '1' => 'Giảm giá cho món giá cao nhất', '2' => 'Giảm giá cho món thấp nhất']); ?>



            </div><!-- /.box-body -->
        </div><!-- ./col -->
    </section>

</div>



    <?= $form->field($model, 'LUCKY_NUMBER')?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    $('#many_time_code').hide();
    $('.field-dmvouchercampaign-lucky_number').hide();

    $('.sent-gift-one-to-one').hide();
    $('#number-content').hide();

    $(document).ready(function(){

        $('#dmvouchercampaign-campaign_type').on('change', function() {
            console.log(this.value);
            if(this.value == 5){
                //if($('#dmvouchercampaign-quantity_per_day').val())
                $('.field-dmvouchercampaign-duration').hide();
//                $('#content-quantity_per_day').hide();
                $('#sms-content').hide();
                $('#many_time_code').hide();

//                if($('#dmvouchercampaign-quantity_per_day').val().length === 0 ) {
//                    $('#dmvouchercampaign-quantity_per_day').val(0);
//                }

            }else if(this.value == 7 || this.value == 10 || this.value == 11){
                //if($('#dmvouchercampaign-quantity_per_day').val())
                $('.field-dmvouchercampaign-duration').show();
                $('.field-dmvouchercampaign-quantity_per_day').show();
//                $('#content-quantity_per_day').show();
                $('#sms-content').show();
                $('#many_time_code').hide();

            }else if(this.value == 8){
                //if($('#dmvouchercampaign-quantity_per_day').val())
                $('.field-dmvouchercampaign-duration').show();

//                $('#content-quantity_per_day').hide();
//                if($('#dmvouchercampaign-quantity_per_day').val().length === 0 ) {
//                    $('#dmvouchercampaign-quantity_per_day').val(0);
//                }
                $('#sms-content').show();
                $('#many_time_code').hide();

            }else if(this.value == 9){
                $('.field-dmvouchercampaign-duration').hide();
                $('.field-dmvouchercampaign-quantity_per_day').show();
//                $('#content-quantity_per_day').hide();
                $('#many_time_code').show();
                $('#sms-content').show();

//                if($('#dmvouchercampaign-quantity_per_day').val().length === 0 ) {
//                    $('#dmvouchercampaign-quantity_per_day').val(0);
//                }
            }

            if(this.value == 11){
                $('.field-dmvouchercampaign-lucky_number').show();
            }else{
                $('.field-dmvouchercampaign-lucky_number').hide();
            }


            if(this.value != 9){
//                $('#many_time_code').hide();
            }

//            $('#content-quantity_per_day').fadeToggle('slow');
        });

        $('#dmvouchercampaign-voucher_type').on('change', function() {
            if(this.value == 2){
                $('.sent-gift-one-to-one').show();
                $('#number-content').hide();
                $('#price-down-content').hide();

            }else if(this.value == 3){
                $('.sent-gift-one-to-one').hide();
                $('#number-content').show();
                $('#price-down-content').hide();
            }else{
                $('.sent-gift-one-to-one').hide();
                $('#number-content').hide();
                $('#price-down-content').show();
            }
        });


        $("#ck_sel_all_pos").click(function(){
            if($("#ck_sel_all_pos").is(':checked') ){
                $("#pos_list > option").prop("selected","selected");
                $("#pos_list").trigger("change");
            }else{
                $("#pos_list > option").removeAttr("selected");
                $("#pos_list").trigger("change");
            }
        });

        $("#no_limited").click(function(){
            if($("#no_limited").is(':checked') ){
                $('#dmvouchercampaign-discount_max').val(0);
                $('#dmvouchercampaign-discount_max').prop('disabled', true);
            }else{
                $('#dmvouchercampaign-discount_max').val(100000);
                $('#dmvouchercampaign-discount_max').prop('disabled', false);
            }
        });

        $("#ck_sel_all_itemtype").click(function(){
            if($("#ck_sel_all_itemtype").is(':checked') ){
                $("#subcat2-id > option").prop("selected","selected");
                $("#subcat2-id").trigger("change");
            }else{
                $("#subcat2-id > option").removeAttr("selected");
                $("#subcat2-id").trigger("change");
            }
        });

        $("#dmvouchercampaign-discount_amount").change(function(){
            var discount_type = $("input[type='checkbox'][name='Dmvouchercampaign[DISCOUNT_TYPE]']");
            if(discount_type.prop('checked')) {
            } else {
                if($("#dmvouchercampaign-discount_amount").val() >= 100){
                    $("#dmvouchercampaign-discount_amount").val(100);
                }
            }
        });

    });

    $(document).ready(function(){
        $("#ck_sel_all_pos").click(function(){
            if($("#ck_sel_all_pos").is(':checked') ){
                $("#pos_list > option").prop("selected","selected");
                $("#pos_list").trigger("change");
            }else{
                $("#pos_list > option").removeAttr("selected");
                $("#pos_list").trigger("change");
            }
        });

        $("#no_limited").click(function(){
            if($("#no_limited").is(':checked') ){
                $('#dmvouchercampaign-discount_max').val(0);
                $('#dmvouchercampaign-discount_max').prop('disabled', true);
            }else{
                $('#dmvouchercampaign-discount_max').val(100000);
                $('#dmvouchercampaign-discount_max').prop('disabled', false);
            }
        });

        $("#ck_sel_all_itemtype").click(function(){
            if($("#ck_sel_all_itemtype").is(':checked') ){
                $("#subcat2-id > option").prop("selected","selected");
                $("#subcat2-id").trigger("change");
            }else{
                $("#subcat2-id > option").removeAttr("selected");
                $("#subcat2-id").trigger("change");
            }
        });

        $("#dmvouchercampaign-discount_amount").change(function(){
            var discount_type = $("input[type='checkbox'][name='Dmvouchercampaign[DISCOUNT_TYPE]']");
            if(discount_type.prop('checked')) {
            } else {
                if($("#dmvouchercampaign-discount_amount").val() >= 100){
                    $("#dmvouchercampaign-discount_amount").val(100);
                }
            }
        });


    });



    function checkswitch(){
        var discount = $("#dmvouchercampaign-discount_amount");
        var discount_type = $("input[type='checkbox'][name='Dmvouchercampaign[DISCOUNT_TYPE]']");

        var label = $('label[for="dmvouchercampaign-discount_amount"]');
        if(discount_type.prop('checked')) {
            label.html('Số tiền giảm giá');

        } else {
            if(discount.val() >= 100){
                discount.val(100);
            }
            label.html('% giảm giá');
        }
    }

    // Add date to Today

        $("#dmvouchercampaign-duration").on("change", function(){
            var date = new Date(),
                days = parseInt($("#dmvouchercampaign-duration").val(), 10);

//            alert(date.toInputFormat());

            if(!isNaN(date.getTime())){
                date.setDate(date.getDate() + days);
//                alert(date.toInputFormat());
                $("#end_date").val(date.toInputFormat());
            } else {
                alert("Invalid Date");
            }
        });


        //From: http://stackoverflow.com/questions/3066586/get-string-in-yyyymmdd-format-from-js-date-object
        Date.prototype.toInputFormat = function() {
            var yyyy = this.getFullYear().toString();
            var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = this.getDate().toString();
            return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
        };

</script>
