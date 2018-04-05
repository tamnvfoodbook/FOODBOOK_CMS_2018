<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmpositemSearch */
/* @var $allPosMap backend\controllers\DmpositemController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh mục nhà hàng';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'ID',
    //'DEVICE_ID',
    //'POS_NAME',
    [
        'attribute' => 'POS_NAME',
        'width'=>'310px',
        'value' => 'POS_NAME',

        //'filterType'=> '\kartik\widgets\Select2',
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


    //'POS_LONGITUDE',
    // 'POS_LATITUDE',
    'POS_PARENT',
    // 'DISTRICT_ID',
    //'CITY_ID',
    [
        'attribute' => 'city',
        'value' => 'city.CITY_NAME',
        'label' => 'Thành phố'
    ],
    'POS_ADDRESS',
    'ACTIVE',
    // 'OPEN_TIME',
    // 'PHONE_NUMBER',
    // 'ESTIMATE_PRICE_MAX',
    // 'ESTIMATE_PRICE',
    // 'WIFI_PASSWORD',
    // 'IS_CAR_PARKING',
    // 'IS_VISA',
    // 'IS_STICKY',
    // 'IMAGE_PATH',
    // 'IMAGE_PATH_THUMB',
    // 'SORT',
    // 'WIFI_SERVICE_PATH',
    // 'LAST_READY',
    // 'IS_ORDER',
    // 'IS_BOOKING',
    // 'IS_ORDER_ONLINE',
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
    // 'PHONE_MANAGER',

    [
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'headerOptions' => ['style'=>'color:#3c8dbc'],
        'value' => function ($data){
            return Html::a('Nhóm món', ['itemtype','id' => $data->ID ], ['class' => 'btn btn-primary']);
        },
        'label' => 'Loại món'
    ],

    [
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'headerOptions' => ['style'=>'color:#3c8dbc'],
        'value' => function ($data){
            return Html::a('Món ăn', ['viewlala','id' => $data->ID ], ['class' => 'btn btn-primary']);
        },
        'label' => 'Món ăn'
    ],
    /*['class' => 'kartik\grid\ActionColumn',
        'template' => '{view}'
    ],*/
];

?>
<br>

    <?php $fullExportMenu = ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        //'pjaxContainerId' => 'kv-pjax-container',
        'dropdownOptions' => [
            'label' => 'Export Full',
            'class' => 'btn btn-default',
            'itemsBefore' => [
                '<li class="dropdown-header">Export All Data</li>',
            ],
        ],
    ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'pjax'=>true,
        'striped'=>true,
        'hover'=>true,
        'columns' => $gridColumns,
        'panel' => [
            'type' => GridView::TYPE_SUCCESS,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Nhà hàng</h3>',
        ],
        'toolbar' => [
            //'{export}',
            $fullExportMenu,
            ['content'=>
                Html::a('Tạo mới', ['createposlala'], ['class' => 'btn btn-success'])
            ],
        ]
    ]);
    ?>
