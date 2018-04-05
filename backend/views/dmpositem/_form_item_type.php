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

//$this->registerJsFile('bootstrap/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/select2/select2.full.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/select2/select2.min.css',['position' => \yii\web\View::POS_HEAD]);
?>



<div class="dmitem-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'ITEM_TYPE_NAME')?>

    <?= $form->field($model, 'MAX_ITEM_CHOICE')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => ['9'],
        'clientOptions' => ['repeat' => 10, 'greedy' => false]
    ]) ?>

    <?= $form->field($model, 'SORT')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => ['9'],
        'clientOptions' => ['repeat' => 10, 'greedy' => false]
    ]) ?>

    <?= $form->field($model, 'ACTIVE')->dropDownList([1 => 'Active',0=>'Deactive'])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Lưu' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
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