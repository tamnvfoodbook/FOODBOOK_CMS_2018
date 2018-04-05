<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MembershiplogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="membershiplog-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, '_id') ?>

    <?= $form->field($model, 'className') ?>

    <?= $form->field($model, 'Pos_Id') ?>

    <?= $form->field($model, 'User_Id') ?>

    <?= $form->field($model, 'Pr_Key') ?>

    <?php // echo $form->field($model, 'Membership_Log_Type') ?>

    <?php // echo $form->field($model, 'Amount') ?>

    <?php // echo $form->field($model, 'Point') ?>

    <?php // echo $form->field($model, 'Membership_Log_Date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
