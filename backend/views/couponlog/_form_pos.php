<?php
date_default_timezone_set('Asia/Bangkok');
$dateCreat = (date('c'));

use backend\assets\AppAsset;
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

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('bootstrap/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/select2/select2.full.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);
//
$this->registerJsFile('plugins/colorpicker/bootstrap-colorpicker.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/timepicker/bootstrap-timepicker.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css',['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('plugins/colorpicker/bootstrap-colorpicker.min.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/select2/select2.min.css',['position' => \yii\web\View::POS_HEAD]);





/* @var $this yii\web\View */
/* @var $model backend\models\CAMPAIGN */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="couponlog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'Type')->hiddenInput(['value'=> 'COUPON_TYPE_POS'])->label(false)?>

    <div id="couponPos">

        <?= $form->field($model, 'Pos_Id')->widget(Select2::classname(), [
            'data' => $posNameMap,
            'language' => 'en',
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


<script type="text/javascript">

    $(".select2").select2();

    //Colorpicker
    $(".my-colorpicker1").colorpicker();

    //Popup date
    $('#couponlog-Coupon_Log_Start').daterangepicker();

</script>
