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
                    <?= $form->field($model, 'VOUCHER_TYPE')->dropDownList(['1' => 'Giảm giá', '2' => "Mua X tặng Y", '3' => 'Đồng giá']) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'CAMPAIGN_TYPE')->dropDownList(Yii::$app->params['campainTypeSelectCreat']) ?>
                </div>


                <div class="col-md-12" id="number-content">

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

                <?= $form->field($model, 'SAME_PRICE')?>

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
                <?php  echo $form->field($model, 'SEND_GIFT_TYPE')->dropDownList(['0' => 'Áp dụng cho nhóm món', '1' => 'Áp dụng cho món']); ?>


                <div class="sent-gift-one-to-one">

                    <?= $form->field($model, 'APPLY_ITEM_TYPE',[
                        'addon' => ['prepend' => ['content'=>'<input type="checkbox" id="ck_all_apply_item_type" name="ck_all_itemtype"> Tất cả']]
                    ])->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'options'=>[
                            'id'=>'apply_item_type',
                            'multiple' => true,
                        ],
                        'select2Options'=>[
                            'pluginOptions'=>[
                                'allowClear'=>true
                            ]
                        ],
                        'pluginOptions'=>[
                            'placeholder' => 'Chọn nhóm món ...',
                            'allowClear' => true,
                            'depends'=>['pos_list'],
                            'url'=>Url::to(['/dmvouchercampaign/filteritemtype'])
                        ],
                    ]); ?>

                    <?= $form->field($model, 'APPLY_ITEM_ID',[
                        'addon' => ['prepend' => ['content'=>'<input type="checkbox" id="ck_all_apply_item" name="ck_all_apply_item"> Tất cả']]
                    ])->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'options'=>[
                            'multiple' => true,
                        ],
                        'select2Options'=>[
                            'pluginOptions'=>[
                                'allowClear'=>true
                            ]
                        ],
                        'pluginOptions'=>[
                            'placeholder' => 'Chọn món ...',
                            'allowClear' => true,
                            'depends'=>['pos_list'],
                            'url'=>Url::to(['/dmvouchercampaign/filteritem'])
                        ],
                    ]); ?>

                </div>



                <?= $form->field($model, 'ITEM_TYPE_ID_LIST',[
                    'addon' => ['prepend' => ['content'=>'<input type="checkbox" id="ck_all_item_type_id_list" name="ck_all_itemtype"> Tất cả']]
                ])->widget(DepDrop::classname(), [
                    'type'=>DepDrop::TYPE_SELECT2,
                    'options'=>[
                        'id'=>'item_type_id_list',
                        'multiple' => true,
                    ],
                    'select2Options'=>[
                        'pluginOptions'=>[

                            'allowClear'=>true
                        ]
                    ],
                    'pluginOptions'=>[
                        'placeholder' => 'Chọn nhóm món ...',
                        'allowClear' => true,
                        'depends'=>['pos_list'],
                        'url'=>Url::to(['/dmvouchercampaign/filteritemtype'])
                    ],
                ]); ?>


                <?= $form->field($model, 'ITEM_ID_LIST',[
                    'addon' => ['prepend' => ['content'=>'<input type="checkbox" id="ck_all_item_id_list" name="ck_all_item_list"> Tất cả']]
                ])->widget(DepDrop::classname(), [
                    'type'=>DepDrop::TYPE_SELECT2,
                    'options'=>[
//                        'id'=>'item_id_list',
                        'multiple' => true,
                    ],
                    'select2Options'=>[
                        'pluginOptions'=>[

                            'allowClear'=>true
                        ]
                    ],
                    'pluginOptions'=>[
                        'placeholder' => 'Chọn nhóm món ...',
                        'allowClear' => true,
                        'depends'=>['pos_list'],
                        'url'=>Url::to(['/dmvouchercampaign/filteritem'])
                    ],
                ]); ?>



                <div class="sent-gift-one-to-one">
                    <div style="width: 48%; float: left">
                        <?= $form->field($model, 'NUMBER_ITEM_BUY')?>

                    </div>
                    <div style="width: 48%; float: right">
                        <?= $form->field($model, 'NUMBER_ITEM_FREE')?>
                    </div>
                </div>


                <div id="sms-content">
                    <!--<label for="basic-url">Nội dung tin nhắn</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">Ma VC: XXXXXXXX. HSD <p id="dateApply">dd/mm/yyyy</p></span>
                        <textarea class="form-control sms-content" rows="2"  id="dmvouchercampaign-sms_content" name="Dmvouchercampaign[SMS_CONTENT]"></textarea>
                    </div>
                    <div class="help-sms-content"></div>-->

                    <?=
                    $form->field($model, 'SMS_CONTENT', [
                        'addon' => ['prepend' => ['content'=>'Ma VC: XXXXXXXX. HSD <p id="dateApply">dd/mm/yyyy</p>']]
                    ])->textarea()->label('Nội dung tin nhắn');
                    ?>

                </div>

                <div id="many_time_code">
                    <?=
                    $form->field($model, 'MANY_TIMES_CODE', [
                        'addon' => ['prepend' => ['content'=>'FB']]
                    ])->textInput(['maxlength'=>6])->label('Mã voucher (Tối đa 6 kí tự)');
                    ?>
                </div>


                <?php /* echo $form->field($model, 'ONLY_COUPON')->dropDownList(['0' => 'Không', '1' => 'Có']); */?>



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
                <div class="time-apply">
                    <?php
                    echo '<label class="control-label label-date">Thời gian có hiệu lực loại voucher</label>';
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
                </div>


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
                ])->label('Số ngày voucher có hiệu lực'); ?>


                <br/>
                <div id="dmvouchercampaign-time_date_week">
                    <label>Ngày áp dụng (Bỏ trống nếu áp dụng tất cả các ngày)</label>
                    <?= Html::checkboxList('Dmvouchercampaign[TIME_DATE_WEEK][]',null,['1'=>'Chủ nhật ','2'=>'Thứ 2 ', '3'=>'Thứ 3 ','4'=>'Thứ 4 ', '5'=>'Thứ 5 ','6'=>'Thứ 6 ','7'=>'Thứ 7 ']) ?>
                </div>
                <br/>

                <div id="dmvouchercampaign-time_sale_date_week">
                    <label>Giờ áp dụng (Bỏ trống nếu áp dụng tất cả các giờ)</label>
                    <?= Html::checkboxList('Dmvouchercampaign[TIME_HOUR_DAY]',null,['0'=>'0h-1h ','1'=>'1h-2h ', '2'=>'2h-3h ','3'=>'3h-4h ', '4'=>'4h-5h ','5'=>'5h-6h ','6'=>'6h-7h ','7'=>'7h-8h ','8'=>'8h-9h ', '9'=>'9h-10h','10'=>'10h-11h', '11'=>'11h-12h','12'=>'12h-13h','13'=>'13h-14h','14'=>'14h-15h','15'=>'15h-16h', '16'=>'16h-17h','17'=>'17h-18h', '18'=>'18h-19h','19'=>'19h-20h','20'=>'20h-21h','21'=>'21h-22h','22'=>'22h-23h', '23'=>'23h-24h']) ?>
                </div>


                <?php /*= $form->field($model, 'TIME_DATE_WEEK')->checkboxlist(['1'=>'Chủ nhật','2'=>'Thứ 2', '3'=>'Thứ 3','4'=>'Thứ 4', '5'=>'Thứ 5','6'=>'Thứ 6','7'=>'Thứ 7']);*/?>
                <?php /*= $form->field($model, 'TIME_HOUR_DAY')->checkboxlist(['1'=>'0h','2'=>'1h', '3'=>'2h','4'=>'3h', '5'=>'4h','6'=>'5h','7'=>'6h','8'=>'7h','9'=>'8h', '10'=>'9h','11'=>'10h', '12'=>'11h','13'=>'12h','14'=>'13h','15'=>'14h','16'=>'15h', '17'=>'16h','18'=>'17h', '19'=>'18h','20'=>'19h','21'=>'20h','22'=>'21h','23'=>'22h', '24'=>'23h']);*/?>

            </div><!-- /.box-body -->
        </div><!-- ./col -->
    </section>

    <section class="col-md-6 connectedSortable ui-sortable">
        <!-- Chat box -->
        <div class="box box-primary box-solid collapsed-box" id="price-down-content">
            <div class="box-header ui-sortable-handle"  data-widget="collapse">
                <i class="fa fa-plus"></i>
                <h3 class="box-title">Điều kiện nâng cao</h3>

            </div>
            <div class="box-body" style="display: none;">

                <?= $form->field($model, 'IS_COUPON')->dropDownList(['0' => 'Chiết khấu', '1' => 'Phiếu giảm giá']); ?>
                <?= $form->field($model, 'ONLY_COUPON')->dropDownList([0 => 'Không', 1 => 'Có']); ?>


                <?= $form->field($model, 'AMOUNT_ORDER_OVER')->widget(MaskedInput::className(), [
                    'mask' => '9',
                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                ])?>

                <?= $form->field($model, 'DISCOUNT_MAX'
                /*,[
                'addon' => ['prepend' => ['content'=>'<input type="checkbox" id="no_limited" > Không giới hạn'],'append' => ['content'=>'đ']]
            ]*/
                )->widget(MaskedInput::className(), [
                    'mask' => '9',
                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                ])->label('Giảm không quá (vnđ)');
                ?>


                <?= $form->field($model, 'LIMIT_DISCOUNT_ITEM')?>
                <?= $form->field($model, 'DISCOUNT_ONE_ITEM')->dropDownList(['0' => 'Không', '1' => 'Giảm giá cho món giá cao nhất', '2' => 'Giảm giá cho món thấp nhất']); ?>

                <?= $form->field($model, 'MIN_QUANTITY_DISCOUNT')?>
                <?= $form->field($model, 'APPLY_ONCE_PER_USER')->dropDownList(['0' => 'Không', '1' => 'Có']); ?>

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

                <?php  echo $form->field($model, 'REQUIED_MEMBER')->dropDownList(['0' => 'Không', '1' => 'Có']); ?>


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


    function loadall(){

        $('#many_time_code').hide();
        $('.field-dmvouchercampaign-lucky_number').hide();

        $('.sent-gift-one-to-one').hide();
        $('.field-dmvouchercampaign-same_price').hide();


        $('.field-dmvouchercampaign-affiliate_id').hide();
        $('.field-dmvouchercampaign-apply_once_per_user').hide();
        $('.time-apply').hide();
        $('.field-dmvouchercampaign-date_log_start').hide();
        $('.field-dmvouchercampaign-requied_member').hide();
    }

    $(document).ready(function(){

        //Load
        loadall();

        $('#dmvouchercampaign-campaign_type').on('change', function() {
            console.log(this.value);
            loadall();
            loadbyvouchertype()
            if(this.value == 5){
                //if($('#dmvouchercampaign-quantity_per_day').val())
                $('.field-dmvouchercampaign-duration').hide();
//                $('#content-quantity_per_day').hide();
                $('#sms-content').hide();
                $('#many_time_code').hide();

                $('.time-apply').show();
                $('.label-date').html('Thời gian xuất voucher');

                $('.field-dmvouchercampaign-affiliate_id').show();
                $('.field-dmvouchercampaign-requied_member').show();
                $('.dmvouchercampaign-apply_once_per_user').hide();


            }else if(this.value == 7 || this.value == 11){
                //if($('#dmvouchercampaign-quantity_per_day').val())
                $('.field-dmvouchercampaign-duration').show();
                $('.field-dmvouchercampaign-quantity_per_day').show();
//                $('#content-quantity_per_day').show();
                $('#sms-content').show();
                $('#many_time_code').hide();

            }else if(this.value == 10 || this.value == 2 ){
                //if($('#dmvouchercampaign-quantity_per_day').val())
                $('.field-dmvouchercampaign-duration').show();
                $('.field-dmvouchercampaign-quantity_per_day').show();
//                $('#content-quantity_per_day').show();
                $('#sms-content').show();
                $('#many_time_code').hide();
                $('.time-apply').show();
                $('.label-date').html('Thời gian chương trình có hiệu lực');



                $('.field-dmvouchercampaign-date_log_start').show();
                $('.field-dmvouchercampaign-apply_once_per_user').show();

            }else if(this.value == 8){
                $('.label-date').html('Thời gian xuất voucher');
                $('.time-apply').show();
                $('.field-dmvouchercampaign-duration').show();
                $('.field-dmvouchercampaign-apply_once_per_user').show();
                $('#sms-content').hide();
                /*$('.field-dmvouchercampaign-duration').show();

                $('#many_time_code').hide();*/

            }else if(this.value == 9){
                $('.field-dmvouchercampaign-duration').hide();
                $('.field-dmvouchercampaign-quantity_per_day').show();
//                $('#content-quantity_per_day').hide();
                $('#many_time_code').show();
                $('#sms-content').hide();

                $('.field-dmvouchercampaign-affiliate_id').show();

                $('.time-apply').show();
                $('.label-date').html('Thời gian chương trình có hiệu lực');

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

        function loadbyvouchertype(){
            var vouchertype = $('#dmvouchercampaign-voucher_type');

            if(vouchertype.val() == 2){
                $('.sent-gift-one-to-one').show();
                $('.field-dmvouchercampaign-same_price').hide();
                $('.field-dmvouchercampaign-discount_amount').hide();
                $('.field-dmvouchercampaign-amount_order_over').hide();
                $('.field-dmvouchercampaign-discount_max').hide();
                $('.field-dmvouchercampaign-limit_discount_item').hide();
                $('.field-dmvouchercampaign-discount_one_item').hide();
                $('.field-dmvouchercampaign-min_quantity_discount').hide();

                var labelItemType = $("label[for='dmvouchercampaign-item_type_id_list']");
                labelItemType.html('Nhóm món được tặng');

                var labelItem = $("label[for='dmvouchercampaign-item_id_list']");
                labelItem.html('Món được tặng');

            }else if(vouchertype.val() == 3){
                $('.sent-gift-one-to-one').hide();
                $('.field-dmvouchercampaign-same_price').show();

                $('.field-dmvouchercampaign-discount_amount').hide();
                $('.field-dmvouchercampaign-amount_order_over').hide();
                $('.field-dmvouchercampaign-discount_max').hide();
                $('.field-dmvouchercampaign-limit_discount_item').hide();
                $('.field-dmvouchercampaign-discount_one_item').hide();
                $('.field-dmvouchercampaign-min_quantity_discount').hide();

            }else{
                $('.sent-gift-one-to-one').hide();
                $('.field-dmvouchercampaign-same_price').hide();
            }
        }


        $('#dmvouchercampaign-voucher_type').on('change', function() {
            loadcampagintype();
            loadbyvouchertype();
        });

        $('#dmvouchercampaign-send_gift_type').on('change', function() {
            if(this.value == 1){
                $('.field-dmvouchercampaign-apply_item_type').hide();
                $('.field-dmvouchercampaign-item_type_id_list').hide();
                $('.field-dmvouchercampaign-item_id_list').show();
                $('.field-dmvouchercampaign-apply_item_id').show();

            }else{
                defaultsentgifttype();
            }
        });

        defaultsentgifttype();

        function loadcampagintype(){
            $('.field-dmvouchercampaign-same_price').show();
            $('.field-dmvouchercampaign-discount_amount').show();
            $('.field-dmvouchercampaign-amount_order_over').show();
            $('.field-dmvouchercampaign-discount_max').show();
            $('.field-dmvouchercampaign-limit_discount_item').show();
            $('.field-dmvouchercampaign-discount_one_item').show();
            $('.field-dmvouchercampaign-min_quantity_discount').show();
        }

        function defaultsentgifttype(){
            $('.field-dmvouchercampaign-apply_item_type').show();
            $('.field-dmvouchercampaign-item_type_id_list').show();
            $('.field-dmvouchercampaign-item_id_list').hide();
            $('.field-dmvouchercampaign-apply_item_id').hide();
        }




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

        $("#ck_all_apply_item_type").click(function(){
            if($("#ck_all_apply_item_type").is(':checked') ){
                $("#apply_item_type > option").prop("selected","selected");
                $("#apply_item_type").trigger("change");
            }else{
                $("#apply_item_type > option").removeAttr("selected");
                $("#apply_item_type").trigger("change");
            }
        });

        $("#ck_all_item_type_id_list").click(function(){
            if($("#ck_all_item_type_id_list").is(':checked') ){
                $("#item_type_id_list > option").prop("selected","selected");
                $("#item_type_id_list").trigger("change");
            }else{
                $("#item_type_id_list > option").removeAttr("selected");
                $("#item_type_id_list").trigger("change");
            }
        });


        $("#ck_all_apply_item").click(function(){
            if($("#ck_all_apply_item").is(':checked') ){
                $("#dmvouchercampaign-apply_item_id > option").prop("selected","selected");
                $("#dmvouchercampaign-apply_item_id").trigger("change");
            }else{
                $("#dmvouchercampaign-apply_item_id > option").removeAttr("selected");
                $("#dmvouchercampaign-apply_item_id").trigger("change");
            }
        });

        $("#ck_all_item_id_list").click(function(){
            if($("#ck_all_item_id_list").is(':checked') ){
                $("#dmvouchercampaign-item_id_list > option").prop("selected","selected");
                $("#dmvouchercampaign-item_id_list").trigger("change");
            }else{
                $("#dmvouchercampaign-item_id_list > option").removeAttr("selected");
                $("#dmvouchercampaign-item_id_list").trigger("change");
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


    $( ".box-header" ).click(function(){
        $('.box-title').removeClass('fa-plus');
        $('.box-title').removeClass('fa-minus');
    });

</script>

