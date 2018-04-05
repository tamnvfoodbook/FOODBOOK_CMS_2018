<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\select2\Select2;

use backend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $model backend\models\Dmnotice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmnotice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TITLE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IS_ALL_POS')->checkbox() ?>

    <?= $form->field($model, 'LIST_POS')->widget(Select2::classname(), [
        'data' => $allPosMap,
        'language' => 'en',
        'options' => ['placeholder' => 'Chọn nhà hàng...'],
        'pluginOptions' => [
            'multiple' => true,
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'CONTENT')->textarea()?>

    <?= $form->field($model, 'FULL_CONTENT_URL')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(@$isNewRecord ? 'Create' : 'Update', ['class' => @$isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<script>
    $("#dmnotice-is_all_pos").change(function() {
        if(this.checked) {
            //Do stuff
            $('.field-dmnotice-list_pos').hide();
        }else{
            $('.field-dmnotice-list_pos').show();
        }
    });

</script>
