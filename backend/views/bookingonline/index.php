<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
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
/* @var $searchModel backend\models\BookingonlinelogSearch */
/* @var $allPosMap backend\controllers\BookingonlineController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách đặt bàn';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'vAlign'=>'top'
    ],
    //'_id',
    'Foodbook_Code',
    //'Pos_Id',
    [
        'attribute' => 'User_Id',
        'format'=>'raw',
        'value'=> function($data,$row) use ($allMemberMap,$memberMapMyStatus){
            Yii::info($memberMapMyStatus[$data->User_Id]);
            if(@$allMemberMap[$data->User_Id]){
                return $allMemberMap[$data->User_Id] . '<br>' . $data->User_Id;
            }else{
                return $memberMapMyStatus[$data->User_Id] . '<br>' . $data->User_Id;
            }
        },
        'label' => 'Khách hàng'
    ],
    [
        'attribute' => 'Pos_Id',
        'value'=> function($data,$row) use ($allPosMap){
            return @$allPosMap[$data->Pos_Id];
        },
    ],
    //'Pos_Workstation',
    //'User_Id',
    //'Book_Date',

    [
        'attribute' => 'Book_Date',
        'format'=>'raw',
        'value' => 'chagebookdate',
        'label' => 'Thời gian đặt'
    ],
    [
        'attribute' => 'Number_People',
        'width' => '80px',
    ],
    'Note',
    'Created_By',
    //'Status',
    //'Created_At',
//        [
//            'attribute' => 'Created_At',
//            //'format'=>'ra',
//            'value' => 'changeCreat'
//        ],
    [
        'attribute' => 'Created_At',
        'format' => 'raw',
        'width' => '125px',
        'value' => 'countUpdateTime',
        'label' => 'Trạng thái',
        'headerOptions' => ['style'=>'text-align:center']
    ],
    //            [
    //                'attribute' => 'Updated_At',
    //                //'format'=>'ra',
    //                'value' => 'changeUpdate'
    //            ],
    //'Updated_At',

    [
        'class' => 'kartik\grid\ActionColumn',
        'vAlign'=>'top',
        'template' => '{view}'
    ],
];
?>
<br>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'pjax' => true,
    'pjaxSettings' => ['options' => ['id' => 'booking_order']],
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],

    'toolbar' => [
        [
            'content'=>
                $this->render('_search', ['model' => $searchModel,'timeRanger' => $timeRanger])
        ],
        '{toggleData}',
        '{export}',

        //$fullExportMenu,
    ]
]);
?>
