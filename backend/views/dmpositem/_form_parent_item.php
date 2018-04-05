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
if($model->isNewRecord){
    $this->title = 'Tạo món';
}else{
    $this->title = 'Sửa món';
}

$this->params['breadcrumbs'][] = ['label' => 'Món ăn', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
                    if($model->isNewRecord){
                        echo $form->field($model,'ITEM_ID')->textInput(['maxlength' => true,'required' => true,'class'=> 'text-uppercase form-control']);
                    }else{
                        echo $form->field($model,'ITEM_ID')->textInput(['maxlength' => true,'required' => true,'class'=> 'text-uppercase form-control','disabled' => true]);
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
                    <?= $form->field($model, 'ITEM_TYPE_MASTER_ID')->widget(Select2::classname(), [
                        'data' => $itemTypeMasterMap,
                        'options' => [
                            'placeholder' => 'Chọn ...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                    <?php
                        if($model->isNewRecord){
                            echo $form->field($model, 'OTS_PRICE')->textInput(['maxlength' => true]);
                            echo $form->field($model, 'TA_PRICE')->textInput(['maxlength' => true]);
                        }else{
                            echo $form->field($model, 'OTS_PRICE')->textInput(['maxlength' => true,'disabled' => true]);
                            echo $form->field($model, 'TA_PRICE')->textInput(['maxlength' => true,'disabled' => true]);
                        }
                    ?>


                    <?php
                    $model->VAT_TAX_RATE = $model->VAT_TAX_RATE*100;
                    echo $form->field($model, 'VAT_TAX_RATE')->textInput(['maxlength' => true]);
                    ?>

                    <?= $form->field($model, 'ACTIVE')->checkbox([1=> 'Active',0=>'Deactive']) ?>


                    <?= $form->field($model, 'IS_FEATURED')->checkbox(['0' => 'Không', '1'=> 'Có']) ?>


                    <?= $form->field($model, 'IS_EAT_WITH')->checkbox(['0' => 'Không', '1'=> 'Có'],['prompt'=>'Chọn trạng thái'],
                        ['options' =>
                            [
                                $model->IS_EAT_WITH => ['selected' => true]
                            ]
                        ])
                    ?>

                    <?= $form->field($model, 'ALLOW_TAKE_AWAY')->checkbox(['0' => 'Không', '1'=> 'Có'],['prompt'=>'Chọn trạng thái'],
                        ['options' =>
                            [
                                $model->ALLOW_TAKE_AWAY => ['selected' => true]
                            ]
                        ])
                    ?>

                    <?php
                    echo '<label class="control-label">Món ăn kèm</label>';
                    echo Select2::widget([
                        'name' => 'Dmitem[ITEM_ID_EAT_WITH]',
                        'theme' => Select2::THEME_DEFAULT,
                        'id' => 'dmitem-item_id_eat_with',
                        'maintainOrder' => true,
                        //'value' => ['red', 'green'], // initial value
                        'value' => explode(",",$model->ITEM_ID_EAT_WITH),
                        'data' => $itemEatWith,
                        'options' => [
                            'placeholder' => 'Chọn món ăn kèm ...',
                            'maintainOrder' => true,
                            'multiple' => true

                        ],
                        'pluginOptions' => [
                            'tags' => true,
                            'maximumInputLength' => 10
                        ],
                    ]);
                    ?>

                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'IS_PARENT')->dropDownList([0 => 'Món thường',1 => 'Món cha']) ?>

                    <?= $form->field($model, 'LIST_SUB_ITEM')->widget(Select2::classname(), [
                        'data' => $itemMap,
                        'options' => ['placeholder' => 'Chọn ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
                    ]);
                    ?>

                    <label> Thứ tự</label>
                    <?= MaskedInput::widget([
                        'name' => 'Dmitem[SORT]',
                        'mask' => '9',
                        'value' => $model->SORT,
                        'clientOptions' => ['repeat' => 10, 'greedy' => false]
                    ]) ?>
                    <br>

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
                                    'maxFileSize'=>70
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
                                    'maxFileSize'=>70
                                ],
                            'options' =>
                                ['accept' => 'image/*'],
                        ]);
                    }
                    ?>


                    <?php
                    if($model->ITEM_IMAGE_PATH_THUMB){
                        echo Html::hiddenInput('ITEM_IMAGE_PATH_THUMB-old',$model->ITEM_IMAGE_PATH_THUMB);
                    }
                    ?>



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
            var isParent = '<?php $model->LIST_SUB_ITEM ?>';
            if(isParent == 0){
                $('.field-dmitem-list_sub_item').hide();
            }

            $("#syncCheck").click(function (e) {
                if ($(this).is(':checked')) {
                    $('#modal').modal('show').find('#modalContent')
                        .load($(this).attr('href'));
                }
            });

            $('#dmitem-ots_price').bind('input', function() {
                $("#dmitem-ta_price").val($(this).val());
            });

            $('#dmitem-is_parent').change('input', function() {
                var parent = $(this).val();
                if(parent == 1){
                    $('.field-dmitem-list_sub_item').show();
                }else{
                    $('.field-dmitem-list_sub_item').hide();
                }
            });
        });
    </script>