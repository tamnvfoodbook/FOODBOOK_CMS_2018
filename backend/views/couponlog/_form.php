<?php



use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\field\FieldRange;
use kartik\file\FileInput;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model backend\models\COUPONLOG */
/* @var $form yii\widgets\ActiveForm */
use backend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('bootstrap/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/select2/select2.full.min.js', ['position' => \yii\web\View::POS_HEAD]);

//$this->registerJsFile('plugins/input-mask/jquery.inputmask.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/input-mask/jquery.inputmask.date.extensions.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/input-mask/jquery.inputmask.extensions.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);
//
$this->registerJsFile('plugins/colorpicker/bootstrap-colorpicker.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/timepicker/bootstrap-timepicker.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/slimScroll/jquery.slimscroll.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/iCheck/icheck.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/fastclick/fastclick.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('dist/js/app.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('dist/js/demo.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('bootstrap/css/bootstrap.min.css',['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css',['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('plugins/iCheck/all.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/colorpicker/bootstrap-colorpicker.min.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/select2/select2.min.css',['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('plugins/timepicker/bootstrap-timepicker.min.css',['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('dist/css/AdminLTE.min.css',['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('dist/css/skins/_all-skins.min.css',['position' => \yii\web\View::POS_HEAD]);

date_default_timezone_set('Asia/Bangkok');
$dateCreat = (date('c'));

$CouponType = [
    'COUPON_TYPE_POS' => 'COUPON TYPE POS',
    'COUPON_TYPE_POS_PARENT' => 'COUPON TYPE POS PARENT',
    'COUPON_TYPE_FOODBOOK' => 'COUPON TYPE FOODBOOK',
];
/* @var $this yii\web\View */
/* @var $model backend\models\CAMPAIGN */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="couponlog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'Type')->dropDownList($CouponType,['prompt'=>'Chọn loại...','class' => 'form-control couponlog-type']); ?>

    <div id="couponPos">
        <?php

        echo $form->field($model, 'Pos_Id')->widget(Select2::classname(), [
            'data' => $posNameMap,
            'language' => 'de',
            'options' => [
                'placeholder' => 'Chọn nhà hàng...',
                'onchange'=>'
                    $.get( "'.Url::toRoute('/couponlog/filtepos').'", { id: $(this).val() } )
                        .done(function( data ) {
                            $( "#'.Html::getInputId($model, 'Coupon_Name').'" ).html(data);
                        }
                        );
                ',
            ],

            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        <div id="couponlog-coupon_name"></div>
    </div>

    <div id="couponPosparent">
        <?php

        echo $form->field($model, 'Pos_Parent')->widget(Select2::classname(), [
            'data' => $posParentMap,
            'language' => 'en',
            'options' => [
                'placeholder' => 'Chọn hệ thống nhà hàng...',
                'onchange'=>'
                    $.get( "'.Url::toRoute('/couponlog/filteparent').'", { id: $(this).val() } )
                        .done(function( data ) {
                            $( "#'.Html::getInputId($model, 'className').'" ).html(data);
                        }
                    );
                ',
            ],

            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        <div id="couponlog-classname"></div>
        <br>
    </div>

    <div id="couponFoodbook">
        <img src="http://image.foodbook.vn/images/ipos/20150904/1441340552740_101860666.jpg" alt="Ảnh Foodbook" height="100" width="100" name="imageFoodbook">
        <input type="hidden" name="ImageFb" value="http://image.foodbook.vn/images/ipos/20150904/1441340552740_101860666.jpg" />
    </div>

    <?= $form->field($model, 'User_Id')->widget(Select2::classname(), [
        'data' => $posNameUserMap,
        'language' => 'en',
        'options' => [
            'placeholder' => 'Chọn khách hàng...',
            'multiple' => true
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= Html::activeHiddenInput($model,'Coupon_Log_Date', ['value' => $dateCreat]) ?>

    <?= $form->field($model, 'Coupon_Id')->dropDownList($couponList,['prompt'=>'Chọn Coupon ..'])?>

    <?= $form->field($model, 'Coupon_Log_Start')->textInput(['maxlength' => true, 'id' => 'couponlog-Coupon_Log_Start'])->label('Thời gian áp dụng Coupon'); ?>

    <?= $form->field($model, 'Active')->radioList(['1'=>'Active', '0'=>'Deactive']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!--Style hidden Div Coupon Id -->
<style>
    #couponPos{
        display: none;
    }

    #couponPosparent{
        display: none;
    }
    #couponFoodbook{
        display: none;
        margin-bottom: 10px;
    }

</style>
<!-- ./Style hidden Div Coupon Id -->

<script type="text/javascript">

    $(".select2").select2();

    //Colorpicker
    $(".my-colorpicker1").colorpicker();

    //Popup date
    $('#couponlog-Coupon_Log_Start').daterangepicker();

    $(document).ready(function(){
        $('.couponlog-type').on('change', function() {
            if ( this.value === 'COUPON_TYPE_POS')
            {
                $('#couponPos').fadeIn('slow'); // Hien
                $('#couponPosparent').fadeOut('slow'); // An
                $('#couponFoodbook').fadeOut('slow');
            }
            else if( this.value === 'COUPON_TYPE_POS_PARENT')
            {
                $('#couponPos').fadeOut('slow');
                $('#couponPosparent').fadeIn('slow');
                $('#couponFoodbook').fadeOut('slow');
            }else if( this.value === 'COUPON_TYPE_FOODBOOK'){
                $('#couponPos').fadeOut('slow');
                $('#couponPosparent').fadeOut('slow');
                $('#couponFoodbook').fadeIn('slow');
            }
        });

    });
</script>
