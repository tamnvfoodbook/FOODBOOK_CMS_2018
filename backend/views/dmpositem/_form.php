<?php
use yii\helpers\Html;
use backend\assets\AppAsset;
use kartik\widgets\Select2;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\widgets\MaskedInput;
//use kartik\field\FieldRange;
//use kartik\form\ActiveForm;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('plugins/select2/select2.full.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/select2/select2.min.css',['position' => \yii\web\View::POS_HEAD]);
?>


<div class="dmitem-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Cập nhật và đồng bộ', ['class' => 'btn btn-success','name' => 'btn_for_all', 'value' => 1]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'ITEM_NAME')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'ITEM_TYPE_MASTER_ID')->widget(Select2::classname(), [
            'data' => $itemTypeMasterMap,
            'options' => [
                'placeholder' => 'Chọn loại món...',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        <?= $form->field($model, 'ITEM_TYPE_ID')->widget(Select2::classname(), [
            'data' => $itemTypeMap,
            'options' => [
                'placeholder' => 'Chọn loại món...',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>

        <?= $form->field($model, 'ACTIVE')->dropDownList([1 => 'Active',2=> 'Pending',0=>'Deactive'], ['prompt'=>'Chọn trạng thái'],
            ['options' =>
                [
                    $model->ACTIVE => ['selected' => true]
                ]
            ]
        ) ?>

        <label> Thứ tự</label>
        <?= MaskedInput::widget([
            'name' => 'Dmitem[SORT]',
            'mask' => '9',
            'value' => $model->SORT,
            'clientOptions' => ['repeat' => 10, 'greedy' => false]
        ]) ?>



        <?= $form->field($model, 'IS_FEATURED')->checkbox(['0' => 'Không', '1'=> 'Có'],['prompt'=>'Chọn trạng thái']) ?>


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

        <?= $form->field($model, 'SHOW_ON_WEB')->checkbox(['0' => 'Không', '1'=> 'Có'],['prompt'=>'Chọn trạng thái'],
            ['options' =>
                [
                    $model->SHOW_ON_WEB => ['selected' => true]
                ]
            ])
        ?>

        <?= $form->field($model, 'SHOW_PRICE_ON_WEB')->checkbox(['0' => 'Không', '1'=> 'Có'],['prompt'=>'Chọn trạng thái'],
            ['options' =>
                [
                    $model->SHOW_PRICE_ON_WEB => ['selected' => true]
                ]
            ])?>
        <?= $form->field($model, 'IS_GIFT')->checkbox(['0' => 'Không', '1'=> 'Có'],['prompt'=>'Chọn trạng thái'],
            ['options' =>
                [
                    $model->IS_GIFT => ['selected' => true]
                ]
            ])?>

        <?= $form->field($model, 'REQUIRE_EAT_WITH')->checkbox(['0' => 'Không', '1'=> 'Có'],['prompt'=>'Chọn trạng thái'],
            ['options' =>
                [
                    $model->REQUIRE_EAT_WITH => ['selected' => true]
                ]
            ])
        ?>

        <!--<div id="dmitem-time_sale_date_week">
            <label>Ngày mở cửa</label>
            <?/*= Html::checkboxList('Dmitem[TIME_SALE_DATE_WEEK][]',$timesaleBinArray,['1'=>'Chủ nhật','2'=>'Thứ 2', '3'=>'Thứ 3','4'=>'Thứ 4', '5'=>'Thứ 5','6'=>'Thứ 6','7'=>'Thứ 7']) */?>
        </div>

        <div id="dmitem-time_sale_date_week">
            <label>Giờ mở cửa</label>
            <?/*= Html::checkboxList('Dmitem[TIME_SALE_HOUR_DAY]',$houraleBinArray,['1'=>'0h','2'=>'1h', '3'=>'2h','4'=>'3h', '5'=>'4h','6'=>'5h','7'=>'6h','8'=>'7h','9'=>'8h', '10'=>'9h','11'=>'10h', '12'=>'11h','13'=>'12h','14'=>'13h','15'=>'14h','16'=>'15h', '17'=>'16h','18'=>'17h', '19'=>'18h','20'=>'19h','21'=>'20h','22'=>'21h','23'=>'22h', '24'=>'23h']) */?>
        </div>-->

    </div>
    <div class="col-md-6">

        <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => 2]) ?>

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
                        'browseLabel' =>  'Select Photo',
                        'maxFileSize'=>260
                    ],
                'options' =>
                    ['accept' => 'image/*'],
            ]);
        }
        ?>

        <?php
        if($model->FB_IMAGE_PATH){
            echo Html::hiddenInput('FB_IMAGE_PATH-old',$model->FB_IMAGE_PATH);
            echo $form->field($model, 'FB_IMAGE_PATH')->widget(FileInput::classname(), [
                'pluginOptions' =>
                    [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Select Photo',
                        'initialPreview'=>[
                            Html::img("$model->FB_IMAGE_PATH", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                        ],
                        'maxFileSize'=>260

                    ],
                'options' =>
                    ['accept' => 'image/*'],
            ]);
        }else{
            echo $form->field($model, 'FB_IMAGE_PATH')->widget(FileInput::classname(), [
                'pluginOptions' =>
                    [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Select Photo',
                        'maxFileSize'=>260
                    ],
                'options' =>
                    ['accept' => 'image/*'],
            ]);
        }
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
    <div class="clearfix"></div>
    <?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">
    $(".select2").select2();
    $("#checkbox").click(function(){
        if($("#checkbox").is(':checked') ){
            $("#dmitem-item_id_eat_with > option").prop("selected","selected");
            $("#dmitem-item_id_eat_with").trigger("change");
        }else{
            $("#dmitem-item_id_eat_with > option").removeAttr("selected");
            $("#dmitem-item_id_eat_with").trigger("change");
        }
    });

</script>