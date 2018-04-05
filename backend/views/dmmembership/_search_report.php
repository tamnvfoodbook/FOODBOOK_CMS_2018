<?php

use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\field\FieldRange;


/* @var $this yii\web\View */
/* @var $model backend\models\PmpurchaseSearch */
/* @var $form yii\widgets\ActiveForm */
$purposeMap = Yii::$app->params['purposeMap'];
$timeNotCameback = [
    '7' => '1 tuần',
    '14' => '2 tuần',
    '21' => '3 tuần',
    '30' => '1 tháng',
    '60' => '2 tháng',
    '90' => '3 tháng',
    '120' => '4 tháng',
    '150' => '5 tháng',
    '180' => '6 tháng',
    '365' => '1 năm'
];

$month = [
    '1' => "Sinh tháng 1",
    '2' => 'Sinh tháng 2',
    '3' => "Sinh tháng 3",
    '4' => 'Sinh tháng 4',
    '5' => "Sinh tháng 5",
    '6' => 'Sinh tháng 6',
    '7' => "Sinh tháng 7",
    '8' => 'Sinh tháng 8',
    '9' => 'Sinh tháng 9',
    '10' => "Sinh tháng 10",
    '11' => 'Sinh tháng 11',
    '12' => "Sinh tháng 12",
];

?>


<?php $form = ActiveForm::begin([
    'action' => ['report','control' => 'report'],
    'method' => 'get',
    'id' => 'searchTime'
]); ?>

<!-- START PROGRESS BARS -->
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid ">
            <div class="box-header with-border">
                <h3 class="box-title">Công cụ lọc</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-2">
                    <?= $form->field($model, 'ID')->label('Số điện thoại'); ?>
                </div>
                <!--
                <div class="col-md-2">
                    <?/*= $form->field($model, 'MEMBER_NAME')->widget(Select2::classname(), [
                        'data' => $allMemberMap,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Tên khách hàng...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    */?>
                </div>-->

                <div class="col-md-2">
                    <?= $form->field($model, 'GENDER')->dropDownList(Yii::$app->params['genderMap'], [
                        'prompt'=>' Giới tính...'
                    ]);
                    ?>
                </div>

                <div class="col-md-2">
                    <?= $form->field($model, 'BIRTH_MONTH')->dropDownList($month, [
                        'prompt'=>'Chọn tháng...'
                    ])->label("Sinh nhật tháng");
                    ?>
                </div>

                <!--<div class="col-md-2">
                    <?/*= $form->field($model, 'USER_GROUP')->dropDownList($groupMember, [
                    'prompt'=>'Chọn nhóm...'
                    ]);
                    */?>
                </div>-->

                <div class="col-md-2">
                    <?=
                        $form->field($model, 'MEMBER_TYPE')->dropDownList($allMemberTypeMap, [
                            'prompt'=>'Chọn nhóm...'
                        ]);
                    ?>
                </div>

                <div class="col-md-4">
                    <?=
                    FieldRange::widget([
                        'form' => $form,
                        'model' => $model,
//                        'label' => 'Khách ăn trong khoảng (ngày)',
                        'label' => 'Số ngày chưa trở lại',
                        'separator' => 'đến',
                        'attribute1' => 'LAST_VISIT_FREQUENCY_START',
                        'attribute2' => 'LAST_VISIT_FREQUENCY_END',
                        'type' => FieldRange::INPUT_SPIN,
                        'widgetOptions1' => [
                            'pluginOptions' => [
                                'verticalbuttons' => true,
//                                'step' => 5,
                                'min' => 0,
                                'max' => Yii::$app->params['maxEat'],

                            ]
                        ],
                        'widgetOptions2' => [
                            'pluginOptions' => [
                                'verticalbuttons' => true,
//                                'step' => 5,
                                'min' => 0,
                                'max' => Yii::$app->params['maxEat'],

                            ]
                        ],
                    ]);
                    ?>
                </div>


                <!--<div class="col-md-2">
                    <?/*= $form->field($model, 'LAST_VISIT_FREQUENCY')->dropDownList($timeNotCameback, [
                        'prompt'=>'Chọn thời gian...'
                    ])->label("Thời gian chưa trở lại");
                    */?>
                </div>-->



                <div class="col-md-4">
                    <?=
                    FieldRange::widget([
                        'form' => $form,
                        'model' => $model,
                        'label' => 'Số lần ăn',
                        'separator' => 'đến',
                        'attribute1' => 'MIN_EAT_COUNT',
                        'attribute2' => 'MAX_EAT_COUNT',
                        'type' => FieldRange::INPUT_SPIN,
                        'widgetOptions1' => [
                            'pluginOptions' => [
                                'verticalbuttons' => true,
//                                'step' => 5,
                                'min' => 0,
                                'max' => Yii::$app->params['maxEat'],

                            ]
                        ],
                        'widgetOptions2' => [
                            'pluginOptions' => [
                                'verticalbuttons' => true,
//                                'step' => 5,
                                'min' => 0,
                                'max' => Yii::$app->params['maxEat'],

                            ]
                        ],
                    ]);
                    ?>
                </div>

                <div class="col-md-4">
                    <?=
                    FieldRange::widget([
                        'form' => $form,
                        'model' => $model,
                        'label' => 'Có số điểm',
                        'attribute1' => 'MIN_POINT',
                        'attribute2' => 'MAX_POINT',
                        'separator' => 'đến',
                        'type' => FieldRange::INPUT_SPIN,
                        'widgetOptions1' => [
                            'pluginOptions' => [
                                'verticalbuttons' => true,
//                                'step' => 10,
                                'min' => 0,
                                'max' => Yii::$app->params['maxPoint'],
                            ]
                        ],
                        'widgetOptions2' => [
                            'pluginOptions' => [
                                'verticalbuttons' => true,
//                                'step' => 10,
                                'min' => 0,
                                'max' => Yii::$app->params['maxPoint'],
                            ]
                        ],
                    ]);
                    ?>
                </div>

                <div class="col-md-4">
                    <?=
                    FieldRange::widget([
                        'form' => $form,
                        'model' => $model,
                        'label' => 'Đã chi tiêu',
                        'attribute1' => 'MIN_PAY_AMOUNT',
                        'attribute2' => 'MAX_PAY_AMOUNT',
                        'type' => FieldRange::INPUT_SPIN,
                        'separator' => 'đến',
                        'widgetOptions1' => [
                            'pluginOptions' => [
                                'verticalbuttons' => true,
//                                'step' => 10000,
                                'min' => 0,
                                'max' => Yii::$app->params['maxAmount'],
                            ]
                        ],
                        'widgetOptions2' => [
                            'pluginOptions' => [
                                'verticalbuttons' => true,
//                                'step' => 10000,
                                'min' => 0,
                                'max' => Yii::$app->params['maxAmount'],
                            ]
                        ],
                    ]);
                    ?>
                </div>




                <div class="col-md-4">
                    <?= $form->field($model, 'TOP', [
                        'addon' => [
                            'append' => [
                                'content' => $form->field($model, 'TOP_TYPE')->widget(\kartik\switchinput\SwitchInput::classname(), [
                                    'inlineLabel' => false,
                                    'pluginOptions' => [
                                        'handleWidth'=>60,
                                        'onText' => 'Chi tiêu',
                                        'offText' => 'Số lần ăn',
                                        'onColor' => 'primary',
                                        'offColor' => 'danger',
                                    ],
                                ])->label(false),
                                'asButton' => true
                            ]
                        ]
                    ])->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => '9',
                        'clientOptions' => ['repeat' => 10, 'greedy' => false]
                    ])->label('Top');
                    ?>
                </div>

                <div class="col-md-2">
                    <?= $form->field($model, 'POS_PARENT')->dropDownList(['ZALO' => 'ZALO','FACEBOOK' => 'FACEBOOK'], [
                        'prompt'=>'Chọn nguồn...'
                    ])->label("Nguồn kết nối");
                    ?>
                </div>

                <div class="col-md-2">
                    <?= $form->field($model, 'CITY_ID')->widget(Select2::classname(), [
                        'data' => $allCityMap,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Thành phố...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>




                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">Lọc báo cáo</button>
                    </div>
                </div>

            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div><!-- /.row -->
<!-- END PROGRESS BARS -->


<?php ActiveForm::end(); ?>

<script>
    $('#dmeventsearch-top').bind('keydown keyup',function(e){
        var top = $("#dmeventsearch-top");
        if(top.val() >= 300){
            top.val(300);
        }
    });



</script>

