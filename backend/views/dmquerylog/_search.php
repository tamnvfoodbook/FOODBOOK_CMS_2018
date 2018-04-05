<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmquerylogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmquerylog-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'CREATED_AT') ?>

    <?= $form->field($model, 'ACTION_QUERY') ?>

    <?= $form->field($model, 'TABLE_NAME') ?>

    <?= $form->field($model, 'DATA_OLD') ?>

    <?php // echo $form->field($model, 'DATA_NEW') ?>

    <?php // echo $form->field($model, 'USER_MANAGER_ID') ?>

    <?php // echo $form->field($model, 'USER_MANAGER_NAME') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
