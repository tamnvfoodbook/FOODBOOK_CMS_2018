<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmdistrict */
/* @var $allCityMap backend\controllers\DmdistrictController */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmdistrict-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DISTRICT_NAME')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'CITY_ID')->widget(Select2::classname(), [
        'data' => $allCityMap,
        'language' => 'en',
        'options' => ['placeholder' => 'Chọn thành phố...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'SORT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
