<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AppAsset;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\widgets\MaskedInput;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('bootstrap/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/select2/select2.full.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/select2/select2.min.css',['position' => \yii\web\View::POS_HEAD]);


/* @var $this yii\web\View */
/* @var $model backend\models\Dmitem */
/* @var $form yii\widgets\ActiveForm */
/* @var $timesaleBinArray backend\controllers\DmpositemController*/
/* @var $houraleBinArray backend\controllers\DmpositemController*/
/* @var $itemTypeMasterMap backend\controllers\DmpositemController*/

?>
<br>


<div class="grid-view">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-cutlery"></i> <?= $this->title ?></h3>
        </div>

        <div class="clearfix"></div>

        <div class="rc-handle-container">
            <div class="box-body">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

                <div class="col-md-6">
                    <?php
                    if(!$autoGenId){
                        if($model->isNewRecord){
                            echo $form->field($model,'ITEM_ID')->textInput(['maxlength' => true,'required' => true,'class'=> 'text-uppercase form-control']);
                        }else{
                            echo $form->field($model,'ITEM_ID')->textInput(['maxlength' => true,'required' => true,'readonly' => true]);
                        }
                    }
                    ?>

                    <?= $form->field($model,'ITEM_NAME')->textInput(['maxlength' => true]) ?>


                    <?= $form->field($model, 'ITEM_TYPE_ID')->widget(Select2::classname(), [
                        'data' => $itemTypeMap,
                        'options' => ['placeholder' => 'Chọn ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>

                    <?= $form->field($model, 'OTS_PRICE')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'TA_PRICE')->textInput(['maxlength' => true]) ?>
                    <?php
                    $model->VAT_TAX_RATE = $model->VAT_TAX_RATE*100;
                    echo $form->field($model, 'VAT_TAX_RATE')->textInput(['maxlength' => true]);
                    ?>
                    <?= $form->field($model, 'IS_STOCK')->dropDownList([1 => 'Theo dõi kho',0=>'Không theo dõi kho'], ['prompt'=>'Chọn..']) ?>
                    <?= $form->field($model, 'ALLOW_TAKE_AWAY')->dropDownList([0 => 'Không',1=>'Có']) ?>
                    <?= $form->field($model, 'ACTIVE')->dropDownList([1=> 'Active',0=>'Deactive']) ?>


                </div>
                <div class="col-md-6">
                    <label> Thứ tự</label>
                    <?= MaskedInput::widget([
                        'name' => 'Dmitem[SORT]',
                        'mask' => '9',
                        'value' => $model->SORT,
                        'clientOptions' => ['repeat' => 10, 'greedy' => false]
                    ]) ?>
                    <br>
                    <?= $form->field($model, 'IS_GIFT')->dropDownList([0 => 'Không',1=>'Có']) ?>


                    <label> Số điểm</label>
                    <?= MaskedInput::widget([
                        'name' => 'Dmitem[POINT]',
                        'mask' => '9',
                        'value' => $model->POINT,
                        'clientOptions' => ['repeat' => 10, 'greedy' => false]
                    ]) ?>
                    <br>

                    <?= $form->field($model, 'SPECIAL_TYPE')->dropDownList(Yii::$app->params['SPECIAL_TYPE']) ?>


                    <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => 3]) ?>
                    <?php
                    if($model->ITEM_IMAGE_PATH){
                        echo Html::hiddenInput('ITEM_IMAGE_PATH-old',$model->ITEM_IMAGE_PATH);
                        echo $form->field($model, 'ITEM_IMAGE_PATH')->widget(FileInput::classname(), [
                            'pluginOptions' =>
                                [
                                    'showCaption' => false,
                                    'showRemove' => false,
                                    'showUpload' => false,
                                    'browseClass' => 'btn btn-primary btn-block',
                                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                    'browseLabel' =>  'Select Photo',
                                    'initialPreview'=>[
                                        Html::img("$model->ITEM_IMAGE_PATH", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                                    ],
                                    'maxFileSize'=>260
                                ],
                            'options' =>
                                ['accept' => 'image/*'],
                        ]);
                    }else{
                        echo $form->field($model, 'ITEM_IMAGE_PATH')->widget(FileInput::classname(), [
                            'pluginOptions' =>
                                [
                                    'showCaption' => false,
                                    'showRemove' => false,
                                    'showUpload' => false,
                                    'browseClass' => 'btn btn-primary btn-block',
                                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                    'browseLabel' =>  'Chọn ảnh',
                                    'maxFileSize'=>260
                                ],
                            'options' =>
                                ['accept' => 'image/*'],
                        ]);
                    }
                    ?>

                    <input type="text" name="img-link" class="form-control img-link" placeholder="Nhập link ảnh thay cho upload file ảnh"/>
                    </br>

                    <?php
                    if($model->ITEM_IMAGE_PATH_THUMB){
                        echo Html::hiddenInput('ITEM_IMAGE_PATH_THUMB-old',$model->ITEM_IMAGE_PATH_THUMB);
                    }
                    ?>

                    <?= Html::checkbox('sync',false, ['id' => 'syncCheck']) ?>  Đồng bộ sang các điểm khác
                    <?php
                    Modal::begin([
                        'header' => '<h4>Chọn nhà hàng</h4>',
                        'id' => 'modal',
                        'size' => 'modal-lg',
                        'footer' => Html::button('Chọn xong',['class' => 'btn btn-success','data-dismiss' => "modal",'id'=> 'process']),
                    ]);
                    ?>
                    <div id="modalContent">
                        <?= $this->render('sync', [
                            'allPos' => $allPos,
                            'model' => $model,
                            'POS_ID' => $POS_ID,
                        ]) ?>
                    </div>
                    <?php Modal::end();?>
                    <br/>
                    <br/>

                    <div class="pull-right">
                        <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Sửa', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>
                <div class="clearfix"></div>

                <?php ActiveForm::end(); ?>
            </div><!-- /.box-body -->
        </div>
    </div>


    <script>
        // Script Popup Rating
        $(function(){

            $("#syncCheck").click(function (e) {
                if ($(this).is(':checked')) {
                    $('#modal').modal('show').find('#modalContent')
                        .load($(this).attr('href'));
                }
            });


            $('#dmitem-ots_price').bind('input', function() {
                $("#dmitem-ta_price").val($(this).val());
            });

            /*$('.img-link').bind('input', function() {
             $("#dmitem-ta_price").val($(this).val());
             });*/
            $(".img-link" ).change(function() {
                if($(this).val() !== ''){
                    $(".file-preview-image").attr("src",$(this).val());
                }else{
                    $(".file-preview-image").attr("src",'<?= $model->ITEM_IMAGE_PATH ?>');
                }
            });


        });
    </script>