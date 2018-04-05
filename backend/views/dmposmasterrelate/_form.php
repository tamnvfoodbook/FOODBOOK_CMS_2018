<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposmasterrelate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmposmasterrelate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'POS_ID')->widget(Select2::classname(), [
        'data' => $allPosMap,
        'language' => 'en',
        'options' => ['placeholder' => 'Chọn POS...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'POS_MASTER_ID')->widget(Select2::classname(), [
        'data' => $allPosmasterMap,
        'language' => 'en',
        'options' => ['placeholder' => 'Chọn POS...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'SORT')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '9',
        'clientOptions' => ['repeat' => 10, 'greedy' => false],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
