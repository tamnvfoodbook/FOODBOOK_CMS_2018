<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Dmposparent;
use yii\helpers\Url;
$posparentMap = ArrayHelper::map(Dmposparent::find()->asArray()->all(),'ID','DESCRIPTION');

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmposSearch */
/* @var $allPosparentMap backend\controllers\DmposController */
/* @var $allDistrictMap backend\controllers\DmposController */
/* @var $allPosMap backend\controllers\DmposController */
/* @var $allCityMap backend\controllers\DmposController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nhà hàng';
$this->params['breadcrumbs'][] = $this->title;

?>
<BR>

<?php
$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
    ],
    [
        'attribute' => 'ID',
        'width' => '70px',
    ],
    //'POS_NAME',
    //'POS_LONGITUDE',
    //'POS_LATITUDE',
    //'DEVICE_ID',
    [
        'attribute' => 'POS_NAME',
        'value' => 'POS_NAME',
        'width' => '150px',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> $allPosMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn nhà hàng',
            'class' =>'select2-filter' // Set width của filter
        ],
    ],


    [
        'attribute' => 'POS_PARENT',
        'value' => 'POS_PARENT',
        'width' => '150px',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> $allPosparentMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn posParent',
            'class' =>'select2-filter-city' // Set width của filter
        ],

    ],

    [
        'attribute' => 'partner',
        'value' => 'partner.IS_GIFT_POINT',
        'label' => 'IS GIFT POINT',
        'width' => '120px',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> ['0' => 'Không', '1' => 'Có'],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn...',
            'class' =>'select2-filter-city' // Set width của filter
        ],
        'filterWidgetOptions' => [
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ],

    ],

    [
        'attribute' => 'LAST_READY',
        'value' => 'LastReady',
        'format' => 'raw',
        'width' => '160px'
    ],
    [
        'attribute' => 'IS_POS_MOBILE',
        'format' => 'raw',
        'width' => '120px',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> ['0' => 'Thường', '1' => 'Posmobile'],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn...',
            'class' =>'select2-filter-status' // Set width của filter
        ],
        'filterWidgetOptions' => [
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ],

    ],


    //'LAST_READY',
    'POS_ADDRESS',
    //'DESCRIPTION:ntext',
    // 'OPEN_TIME',
    //'PHONE_NUMBER',
    // 'ESTIMATE_PRICE_MAX',
    // 'ESTIMATE_PRICE',
    // 'WIFI_PASSWORD',
    // 'IS_CAR_PARKING',
    // 'IS_VISA',
    // 'IS_STICKY',
    //'IMAGE_PATH',
    //'IMAGE_PATH_THUMB',

    // 'SORT',
    // 'WIFI_SERVICE_PATH',

    //'IS_ORDER',
    // 'WEBSITE_URL:url',
    // 'POS_RADIUS_DETAL',
    // 'SHIP_PRICE',
    // 'MORE_INFO:ntext',
    // 'WORKSTATION_ID',
    // 'WS_ORDER_ONLINE',
    // 'MIN_ORDER_PRICE',
    // 'IS_HOT',
    // 'POS_MASTER_ID',
    // 'IS_ACTIVE_SHAREFB_EVENT',
    // 'SHAREFB_EVENT_RATE',
    // 'IS_SHOW_ITEM_TYPE',
    // 'IS_AHAMOVE_ACTIVE',
    // 'ORDER_NUMBER_SERVER',
    // 'ORDER_TIME_AVERAGE:datetime',
    // 'ORDER_TIME_MIN:datetime',
    // 'ORDER_TIME_MAX:datetime',
    //'PHONE_MANAGER',

    ['class' => 'yii\grid\ActionColumn',
        'template'=>'{view}'
    ],

];
?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'columns' => $gridColumns,
        'panel' => [
            'type' => GridView::TYPE_SUCCESS,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-cutlery"></i> Nhà hàng</h3>',
        ],
        'toolbar' => [
            '{toggleData}',
            '{export}',

            //$fullExportMenu,
        ]
    ]);
    ?>


