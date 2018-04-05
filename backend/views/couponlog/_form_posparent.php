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

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);
//
$this->registerJsFile('plugins/timepicker/bootstrap-timepicker.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css',['position' => \yii\web\View::POS_HEAD]);


/* @var $this yii\web\View */
/* @var $model backend\models\CAMPAIGN */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="couponlog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'Type')->dropDownList($couponType,['prompt'=>'Chọn loại...','class' => 'form-control couponlog-type']); ?>

    <div id="couponPos">
        <?php
        echo $form->field($model, 'Pos_Id')->dropDownList($posNameMap,
            [
                'prompt'=>'Chọn nhà hàng...',
                'onchange'=>'
                    $.get( "'.Url::toRoute('/couponlog/filtepos').'", { id: $(this).val() } )
                        .done(function( data ) {
                            $( "#'.Html::getInputId($model, 'Coupon_Name').'" ).html(data);
                        }
                        );
                    ',
            ]
        );
        ?>
        <div id="couponlog-coupon_name"></div>
    </div>

    <div id="couponPosparent">
        <?= $form->field($model, 'Pos_Parent')->hiddenInput(['value' => \Yii::$app->session->get('pos_parent')])->label(false) ?>
        <?= $form->field($model, 'Coupon_Name')->textInput(['value' => 'Áp dụng cho hệ thống : '.\Yii::$app->session->get('pos_parent') ,'maxlength' => true]); ?>
        <div id="couponlog-classname"></div>
        <br>
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
</style>
<!-- ./Style hidden Div Coupon Id -->

<script type="text/javascript">
    //Popup date
    $('#couponlog-Coupon_Log_Start').daterangepicker();

    $(document).ready(function(){
        $('.couponlog-type').on('change', function() {
            if ( this.value === 'COUPON_TYPE_POS')
            {
                $('#couponPos').fadeIn('slow'); // Hien
                $('#couponPosparent').fadeOut('slow'); // An
            }
            else
            {
                $('#couponPos').fadeOut('slow');
                $('#couponPosparent').fadeIn('slow');
            }
        });

    });
</script>
