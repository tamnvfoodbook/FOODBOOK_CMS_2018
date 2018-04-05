<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmitem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmitem-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'POS_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_TYPE_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_MASTER_ID')->textInput() ?>

    <?= $form->field($model, 'ITEM_TYPE_MASTER_ID')->textInput() ?>

    <?= $form->field($model, 'ITEM_IMAGE_PATH_THUMB')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_IMAGE_PATH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'OTS_PRICE')->textInput() ?>

    <?= $form->field($model, 'TA_PRICE')->textInput() ?>

    <?= $form->field($model, 'POINT')->textInput() ?>

    <?= $form->field($model, 'IS_GIFT')->textInput() ?>

    <?= $form->field($model, 'SHOW_ON_WEB')->textInput() ?>

    <?= $form->field($model, 'SHOW_PRICE_ON_WEB')->textInput() ?>

    <?= $form->field($model, 'ACTIVE')->textInput() ?>

    <?= $form->field($model, 'SPECIAL_TYPE')->textInput() ?>

    <?= $form->field($model, 'LAST_UPDATED')->textInput() ?>

    <?= $form->field($model, 'FB_IMAGE_PATH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FB_IMAGE_PATH_THUMB')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALLOW_TAKE_AWAY')->textInput() ?>

    <?= $form->field($model, 'IS_EAT_WITH')->textInput() ?>

    <?= $form->field($model, 'REQUIRE_EAT_WITH')->textInput() ?>

    <?= $form->field($model, 'ITEM_ID_EAT_WITH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IS_FEATURED')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
