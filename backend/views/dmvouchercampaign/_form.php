<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

use backend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $model backend\models\Dmvouchercampaign */
/* @var $form yii\widgets\ActiveForm */

?>
<br>

<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="glyphicon glyphicon-calendar"></i> <?= $this->title ?></h3>
    </div>

    <div class="rc-handle-container">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'LIST_POS_ID',[
                'addon' => ['prepend' => ['content'=>'<input type="checkbox" id="ck_sel_all_pos" name="ck_all_pos"> Tất cả']]
            ])->widget(Select2::classname(), [
                'data' => $allPosMap,
                'options' => [
                    'id'=>'pos_list',
                    'placeholder' => 'Chọn nhà hàng ...'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true
                ],
            ]); ?>
            <?= $form->field($model, 'APPLY_ITEM_TYPE')->textInput()->label('Mã nhóm món cần mua') ?>
            <?= $form->field($model, 'ITEM_TYPE_ID_LIST')->textInput()->label('Mã nhóm món được tặng / Mã nhóm món áp dụng') ?>
            <?= $form->field($model, 'APPLY_ITEM_ID')->textInput()->label('Mã món cần mua') ?>
            <?= $form->field($model, 'ITEM_ID_LIST')->textInput()->label('Mã món được tặng / Mã món áp dụng') ?>


            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Tạo' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div><!-- /.box-body -->
    </div>
</div>


