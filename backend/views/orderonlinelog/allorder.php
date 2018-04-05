<?php

use kartik\grid\GridView;
use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('js/jquery-1.11.3.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->title = 'Thống kê đơn hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
//            [
//                'attribute' => 'pos_is_call_center',
//                'format' => 'raw',
//                'value' => 'iscallcenter',
//                'label' => 'Qua TĐ'
//            ],
    //'_id',
    [
        'attribute' => 'isFromFoodbook',
        'value'=> 'fbcodeLabel',
        'label' => 'Loại',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> [1 => 'FB',0=> 'POS'],
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn loại',
            'class' =>'select2-filter-city' // Set width của filter
        ],
    ],

    'foodbook_code',
    //'ahamove_code',
    //'user_id',
    [
        'attribute' => 'user_phone',
        'value' => 'memberinfo',
        'label' => 'Khách hàng',
        'format' => 'html'
    ],
    'to_address',
    //'username',
    //'user_phone',
    //'coupon_log_id',
    [
        'attribute' => 'pos_id',
        'value' => 'pos.POS_NAME',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> $allPosMap,  // Biến Status được khai báo tại config/params.php
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn nhà hàng',
            'class' =>'select2-filter' // Set width của filter
        ],

    ],


    /*[
        'attribute' => 'pos_is_call_center',
        'value' => 'pos.IS_CALL_CENTER',
        'label' => 'Qua TĐ'
    ],*/

    //'isCallCenterConfirmed',
    //'status',


    [
        'attribute' => 'created_at',
        //'label' => 'Ngày tạo',
        'value' => 'creatTime',
        'filterType'=> GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
            'presetDropdown' => true,
            'pluginOptions' => [
                'format' => 'YYYY-MM-DD',
                'separator' => ' - ',
                'opens'=>'left',
            ] ,
            'pluginEvents' => [
                "apply.daterangepicker" => "function() { aplicarDateRangeFilter('date') }",
            ]
        ],
        //'format' => 'raw',
    ],

    //'note',
    [
        'attribute' => 'note',
        'width' => '200px'
    ],


    //'distance',
    //'total_fee',

//            [
//                'attribute' => 'created_at',
//                'format' => 'raw',
//                'value' => 'changeTime',
//                'label' => 'Thời gian tạo'
//            ],
//            [
//                'attribute' => 'created_at',
//                'format' => 'raw',
//                'value' => 'creatTime',
//                'label' => 'Ngày tạo',
//            ],
//

//    [
//        'attribute' => 'status',
//        'value' => 'status',
//        'filterType'=> GridView::FILTER_SELECT2,
//
//        'filter'=> Yii::$app->params['statusArray'],  // Biến Status được khai báo tại config/params.php
//        'filterWidgetOptions'=>[
//            'pluginOptions'=>['allowClear'=>true],
//        ],
//        'filterInputOptions'=>[
//            'placeholder'=>'Chọn trạng thái',
//            'class' =>'select2-filter-city' // Set width của filter
//
//        ],
//    ],

    [
        'attribute' => 'status',
        'format' => 'raw',
        'value' => 'countUpdateTime',
        'label' => 'Trạng thái',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> Yii::$app->params['statusArray'],  // Biến Status được khai báo tại config/params.php
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn trạng thái',
            'class' =>'select2-filter-city' // Set width của filter

        ],
    ],
//            [
//                'attribute' => 'time_assigning',
//                'format' => 'raw',
//                'value' => 'countWaitconfirmTime',
//                //'label' => 'Thời gian một đơn hàng',
//            ],
//            [
//                'attribute' => 'time_accepted',
//                'format' => 'raw',
//                'value' => 'countWaitconfirmTime',
//                //'label' => 'Thời gian một đơn hàng',
//            ],
//            [
//                'attribute' => 'time_inprocess',
//                'format' => 'raw',
//                'value' => 'countWaitconfirmTime',
//                //'label' => 'Thời gian một đơn hàng',
//            ],
//            [
//                'attribute' => 'time_completed',
//                'format' => 'raw',
//                'value' => 'countWaitconfirmTime',
//                //'label' => 'Thời gian một đơn hàng',
//            ],

    //'order_data_item',
    // 'pos_workstation',


    //'duration',
    //'isFromFoodbook',

    //'address_id',

    //'supplier_id',
    //'supplier_name',
    // 'shared_link',

    // 'note',
    //'payment_method',
    //'payment_info',
    //'isCallCenterConfirmWithPos',
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template'=>'{update} {delete} {toahamove} {confirmtopos}'
//
//            ],


    [
        'class' => 'yii\grid\ActionColumn',
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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
]);
?>