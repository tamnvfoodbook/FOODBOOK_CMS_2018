<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmeventSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmevent-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'EVENT_NAME') ?>

    <?= $form->field($model, 'POS_PARENT') ?>

    <?= $form->field($model, 'DATE_CREATED') ?>

    <?= $form->field($model, 'DATE_UPDATED') ?>

    <?php // echo $form->field($model, 'DATE_START') ?>

    <?php // echo $form->field($model, 'ACTIVE') ?>

    <?php // echo $form->field($model, 'MANAGER_ID') ?>

    <?php // echo $form->field($model, 'MIN_EAT_COUNT') ?>

    <?php // echo $form->field($model, 'MAX_EAT_COUNT') ?>

    <?php // echo $form->field($model, 'MIN_PAY_AMOUNT') ?>

    <?php // echo $form->field($model, 'MAX_PAY_AMOUNT') ?>

    <?php // echo $form->field($model, 'LAST_VISIT_FREQUENCY') ?>

    <?php // echo $form->field($model, 'CAMPAIGN_ID') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'EXPECTED_APPROACH') ?>

    <?php // echo $form->field($model, 'PRACTICAL_APPROACH') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
