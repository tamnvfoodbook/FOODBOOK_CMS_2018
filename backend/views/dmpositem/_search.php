<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DmpositemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dmpos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'ACTIVE') ?>

    <?= $form->field($model, 'DEVICE_ID') ?>

    <?= $form->field($model, 'POS_NAME') ?>

    <?= $form->field($model, 'POS_LONGITUDE') ?>

    <?php // echo $form->field($model, 'POS_LATITUDE') ?>

    <?php // echo $form->field($model, 'POS_PARENT') ?>

    <?php // echo $form->field($model, 'DISTRICT_ID') ?>

    <?php // echo $form->field($model, 'CITY_ID') ?>

    <?php // echo $form->field($model, 'POS_ADDRESS') ?>

    <?php // echo $form->field($model, 'DESCRIPTION') ?>

    <?php // echo $form->field($model, 'OPEN_TIME') ?>

    <?php // echo $form->field($model, 'PHONE_NUMBER') ?>

    <?php // echo $form->field($model, 'ESTIMATE_PRICE_MAX') ?>

    <?php // echo $form->field($model, 'ESTIMATE_PRICE') ?>

    <?php // echo $form->field($model, 'WIFI_PASSWORD') ?>

    <?php // echo $form->field($model, 'IS_CAR_PARKING') ?>

    <?php // echo $form->field($model, 'IS_VISA') ?>

    <?php // echo $form->field($model, 'IS_STICKY') ?>

    <?php // echo $form->field($model, 'IMAGE_PATH') ?>

    <?php // echo $form->field($model, 'IMAGE_PATH_THUMB') ?>

    <?php // echo $form->field($model, 'SORT') ?>

    <?php // echo $form->field($model, 'WIFI_SERVICE_PATH') ?>

    <?php // echo $form->field($model, 'LAST_READY') ?>

    <?php // echo $form->field($model, 'IS_ORDER') ?>

    <?php // echo $form->field($model, 'IS_BOOKING') ?>

    <?php // echo $form->field($model, 'IS_ORDER_ONLINE') ?>

    <?php // echo $form->field($model, 'WEBSITE_URL') ?>

    <?php // echo $form->field($model, 'POS_RADIUS_DETAL') ?>

    <?php // echo $form->field($model, 'SHIP_PRICE') ?>

    <?php // echo $form->field($model, 'MORE_INFO') ?>

    <?php // echo $form->field($model, 'WORKSTATION_ID') ?>

    <?php // echo $form->field($model, 'WS_ORDER_ONLINE') ?>

    <?php // echo $form->field($model, 'MIN_ORDER_PRICE') ?>

    <?php // echo $form->field($model, 'IS_HOT') ?>

    <?php // echo $form->field($model, 'POS_MASTER_ID') ?>

    <?php // echo $form->field($model, 'IS_ACTIVE_SHAREFB_EVENT') ?>

    <?php // echo $form->field($model, 'SHAREFB_EVENT_RATE') ?>

    <?php // echo $form->field($model, 'IS_SHOW_ITEM_TYPE') ?>

    <?php // echo $form->field($model, 'IS_AHAMOVE_ACTIVE') ?>

    <?php // echo $form->field($model, 'ORDER_NUMBER_SERVER') ?>

    <?php // echo $form->field($model, 'ORDER_TIME_AVERAGE') ?>

    <?php // echo $form->field($model, 'ORDER_TIME_MIN') ?>

    <?php // echo $form->field($model, 'ORDER_TIME_MAX') ?>

    <?php // echo $form->field($model, 'PHONE_MANAGER') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
