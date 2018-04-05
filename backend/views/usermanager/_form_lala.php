<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
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
?>


<div class="user-form">

    <?php $form = ActiveForm::begin();
    if($model->isNewRecord){
        echo $form->field($model, 'USERNAME')->textInput(['maxlength' => true]);
    }else{
        echo $form->field($model, 'USERNAME')->textInput(['maxlength' => true,'readonly' => true]);
    }
    ?>

    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>

    <?php

    echo '<label class="control-label">Nhà hàng</label>';
    echo Select2::widget([
        'name' => 'optionPos[]',
        'theme' => Select2::THEME_DEFAULT,
        'id' => 'user-POS_ID_LIST',
        //'value' => ['red', 'green'], // initial value
        'value' => explode(",",$model->POS_ID_LIST),
        'data' => $posMap,
        'options' => ['placeholder' => 'Chọn  ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ]);
    echo '<br>';


    //echo Html::checkbox('checkall',false,['id' => 'checkbox']); echo 'Chọn/bỏ tất cả.';

    if(isset($checkCreat)){
        echo $form->field($model, 'newpass')->passwordInput(['maxlength' => true]);
        echo $form->field($model, 'repeatnewpass')->passwordInput(['maxlength' => true]);
    }else{
        echo $form->field($model, 'newpass')->hiddenInput(['value'=>'somevalue'])->label(false); // Chỗ này chỉ truyền tham số password để tránh  requie chứ không thay đổi giá trị của mật khẩu
        echo $form->field($model, 'repeatnewpass')->hiddenInput(['value'=>'somevalue'])->label(false);
    }
    ?>
    <?= $form->field($model, 'ACTIVE')->dropDownList(['1'=>'Active', '0'=>'Deactive']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script type="text/javascript">
    $(".select2").select2();
    $("#checkbox").click(function(){
        if($("#checkbox").is(':checked') ){
            $("#user-POS_ID_LIST > option").prop("selected","selected");
            $("user-POS_ID_LIST").trigger("change");
        }else{
            $("#user-POS_ID_LIST > option").removeAttr("selected");
            $("#user-POS_ID_LIST").trigger("change");
        }
    });

</script>