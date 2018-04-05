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

    <?php $form = ActiveForm::begin();?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Cập nhật và đồng bộ', ['class' => 'btn btn-success','name' => 'btn_for_all', 'value' => 1]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'ITEM_NAME')->widget(Select2::classname(), [
            'data' => $itemsMap,
            'options' => ['placeholder' => 'Chọn món chính...'],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true
            ],
        ]);
        ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'ITEM_ID_EAT_WITH')->widget(Select2::classname(), [
            'data' => $itemsMap,
            'options' => ['placeholder' => 'Chọn món ăn kèm ...'],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true
            ],
        ]);
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

