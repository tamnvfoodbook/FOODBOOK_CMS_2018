<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $model backend\models\Dmpartner */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="dmpartner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'commission_rate')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '9',
        'clientOptions' => ['repeat' => 10, 'greedy' => false]
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Lưu' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $("#commission-commission_rate").change(function(){
        if($("#commission-commission_rate").val() >= 100){
            $("#commission-commission_rate").val(100);
        }
    });
</script>
