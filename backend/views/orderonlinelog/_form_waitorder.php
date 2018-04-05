<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('js/jquery-1.6.1.min.js', ['position' => \yii\web\View::POS_HEAD]);

//$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/daterangepicker/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);
//
//$this->registerJsFile('plugins/timepicker/bootstrap-timepicker.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);
//
//$this->registerCssFile('plugins/timepicker/bootstrap-timepicker.min.css', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderonlinelogSearch */
/* @var $allPosMap backend\controllers\OrderonlinelogController */
/* @var $dateRanger backend\controllers\OrderonlinelogController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thống kê đơn hàng';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    [
        'class'=>'kartik\grid\SerialColumn',
        'vAlign'=>'top'
    ],
    [
        'attribute' => 'foodbook_code',
        'label' => 'Mã FB',
        //'width' => '80px',
    ],
    [
        'attribute' => 'booking_info',
        'format' => 'raw',
        //'value' => 'bookinginfo',
        //'width' => '100px',
        'label' => 'Loại'
    ],
    [
        'attribute' => 'user_phone',
        'label' => 'Khách hàng',
        'format' => 'raw'
    ],

    [
        'attribute' => 'pos_phone',
        'label' => 'SĐT Nhà hàng'
    ],
    [
        'attribute' => 'pos_id',
        'label' => 'Nhà hàng'
    ],



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

    //'note',
    //'to_address',
    //'distance',

    //'total_fee',

   /* [
        'attribute' => 'distance',
        'width' => '80px',
//        'value' => 'discomplete',
        'format'=>['decimal', 2],
//        'pageSummary'=>true,
//        'pageSummaryFunc'=>GridView::F_SUM
    ],*/


//    [
//        'attribute' => 'created_at',
//        //'label' => 'Ngày tạo',
//        'width' => '110px',
//        'value' => 'creatTime',
//        'filterType'=> GridView::FILTER_DATE_RANGE,
//        'filterWidgetOptions' => [
//            'presetDropdown' => true,
//            'pluginOptions' => [
//                'format' => 'YYYY-MM-DD',
//                'separator' => ' - ',
//                'opens'=>'left',
//            ] ,
//            'pluginEvents' => [
//                "apply.daterangepicker" => "function() { aplicarDateRangeFilter('date') }",
//            ]
//        ],
//    ],

    [
        'attribute' => 'updated_at',
        'format' => 'raw',
        'width' => '125px',
        'vAlign'=>'top',
        'hAlign'=>'center',
        'label' => 'Trạng thái',
    ],

//    [
//        'class' => 'kartik\grid\ActionColumn',
//        'vAlign'=>'top',
//        'template'=>'{view}'
//    ],
];
?>

</br>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
//    'pjax' => true,
//    'pjaxSettings' => ['options' => ['id' => 'allorder_pjax']],
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
]);
?>


