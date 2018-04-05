<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmvouchercampaign */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="glyphicon glyphicon-calendar"></i> <?= $this->title ?></h3>
    </div>
    <div class="clearfix"></div>
    <div class="rc-handle-container">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title">Thông tin chính</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?= $form->field($model, 'VOUCHER_NAME')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'CITY_ID')->widget(Select2::classname(), [
                            'data' => $allCityMap,
                            'options' => ['placeholder' => 'Chọn thành phố'],
                        ])
                        ?>
                        <?= $form->field($model, 'POS_PARENT')->widget(Select2::classname(), [
                            'data' => $posParentMap,
                            'options' => ['placeholder' => 'Chọn...'],
                        ])
                        ?>

                        <?= $form->field($model, 'POS_ID')->widget(DepDrop::classname(), [
                            'type'=>DepDrop::TYPE_SELECT2,
                            'options'=>[
                                'multiple' => true,
                                'placeholder'=>'Chọn ...'

                            ],
                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                            'pluginOptions'=>[
                                'depends'=>['dmvouchercampaign-pos_parent'],
                                'url'=>Url::to(['/dmvouchercampaign/filterpos'])
                            ],
                        ]); ?>

                        <?= $form->field($model, 'ITEM_TYPE_ID_LIST')->widget(DepDrop::classname(), [
                            'type'=>DepDrop::TYPE_SELECT2,
                            'options'=>[
                                'id'=>'subcat2-id',
                                'multiple' => true,
                                'placeholder'=>'Chọn ...'

                            ],
                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                            'pluginOptions'=>[
                                'depends'=>['dmvouchercampaign-pos_id'],
                                'url'=>Url::to(['/dmvouchercampaign/filteritemtype'])
                            ],
                        ]); ?>

                        <?= $form->field($model, 'CAMPAIGN_TYPE')->widget(Select2::classname(), [
                            'data' => [1 => 'Sms',2 => 'Voucher giấy',3 => 'Voucher checkin', 4 => 'Voucher booking',5 => 'Voucher sử dụng nhiều lần'],
                            'options' => ['placeholder' => 'Chọn loại...'],
                        ])?>

                        <?= $form->field($model, 'QUANTITY_PER_DAY')->textInput() ?>
                        <?= $form->field($model, 'DISCOUNT_EXTRA')->textInput() ?>
                        <?= $form->field($model, 'DISCOUNT_MAX')->textInput() ?>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix no-border">
                    </div>
                </div><!-- /.box -->
            </div>

            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title">Thông tin phụ</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?php
                        echo '<label class="control-label">Thời gian áp dụng</label>';
                        echo DatePicker::widget([
                            'name' => 'Dmvouchercampaign[DATE_START]',
                            'value' => date('d-m-Y'),
                            'type' => DatePicker::TYPE_RANGE,
                            'name2' => 'Dmvouchercampaign[DATE_END]',
                            'value2' => date('d-m-Y'),
                            'pluginOptions' => [
                                'format' => 'dd-mm-yyyy',
                                'autoclose'=>true
                            ]
                        ]);
                        ?>
                        <br>
                        <?= $form->field($model, 'TIME_HOUR_DAY')->widget(Select2::classname(), [
                            'data' => $timeHourDayArr,
                            'options' => ['placeholder' => 'Chọn...'],
                        ])
                        ?>
                        <?= $form->field($model, 'TIME_DATE_WEEK')->widget(Select2::classname(), [
                            'data' => $timeDayOfWeekArr,
                            'options' => ['placeholder' => 'Chọn...'],
                        ])
                        ?>
                        <?= $form->field($model, 'IS_DELIVERY')->dropDownList(['1' => 'Có', '0' => 'Không'])?>
                        <?= $form->field($model, 'IS_OTS')->dropDownList(['1' => 'Có', '0' => 'Không'])?>
                        <?= $form->field($model, 'REQUIED_MEMBER')->dropDownList(['1' => 'Có', '0' => 'Không'])?>

                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix no-border">
                    </div>
                </div><!-- /.box -->
            </div>
            <?= $form->field($model, 'DATE_CREATED')->hiddenInput(['value' => date('Y-m-d H:i:s') ])->label(false) ?>
            <?= $form->field($model, 'DATE_UPDATED')->hiddenInput(['value' => date('Y-m-d 23:59:59') ])->label(false) ?>

            <?= $form->field($model, 'DISCOUNT_TYPE')->hiddenInput(['value' => 2])->label(false) ?>
            <?= $form->field($model, 'AMOUNT_ORDER_OVER')->hiddenInput(['value' => 0])->label(false) ?>
            <?= $form->field($model, 'IS_ALL_ITEM')->hiddenInput(['value' => 1])->label(false) ?>
            <?= $form->field($model, 'ACTIVE')->hiddenInput(['value' => 1])->label(false) ?>
            <?= $form->field($model, 'MANAGER_ID')->hiddenInput(['value' => \Yii::$app->session->get('user_id')])->label(false) ?>
            <?= $form->field($model, 'MANAGER_NAME')->hiddenInput(['value' => \Yii::$app->session->get('username')])->label(false) ?>
            <?= $form->field($model, 'AFFILIATE_ID')->hiddenInput(['value' => 0])->label(false) ?>

            <div class="form-group pull-right">
                <?= Html::submitButton($model->isNewRecord ? 'Tạo' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div><!-- /.box-body -->
    </div>
</div>
