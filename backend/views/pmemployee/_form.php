<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\checkbox\CheckboxX;


/* @var $this yii\web\View */
/* @var $model backend\models\Pmemployee */
/* @var $form yii\widgets\ActiveForm */
?>
<br>
<div class="grid-view"><div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> <?= $this->title ?></h3>
        </div>

        <div class="clearfix"></div>

        <div class="rc-handle-container">
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>




                <?php
//                echo '<pre>';
//                var_dump($model->isNewRecord);
//                echo '</pre>';
//                die();
                if($model->isNewRecord){
                    echo $form->field($model, 'NAME')->textInput(['maxlength' => true]);
                    echo $form->field($model, 'POS_ID')->widget(Select2::classname(), [
                        'data' => $allPosMap,
                        'options' => ['placeholder' => 'Chọn ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                }else{
                    echo $form->field($model, 'NAME')->textInput(['maxlength' => true,'readonly' => true]);
                }

                ?>


                <div id="">
                    <label>Quyền nhân viên</label>
                    <br>
                    <?php

                    if(isset($autogenId)){
                        $allPermis = [/*'1'=> 'Thêm loại món',*/'2'=>'Thêm món', '3'=>'Tạo khách hàng', '4' => 'Trả lại','5'=>'Kiểm kê', '6' => 'Nhập kho', '7' => 'Đặt hàng'];
                        //echo Html::checkboxList('Pmemployee[PERMISTION][]',$permitArray,$allPermis);
                    }else{
                        $allPermis = [/*'1'=> 'Thêm loại món','2'=>'Thêm món',*/ '3'=>'Tạo khách hàng', '4' => 'Trả lại','5'=>'Kiểm kê', '6' => 'Nhập kho', '7' => 'Đặt hàng'];
//            echo Html::checkboxList('Pmemployee[PERMISTION][]',$permitArray,);
                    }

                    foreach($allPermis as $key => $value){
                        if(in_array($key,(array)$permitArray)){
                            $checkvalue = 1;
                        }else{
                            $checkvalue = 0;
                        }
                        echo CheckboxX::widget([
                            'name' => 'Pmemployee[PERMISTION]['.$key.']',
                            'value' => $checkvalue,
                            'initInputType' => CheckboxX::INPUT_CHECKBOX,
                            'autoLabel' => true,
                            'labelSettings' => [
                                'label' => $value,
                                'position' => CheckboxX::LABEL_RIGHT,
                            ],
                            "pluginOptions" => [
                                "theme" => "krajee-flatblue",
                                "enclosedLabel" => true,
                                "threeState"=>false,
                            ]
                        ]);
                        echo '<br>';
                    }


                    ?>
                </div>
                <br>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Sửa', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div><!-- /.box-body -->
        </div>
    </div>
