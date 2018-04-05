<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;


use backend\assets\AppAsset;
AppAsset::register($this);

$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js',  ['position' => \yii\web\View::POS_HEAD]);


/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmpositemSearch */
/* @var $allPosMap backend\controllers\DmpositemController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh mục nhà hàng';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'ID',
    //'ACTIVE',
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
    //'POS_PARENT',
    // 'DISTRICT_ID',
    //'CITY_ID',
    [
        'attribute' => 'city',
        'value' => 'city.CITY_NAME',
        'label' => 'Thành phố'
    ],
    'POS_ADDRESS',
    'DESCRIPTION:ntext',
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
     //'LAST_READY',
    [
        'attribute' => 'LAST_READY',
        'value' => 'LastReady',
        'format' => 'raw',
        'width' => '250px',
        'hAlign'=>'center',
    ],

    [
        'format' => 'raw',
        'value' => function ($data){
            return Html::a('Nhóm món ăn', ['/dmitemtype','id' => $data->ID ], ['class' => 'btn btn-success']);
        },
        'label' => 'Nhóm món ăn'
    ],
    [
        'format' => 'raw',
        'value' => function ($data){
            return Html::a('Món ăn', ['dmpositem/view','id' => $data->ID ], ['class' => 'btn btn-success']);
        },
        'label' => 'Món ăn'
    ],
    /*[
        'format' => 'raw',
        'value' => function ($data){
            return Html::a('Sửa', ['dmpos/update','id' => $data->ID ], ['class' => 'btn btn-primary']);
        },
    ],*/
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
//    [
//        'attribute' => 'wifi',
//        'format' => 'raw',
//        'hAlign' => 'center',
//        'vAlign' => 'middle',
//        'headerOptions' => ['style'=>'color:#3c8dbc'],
//        'label' => 'IMAGE WIFI'
//    ],
//    [
//        'attribute' => 'slidewifi',
//        'format' => 'raw',
//        'hAlign' => 'center',
//        'vAlign' => 'middle',
//        'headerOptions' => ['style'=>'color:#3c8dbc'],
//        'label' => 'SLIDE WIFI'
//    ],

    /*[
        'value' => 'listitem',
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'label' => 'SLIDE WIFI'
    ],*/
    /*['class' => 'yii\grid\ActionColumn',
        'template' => '{update}'
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
        //'filterModel' => $searchModel,
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
            //$fullExportMenu,
//            ['content'=>
//                '<a href="#" class="btn btn-danger" id="btn_reset" >Đặt lại dữ liệu</a>'
//            ],
        ]
    ]);
    ?>



