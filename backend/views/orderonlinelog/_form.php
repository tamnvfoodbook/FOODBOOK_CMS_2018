<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\widgets\MultipleInput;
use kartik\select2\Select2;
use kartik\widgets\TouchSpin;

use backend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $model backend\models\Orderonlinelog */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="../js/orderonlinemap.js"></script>
<style>
    #myMap {
        height: 350px;
        width: 680px;
    }
</style>

<div class="orderonlinelog-form">
    <?php $form = ActiveForm::begin([
    ]); ?>

    <?= $form->field($model, 'order_data_item')->widget(MultipleInput::className(), [
        'limit' => 14,
        'allowEmptyList' => true,
        //'addButtonPosition' => MultipleInput::POS_HEADER,
        'columns' => [
            [
                'name'  => 'Item_Id',
                'type'  => Select2::className(),
                'title' => 'Món ăn',
                //'value' => $valueDrop,
                //'defaultValue' => 2731,
                'options' => [
                    'data' => $itemsMap,
                    'value' => 'green',
                ],

                'headerOptions' => [
                    'style' => 'width: 200px;',
                ]
            ],
            [
                'name'  => 'Quantity',
                'type'  => TouchSpin::className(),
                'title' => 'Số lượng',
                //'defaultValue' => 2,
                'options' => [
                    'pluginOptions' => [
                        'initval' => 1,
                        'min' => 1,
                    ],
                ],
                'headerOptions' => [
                    'style' => 'width: 150px;',
                ]
            ],

            [
                'name'  => 'Note',
                'enableError' => true,
                'title' => 'Note',
                'options' => [
                    'class' => 'input-priority'
                ]
            ],
        ]
    ])->label(false);
    ?>


    <div class="clearfix">
        <div class="col-lg-4">
            <label>Nhà hàng</label>
            <?= Html::textInput('adressFirst',$pos['POS_NAME'],
                [
                    'class' => 'form-control readonly',
                    'readonly' => true,
                ]
            )?>
        </div>
        <div class="col-lg-4">
            <label>Tên khách hàng</label>
            <?= Html::textInput('adressFirst',$model->username,
                [
                    'class' => 'form-control readonly',
                    'readonly' => true,
                ]
            )?>
        </div>
        <div class="col-lg-4">
            <label>Địa chỉ khách hàng cung cấp</label>
            <?= Html::textInput('adressFirst',$model->to_address,
                [
                    'class' => 'form-control readonly',
                    'readonly' => true,
                ]
            )?>
        </div>
        <div class="clearfix col-lg-12">
            <?= $form->field($model, 'foodbook_code')->hiddenInput()->label(false)?>
            <?= $form->field($model, 'address_id')->hiddenInput()->label(false)?>
            <?= Html::hiddenInput('possion_pos',$pos['POS_LATITUDE'].'-'.$pos['POS_LONGITUDE'],['id' => 'possion_pos'])?>
            <?= Html::hiddenInput('is_ahamove_pos',(int)$pos['IS_AHAMOVE_ACTIVE'])?>

            <label>Ý của bạn là</label>
            <?= Html::dropDownList('s_id', null,$arrayLocation,
                [
                    /*'prompt'=>'Ý của bạn là....',*/
                    'id' => 'checkmap',

                    'onchange'=>'
                        selectChanged(this.value)
                        ',
                    'class' => 'form-control',

                    'options' =>
                        [
                            //$firstLat.'-'.$firstLong => ['selected ' => true],

                        ]
                ]) ?>


            <div id="json_data" class="clearfix">
                <div id="myMap" style="float: left"></div><br/>
                <div style="width: 30%;float: left; margin-left: 5%">
                    <?= $form->field($model, 'to_address') ?>
                    <br/>
                    <label>Lat</label>
                    <input type="text" id="latitude" name="newLatAdress" placeholder="Latitude" class="form-control"/>
                    <label>Long</label>
                    <input type="text" id="longitude" name="newLongAdress" placeholder="Longitude" class="form-control"/>
                    <label>Khoảng cách</label>
                    <input type="text" id="distance" placeholder="Distance" class="form-control"/>
                </div>
            </div>
            <br>

            <?= $form->field($model, 'note') ?>

        </div>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    var getPosPossion = function() {
        possionPos = document.getElementById("possion_pos").value;
        if(possionPos){
            var arrayPos = possionPos.split('-');
        }
        return arrayPos; // returns the distance in meter
    };
</script>