<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
//echo '<pre>';
//var_dump($model);
//echo '<pre>';
//die();

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        if($model->isNewRecord){
            echo $form->field($model, 'USERNAME')->textInput(['maxlength' => true]);
        }else{
            echo $form->field($model, 'USERNAME')->textInput(['maxlength' => true,'readonly' => true ]);
        }
    ?>
    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'PHONE_NUMBER')->textInput() ?>


    <?php
    if ($type == 1) {
        echo $form->field($model, 'TYPE')->dropDownList([ '1' => "Quyền quản trị hệ thống FOODBOOK", '2' => "Quản lý hệ thống nhà hàng",'3' => "Quản lý chi nhánh"]);

        echo $form->field($model, 'POS_PARENT')->widget(Select2::classname(), [
            'data' => $dmPosParent,
            //'language' => 'de',
            'options' => [
                'id' => 'user-pos_parent',
                'prompt'=>'Chọn chuỗi nhà hàng...',
                'maintainOrder' => false,
                'onchange'=>'
                        $.get( "'.Url::toRoute('/usermanager/posdata').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'POS_ID_LIST').'" ).html(data);
                            }
                            );
                        ',
            ],
        ]);

        echo $form->field($model, 'POS_ID_LIST')->widget(Select2::classname(), [
            'data' => $allPosMap,
            'maintainOrder' => true,
            'options' => [
                'placeholder' => 'Chọn nhà hàng ...',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

        echo $form->field($model, 'CALLCENTER_EXT')->textInput(['maxlength' => true]);
        echo $form->field($model, 'IPCC_PERMISSION')->dropDownList(['1' => 'Quản lý tổng', '2' => 'Cacenter','3' => 'Maketing']);
        ?>
    <?= $form->field($model, 'CALLCENTER_SHORT')->dropDownList([1=>'Có', 0=>'Không']) ;?>

    <?php
        }else{
            //echo $form->field($model, 'TYPE')->dropDownList([2 => "Quản lý hệ thống", 3 => "Quản lý chi nhánh"]);
            if($model->isNewRecord){
                echo $form->field($model, 'TYPE')->hiddenInput(['value'=>3])->label(false); //
            }

            if($type == 2 && ($model->TYPE == 3 || $model->TYPE == NULL)){
                echo $form->field($model, 'POS_ID_LIST')->widget(Select2::classname(), [
                    'data' => $allPosMap,
                    'maintainOrder' => true,
                    'options' => [
                        'placeholder' => 'Chọn nhà hàng ...',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                echo $form->field($model, 'ACTIVE')->dropDownList([1=>'Active', 0=>'Deactive']) ;
                echo $form->field($model, 'IPCC_PERMISSION')->dropDownList(['1' => 'Quản lý tổng', '2' => 'Cacenter','3' => 'Maketing']);
            }

            echo $form->field($model, 'CALLCENTER_SHORT')->dropDownList([1=>'Có', 0=>'Không']);
        //echo $form->field($model, 'TYPE')->hiddenInput(['value'=>3])->label(false);
    }
    if(isset($checkCreat)){
        echo $form->field($model, 'newpass')->passwordInput(['maxlength' => true]);
        echo $form->field($model, 'repeatnewpass')->passwordInput(['maxlength' => true]); // Chỗ này chỉ truyền tham số password để tránh  requie chứ không thay đổi giá trị của mật khẩu
    }else{
        echo $form->field($model, 'newpass')->hiddenInput(['value'=>'somevalue'])->label(false); // Chỗ này chỉ truyền tham số password để tránh  requie chứ không thay đổi giá trị của mật khẩu
        echo $form->field($model, 'repeatnewpass')->hiddenInput(['value'=>'somevalue'])->label(false);
    }
    ?>
    <?php
        if($type == 1){
            echo $form->field($model, 'MAX_POS_CREATE')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9',
                'clientOptions' => ['repeat' => 10, 'greedy' => false]
            ]);
        }
    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Lưu' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

