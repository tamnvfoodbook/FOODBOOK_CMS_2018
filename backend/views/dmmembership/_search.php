<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmmembershipSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmmembership-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'MEMBER_NAME') ?>

    <?= $form->field($model, 'MEMBER_IMAGE_PATH') ?>

    <?= $form->field($model, 'ACTIVE') ?>

    <?= $form->field($model, 'HASH_PASSWORD') ?>

    <?php // echo $form->field($model, 'FACEBOOK_ID') ?>

    <?php // echo $form->field($model, 'PHONE_NUMBER') ?>

    <?php // echo $form->field($model, 'EMAIL') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'LAST_UPDATED') ?>

    <?php // echo $form->field($model, 'MY_STATUS') ?>

    <?php // echo $form->field($model, 'BIRTHDAY') ?>

    <?php // echo $form->field($model, 'CREATED_BY') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
