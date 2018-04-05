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

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'USERNAME',['readonly' => true])->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>


    <?php
    if ($type == 1) {
        echo $form->field($model, 'TYPE')->dropDownList([1 => "Quyền quản trị hệ thống", 2 => "Quyền nhà hàng"]);
        /*echo $form->field($model,'CALLCENTER_EXT')->dropDownList([
            "sip:1000@ips001.ipos.com.vn" => "Số lẻ 100",
            "sip:1001@ips001.ipos.com.vn" => "Số lẻ 101",
            "sip:1002@ips001.ipos.com.vn" => "Số lẻ 102",
            "sip:1003@ips001.ipos.com.vn " => "Số lẻ 103",
            "sip:1004@ips001.ipos.com.vn " => "Số lẻ 104"
        ]);*/
        echo $form->field($model, 'CALLCENTER_EXT')->textInput(['maxlength' => true]);
        echo $form->field($model, 'POS_PARENT')->widget(Select2::classname(), [
            'data' => $dmPosParent,
            //'language' => 'de',
            'options' => [
                'id' => 'user-pos_parent',
                'prompt'=>'Chọn chuỗi nhà hàng...',
                'onchange'=>'
                        $.get( "'.Url::toRoute('/usermanager/posdata').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'POS_ID_LIST').'" ).html(data);
                            }
                            );
                        ',
            ],
        ]);

        ?>

    <label>Nhà hàng</label>

    <select class="form-control select2" multiple="multiple" data-placeholder="Chọn nhà hàng..." name="optionPos[]" id ='user-pos_id_list'>
        <?php
        if($model->POS_ID_LIST){
            foreach($posMap as $key => $value){
                $ipPos = explode(",", $model->POS_ID_LIST);
                if(in_array($key,$ipPos)){
                    echo '<option value="'.$key.'" SELECTED>'.$value.'</option>';
                }else{
                    echo '<option value="'.$key.'">'.$value.'</option>';
                }
            }
        }
        ?>

    </select>
    <br>
    <?php
        }else{
            echo '<label>Nhà hàng</label>';
            echo '<select class="form-control select2" multiple="multiple" data-placeholder="Chọn nhà hàng..." name="optionPos[]" id ="user-pos_id_list">';
                if($model->POS_ID_LIST){
                    foreach($posMap as $key => $value){
                        $ipPos = explode(",", $model->POS_ID_LIST);
                        if(in_array($key,$ipPos)){
                            echo '<option value="'.$key.'" SELECTED>'.$value.'</option>';
                        }else{
                            echo '<option value="'.$key.'">'.$value.'</option>';
                        }
                    }
                }else{
                    foreach($posMap as $key => $value){
                        echo '<option value="'.$key.'">'.$value.'</option>';
                    }
                }
            echo '</select>';

    }
    if(isset($checkCreat)){
        echo $form->field($model, 'newpass')->passwordInput(['maxlength' => true]);
        echo $form->field($model, 'repeatnewpass')->passwordInput(['maxlength' => true]);
    }else{
        echo $form->field($model, 'newpass')->hiddenInput(['value'=>'somevalue'])->label(false); // Chỗ này chỉ truyền tham số password để tránh  requie chứ không thay đổi giá trị của mật khẩu
        echo $form->field($model, 'repeatnewpass')->hiddenInput(['value'=>'somevalue'])->label(false);
    }
    ?>

    <?= $form->field($model, 'MAX_POS_CREATE')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '9',
        'clientOptions' => ['repeat' => 10, 'greedy' => false]
    ])?>

    <?= $form->field($model, 'CALLCENTER_SHORT')->dropDownList([1=>'Yes', 0=>'No']) ;?>
    <?= $form->field($model, 'ACTIVE')->dropDownList([1=>'Active', 0=>'Deactive']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Lưu' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    $(".select2").select2();
</script>

