<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
//use yii\widgets\Pjax;
use yii\helpers\Url;

use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('plugins/timepicker/bootstrap-timepicker.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('plugins/timepicker/bootstrap-timepicker.min.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderonlinelogSearch */
/* @var $allPosMap backend\controllers\OrderonlinelogController */
/* @var $dateRanger backend\controllers\OrderonlinelogController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Báo cáo đơn hàng';
$this->params['breadcrumbs'][] = $this->title;

//echo '<pre>';
//var_dump($allPosMap);
//echo '</pre>';
//die();

$gridColumns = [
    [
        'class'=>'kartik\grid\SerialColumn',
        'vAlign'=>'top'

    ],
//            [
//                'attribute' => 'pos_is_call_center',
//                'format' => 'raw',
//                'value' => 'iscallcenter',
//                'label' => 'Qua TĐ'
//            ],
    //'_id',
    //'foodbook_code',
    /*[
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
    ],*/
    'foodbook_code',

    /*[
        'attribute' => 'foodbook_code',
        'value' => 'cutstring',
        'label' => 'Mã FB',
        'width' => '80px',
        'pageSummary'=>'Tổng',
        'pageSummaryOptions'=>['class'=>'text-right text-warning'],
    ],*/

    /*[
        'attribute' => 'ahamove_code',
        'width' => '80px',
    ],*/

    [
        'attribute' => 'booking_info',
        'format' => 'raw',
        'value' => 'bookinginfo',
        'label' => 'Giao hàng'
    ],
    [
        'attribute' => 'user_phone',
        'value' => 'memberinfo',
        'label' => 'Khách hàng',
        'format' => 'html'
    ],
    //'ahamove_code',
//    'user_id',
//    'username',
    //'user_phone',
    //'coupon_log_id',
    [
        'attribute' => 'pos_id',
        'value'=> function($data,$row) use ($allPosMap){
            return @$allPosMap[$data->pos_id];
        },
        //'group'=>true,  // enable grouping
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
    /*[
        'attribute' => 'status',
        'value' => 'status',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> Yii::$app->params['statusArray'],  // Biến Status được khai báo tại config/params.php
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn trạng thái',
            'class' =>'select2-filter-status' // Set width của filter

        ],
    ],*/

    [
        'attribute' => 'created_at',
        //'label' => 'Ngày tạo',
        'width' => '110px',
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
    'to_address',
    //'distance',

    //'total_fee',

    /*[
        'attribute' => 'distance',
        'width' => '80px',
//        'value' => 'discomplete',
        'format'=>['decimal', 2],
//        'pageSummary'=>true,
//        'pageSummaryFunc'=>GridView::F_SUM
    ],*/

    [
        'attribute' => 'order_data_item',
        'value' => 'sale',
        'width' => '80px',
        'label' => 'Tổng tiền',
        'format' => 'html',
//        'format'=>['decimal', 0],
//        'pageSummary'=>true,
//        'pageSummaryFunc'=>GridView::F_SUM
    ],

    [
        'attribute' => 'order_data_item',
        'value' => 'bill',
        'format' => 'html',
        'width' => '200px',
        'label' => 'Món',
    ],
    [
        'attribute' => 'created_by',
        'label' => 'Nguồn tạo',
    ],

    [
        'attribute' => 'updated_at',
        'format' => 'raw',
        'width' => '125px',
        'value' => 'countUpdateTime',
        'vAlign'=>'top',
        'hAlign'=>'center',
        'label' => 'Trạng thái',
    ],

//    [
//        'attribute' => 'total_fee',
//        'format'=>['decimal', 1],
//        'pageSummary'=>true,
//        'pageSummaryFunc'=>GridView::F_SUM
//    ],
//            [
//                'attribute' => 'created_at',
//                'format' => 'raw',
//                'value' => 'creatTime',
//                'label' => 'Ngày tạo',
//            ],
    /*[
        'attribute' => 'created_by',
        'label' => 'Nguồn tạo',
    ],*/
    /*[
        'attribute' => 'updated_at',
        'format' => 'raw',
        'width' => '125px',
        'value' => 'countUpdateTime',
        'vAlign'=>'top',
        'hAlign'=>'center',
        'label' => 'Trạng thái',
    ],*/
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
        'class' => 'kartik\grid\ActionColumn',
        'vAlign'=>'top',
        'template'=>'{view}'

    ],
];

?>
<br>
<div>
<?= $this->render('_search_report', [
    'model' => $searchModel,
    'timeRanger' => $timeRanger,
    'allCityMap' => $allCityMap,
    'userMap' => $userMap,
    'allDistrictMap' => $allDistrictMap,
    'allSourceMap' => $allSourceMap,
    'allPosMap' => $allPosMap,
    ])?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'showPageSummary' => true,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title">'.$this->title.'</h3>',
    ],
    'toolbar' => [
//        [
//            'content'=>
//
//        ],
        '{toggleData}',
        '{export}',
        //$fullExportMenu,
    ]
]);
?>