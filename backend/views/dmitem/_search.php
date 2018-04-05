<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmitemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmitem-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'POS_ID') ?>

    <?= $form->field($model, 'ITEM_ID') ?>

    <?= $form->field($model, 'ITEM_TYPE_ID') ?>

    <?= $form->field($model, 'ITEM_NAME') ?>

    <?php // echo $form->field($model, 'ITEM_MASTER_ID') ?>

    <?php // echo $form->field($model, 'ITEM_TYPE_MASTER_ID') ?>

    <?php // echo $form->field($model, 'ITEM_IMAGE_PATH_THUMB') ?>

    <?php // echo $form->field($model, 'ITEM_IMAGE_PATH') ?>

    <?php // echo $form->field($model, 'DESCRIPTION') ?>

    <?php // echo $form->field($model, 'OTS_PRICE') ?>

    <?php // echo $form->field($model, 'TA_PRICE') ?>

    <?php // echo $form->field($model, 'POINT') ?>

    <?php // echo $form->field($model, 'IS_GIFT') ?>

    <?php // echo $form->field($model, 'SHOW_ON_WEB') ?>

    <?php // echo $form->field($model, 'SHOW_PRICE_ON_WEB') ?>

    <?php // echo $form->field($model, 'ACTIVE') ?>

    <?php // echo $form->field($model, 'SPECIAL_TYPE') ?>

    <?php // echo $form->field($model, 'LAST_UPDATED') ?>

    <?php // echo $form->field($model, 'FB_IMAGE_PATH') ?>

    <?php // echo $form->field($model, 'FB_IMAGE_PATH_THUMB') ?>

    <?php // echo $form->field($model, 'ALLOW_TAKE_AWAY') ?>

    <?php // echo $form->field($model, 'IS_EAT_WITH') ?>

    <?php // echo $form->field($model, 'REQUIRE_EAT_WITH') ?>

    <?php // echo $form->field($model, 'ITEM_ID_EAT_WITH') ?>

    <?php // echo $form->field($model, 'IS_FEATURED') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
