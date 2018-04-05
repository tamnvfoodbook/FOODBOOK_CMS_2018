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

$this->title = 'Danh sách nhà hàng';
$this->params['breadcrumbs'][] = $this->title;

?>
<BR>

<?php
$gridColumns = [

    ['class' => 'yii\grid\SerialColumn'],
    'ID',
    //'POS_NAME',

    //'DEVICE_ID',
    //'POS_LONGITUDE',
    //'POS_LATITUDE',
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
    'POS_PARENT',

//    [
//        'attribute' => 'POS_MASTER_ID',
//        'value' => 'posmaster.POS_MASTER_NAME',
//        'filterType'=> GridView::FILTER_SELECT2,
//
//        'filter'=> $allPosMasterMap,
//        'filterWidgetOptions'=>[
//            'pluginOptions'=>['allowClear'=>true],
//        ],
//        'filterInputOptions'=>[
//            'placeholder'=>'Chọn Pos Master',
//            'class' =>'select2-filter' // Set width của filter
//        ],
//
//    ],

    [
        'attribute' => 'CITY_ID',
        'value' => 'city.CITY_NAME',
        //'label' => 'Thành phố',
        'width' => '150px',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> $allCityMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn thành phố',
            'class' =>'select2-filter-city' // Set width của filter
        ],
    ],
//    [
//        'attribute' => 'DISTRICT_ID',
//        'value' => 'district.DISTRICT_NAME',
//        'label' => 'Quận huyện',
//        'width' => '150px',
//        'filterType'=> GridView::FILTER_SELECT2,
//        'filter'=> $allDistrictMap,
//        'filterWidgetOptions'=>[
//            'pluginOptions'=>['allowClear'=>true],
//        ],
//        'filterInputOptions'=>[
//            'placeholder'=>'Chọn thành phố',
//            'class' =>'select2-filter-city' // Set width của filter
//        ],
//    ],

    'POS_ADDRESS',
    'VAT_TAX_RATE',
    [
        'value' => function ($data){
            return $data->VAT_TAX_RATE*100;
        },
        'attribute' => 'VAT_TAX_RATE'
    ],

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
    [
        'attribute' => 'IMAGE_PATH',
        'format' => ['image',['width'=>'50','height'=>'50']],
        'label' => 'Ảnh',
        'headerOptions' => ['style'=>'color:#3c8dbc'],
    ],
    [
        'attribute' => 'IMAGE_PATH_THUMB',
        'format' => ['image',['width'=>'50','height'=>'50']],
        'label' => 'Ảnh đại diện',
        'headerOptions' => ['style'=>'color:#3c8dbc'],
    ],

    // 'SORT',
    // 'WIFI_SERVICE_PATH',
    // 'LAST_READY',
    //'IS_ORDER',
    'IS_BOOKING',
    'IS_ORDER_ONLINE',
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
    [
        'attribute' => 'ACTIVE',
        'value' => 'activedLabelGirdView',
        'label' => 'Trạng thái',
        'filter' => Html::activeDropDownList($searchModel,'ACTIVE', [0=> 'Deactive', 1=> 'Active', 2=> 'Active Pos Mobile'],['class'=>'form-control','prompt' => 'Chọn trạng thái']),
    ],

    ['class' => 'yii\grid\ActionColumn',
        'template'=>'{view} {update}'
    ],

];
?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'pjax' => true,
        //'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'columns' => $gridColumns,
        'panel' => [
            'type' => GridView::TYPE_SUCCESS,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-cutlery"></i> '.$this->title.'</h3>',
        ],
        'toolbar' => [
//            [
//                'content'=>
//                    Html::a('Tạo nhà hàng', ['create'], ['class' => 'btn btn-success']),
//            ],
            '{toggleData}',
            '{export}',

            //$fullExportMenu,
        ]
    ]);
    ?>


