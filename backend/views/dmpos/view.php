<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmpos */

$this->title = $model->POS_NAME;
$this->params['breadcrumbs'][] = ['label' => 'Nhà hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmpos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'ID',
            //'ACTIVE',
            [
                'attribute' => 'ACTIVE',
                'value' => $model->getActivedLabel('ACTIVE'),
                'label' => 'Trạng thái'
            ],
            //'DEVICE_ID',
            'POS_NAME',
            //'POS_LONGITUDE',
            //'POS_LATITUDE',
            'POS_PARENT',
            'DISTRICT_ID',
            'CITY_ID',
            'POS_ADDRESS',
            'DESCRIPTION:ntext',
            //'OPEN_TIME',
            'PHONE_NUMBER',
            //'ESTIMATE_PRICE_MAX',
            //'ESTIMATE_PRICE',
            //'WIFI_PASSWORD',
            //'IS_CAR_PARKING',
            //'IS_VISA',
            //'IS_STICKY',
            //'IMAGE_PATH',
            'IMAGE_PATH_THUMB',
            'SORT',
            //'WIFI_SERVICE_PATH',
            //'LAST_READY',
            //'IS_ORDER',
            //'IS_BOOKING',
            //'IS_ORDER_ONLINE',
            //'WEBSITE_URL:url',
            //'POS_RADIUS_DETAL',
            //'SHIP_PRICE',
            //'MORE_INFO:ntext',
            //'WORKSTATION_ID',
            //'WS_ORDER_ONLINE',
            //'MIN_ORDER_PRICE',
            //'IS_HOT',
            //'POS_MASTER_ID',
            //'IS_ACTIVE_SHAREFB_EVENT',
            //'SHAREFB_EVENT_RATE',
            //'IS_SHOW_ITEM_TYPE',
            //'IS_AHAMOVE_ACTIVE',
            [
                'attribute' => 'IS_AHAMOVE_ACTIVE',
                'value' => $model->getActivedLabel('IS_AHAMOVE_ACTIVE'),
                'label' => 'Trạng thái AHAMOVE'
            ],
            //'ORDER_NUMBER_SERVER',
            //'ORDER_TIME_AVERAGE:datetime',
            //'ORDER_TIME_MIN:datetime',
            //'ORDER_TIME_MAX:datetime',
            //'PHONE_MANAGER',
        ],
    ]) ?>

</div>
