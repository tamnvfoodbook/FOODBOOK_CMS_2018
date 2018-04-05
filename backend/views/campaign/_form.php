<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;
use yii\web\View;

// Url to Trust Server
$url = Yii::$app->params['POS_IMAGE_PATH'].'/line/';

// Url to Test Server
//$url = 'http://119.17.212.89:3382/images/fb/line/';

// Script cho Image Line
$format = <<< SCRIPT
    function format(state) {
        if (!state.id) return state.text; // optgroup
        src = '$url' +  state.id.toLowerCase() + '.png'
        return '<img class="flag" src="' + src + '"/>' + state.text;
    }
SCRIPT;

/* @var $this yii\web\View */
/* @var $model backend\models\COUPONLOG */
/* @var $form yii\widgets\ActiveForm */

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


$CampaignType = [
    'CAMPAIGN_TYPE_BOOKING' => 'CAMPAIGN TYPE BOOKING',
    'CAMPAIGN_TYPE_DELIVERY' => 'CAMPAIGN TYPE DELIVERY',
    'CAMPAIGN_TYPE_INTRO' => 'CAMPAIGN TYPE INTRO'
];
$Campaign_Type_Row = [
    'CAMPAIGN_TYPE_ROW_NOLINE' => 'Không có ảnh dòng',
    'CAMPAIGN_TYPE_ROW_LINE' => 'Có ảnh dòng'
];

$pos_selected = $model->Pos_Id.'-'.$model->City_Id;


//        ECHO '<PRE>';
//        var_dump($model->Item_Id_List);
//        ECHO '</PRE>';
//        die();
?>

<div class="campaign-form">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

<?= $form->field($model, 'Campaign_Name')?>

<?= $form->field($model, 'Campaign_Desc')?>

<?php
//        echo $form->field($model, 'Pos_Id')->dropDownList($posNameMap,
//            [
//                'prompt'=>'Chọn nhà hàng',
//
//                'onchange'=>'
//                    $.get( "'.Url::toRoute('/campaign/subcat1').'", { id: $(this).val() } )
//                        .done(function( data ) {
//                            $( "#'.Html::getInputId($model, 'Item_Id_List').'" ).html(data);
//                        }
//                        );
//                    ',
//                'options' =>
//                    [
//                        $pos_selected => ['selected ' => true],
//                    ]
//            ]
//        );
//echo $model->Pos_Id;
//    echo '<pre>';
//    var_dump($pos_selected);
//    echo '</pre>';
//
// without model
echo '<label>Nhà hàng </label>';
echo Select2::widget([
    'name' => 'campaign-pos_id',
    'value' => $pos_selected, // value to initialize
    'data' => $posNameMap,
    'options' => [
        'id' => 'campaign-pos_id',
        //'placeholder' => 'Chọn nhà hàng ...',
        'prompt'=>'Chọn nhà hàng...',
        //$pos_selected => ['selected ' => true],
        'onchange'=>'
                        $.get( "'.Url::toRoute('/campaign/subcat1').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'Item_Id_List').'" ).html(data);
                            }
                            );
                        ',
    ],
]);

// alternatively with model
//$model->category = 2;  // value to initialize
//    echo Select2::widget([
//        'model' => $model,
//        'attribute' => 'Pos_Id',
//        'value' => $pos_selected, // value to initialize
//        'data' => $posNameMap,
//    ]);


//        echo $form->field($model, 'Pos_Id')->widget(Select2::classname(), [
//            'data' => $posNameMap,
//            //'prompt'=>'Chọn nhà hàng',
//            'value' => ['170-129'/*$pos_selected*/],
//            //'language' => 'de',
//            'options' => [
//                //'placeholder' => 'Chọn nhà hàng ...',
//                //'prompt'=>'Chọn nhà hàng',
//                //$pos_selected => ['selected ' => true],
//                'onchange'=>'
//                        $.get( "'.Url::toRoute('/campaign/subcat1').'", { id: $(this).val() } )
//                            .done(function( data ) {
//                                $( "#'.Html::getInputId($model, 'Item_Id_List').'" ).html(data);
//                            }
//                            );
//                        ',
//            ],
//            'pluginOptions' => [
//                'allowClear' => true
//            ],
//        ]);
?>

<label>Món áp dụng</label>

<select class="form-control select2" multiple="multiple" data-placeholder="Chọn món..." name="optionItem[]" id ='campaign-item_id_list'>
    <?php
    //        ECHO '<PRE>';
    //        var_dump($model->Item_Id_List);
    //        ECHO '</PRE>';
    //        die();
    if($model->Pos_Id){
        if($model->Item_Id_List){
            foreach($itemMap as $key => $value){
                //$ipPos = explode("-", $key);
                if(in_array((int)$key,$model->Item_Id_List)){
                    echo '<option value="'.$key.'" SELECTED>'.$value.'</option>';
                }else{
                    echo '<option value="'.$key.'">'.$value.'</option>';
                }
            }
        }else{
            foreach($itemMap as $key => $value){
                echo '<option value="'.$key.'">'.$value.'</option>';
            }
        }

    }
    ?>

</select>
<br>


<!--</div>-->

<?= Html::activeHiddenInput($model,'Campaign_Created_At', ['value' => $dateCreat]) ?>

<?= $form->field($model, 'Campaign_Start')->textInput(['maxlength' => true, 'id' => 'timeApplyCamp'])->label('Thời gian áp dụng Campaign'); ?>

<?= Html::hiddenInput('Image-old',$model->Image)?>
<?php
if($model->Image){
    echo Html::hiddenInput('ImageOld',$model->Image);
    echo $form->field($model, 'Image')->widget(FileInput::classname(), [
        'pluginOptions' =>
            [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Select Photo',
                'initialPreview'=>[
                    Html::img($model->Image, ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                ],
                'maxFileSize'=>60
            ],
        'options' =>
            ['accept' => 'image/*'],
    ]);
}else{
    echo $form->field($model, 'Image')->widget(FileInput::classname(), [
        'pluginOptions' =>
            [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Select Photo',
                'maxFileSize'=>60
            ],
        'options' =>
            ['accept' => 'image/*'],
    ]);
}
?>

<?= Html::hiddenInput('Image_Logo-old',$model->Image_Logo)?>
<?php
if($model->Image_Logo){
    echo Html::hiddenInput('Image_Logo_Old',$model->Image_Logo);
    echo $form->field($model, 'Image_Logo')->widget(FileInput::classname(), [
        'pluginOptions' =>
            [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Select Photo',
                'initialPreview'=>[
                    Html::img("$model->Image_Logo", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                ],
                'maxFileSize'=>60
            ],
        'options' =>
            ['accept' => 'image/*'],
    ]);
}else{
    echo $form->field($model, 'Image_Logo')->widget(FileInput::classname(), [
        'pluginOptions' =>
            [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Select Photo',
                'maxFileSize'=>60
            ],
        'options' =>
            ['accept' => 'image/*'],
    ]);
}
?>

<?= $form->field($model, 'Campaign_Type_Row')->dropDownList($Campaign_Type_Row,['id'=> 'camTypeRow']) ?>

<?php if($model->Image_Line) { ?>
    <?= Html::hiddenInput('Image_Line_Old',$model->Image_Line)?>
<?php
}
?>

<div id="imageLine">
    <?php
    $escape = new JsExpression("function(m) { return m; }");
    $this->registerJs($format, View::POS_HEAD);
    echo '<label class="control-label">Image Line</label>';
    echo Select2::widget([
        'name' => 'Campaign[Image_Line]',
        'data' => \backend\models\Campaign::imageLine(),
        'value' => [$model->Image_Line],
        'options' => [
            'placeholder' => 'Chọn Image Line ...',
        ],

        'pluginOptions' => [
            'templateResult' => new JsExpression('format'),
            'templateSelection' => new JsExpression('format'),
            'escapeMarkup' => $escape,
            'allowClear' => true
        ],
    ]);

    ?>
</div>

<?= $form->field($model, 'Hex_Color')->textInput(['maxlength' => true, 'class' => 'form-control my-colorpicker1'])->label(); ?>

<?= $form->field($model, 'Sort')->textInput(['maxlength' => true,'value'=>'100'])->label(); ?>

<?= $form->field($model, 'Campaign_Type')->dropDownList($CampaignType,['id'=> 'camType']) ?>


<div id="couponType">
    <?= $form->field($model, 'Coupon_Id')->dropDownList($couponList,
        ['options' =>
            [
                $model->Coupon_Id => ['selected' => true],


            ],
            'prompt'=>'Chọn loại Coupon',
        ]) ?>
</div>

<?= $form->field($model, 'Show_Price_Bottom')->radioList(['1'=>'Có', '0'=>'Không']) ?>

<?= $form->field($model, 'Active')->radioList(['1'=>'Active', '0'=>'Deactive']) ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>


<!--Style hidden Div Coupon Id -->
<style>
    #couponType{
        display: none;
    }

    #imageLine{
        display: none;
    }

</style>
<!-- ./Style hidden Div Coupon Id -->

<script type="text/javascript">

    $(".select2").select2();

    //Colorpicker
    $(".my-colorpicker1").colorpicker();

    //Popup date
    $('#timeApplyCamp').daterangepicker();

    $(document).ready(function(){
        var $a;
        $a = "<?php echo $model->Coupon_Id?>";
        if($a){
            $("#couponType").show();
        }
        $('#camType').on('change', function() {
            if ( this.value === 'CAMPAIGN_TYPE_DELIVERY')
            {
                $('#couponType').fadeIn('slow');
            }
            else
            {
                $('#couponType').fadeOut('slow');
            }
        });

        var $b;
        $b = "<?php echo $model->Image_Line?>";
        if($b){
            $("#imageLine").show();
        }

        $('#camTypeRow').on('change', function() {
            if ( this.value === 'CAMPAIGN_TYPE_ROW_LINE')
            {
                $('#imageLine').fadeIn('slow');
            }
            else
            {
                $('#imageLine').fadeOut('slow');
            }
        });
    });
</script>
