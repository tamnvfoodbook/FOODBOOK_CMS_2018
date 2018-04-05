<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('js/jquery-1.11.3.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/jquery-1.6.1.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/jssip-sample-impl.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/jssip.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/rtcninja-temasys.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('css/popup-session.css', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderonlinelogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Xử lý đơn hàng hủy';
?>
 <br>
<?php
$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'vAlign'=>'top'
    ],

    [
        'attribute' => 'pos_is_call_center',
        'format' => 'raw',
        'value' => 'iscallcenter',
        'label' => 'TĐ'
    ],
    'foodbook_code',
    [
        'attribute' => 'booking_info',
        'format' => 'raw',
        'value' => 'bookinginfo',
        'label' => 'Loại giao hàng'
    ],

    //'_id',

    'ahamove_code',

    //'username',
    //'user_phone',
    [
        'attribute' => 'user_phone',
        'value' => 'memberinfo',
        'label' => 'Khách hàng',
        'format' => 'html'
    ],
    //'coupon_log_id',
    //'pos_id',
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
        'attribute' => 'pos_id',
        'format' => 'raw',
        'value' => 'posphonenumber',
        'label' => 'SĐT Nhà hàng'
    ],*/


    /*[
        'attribute' => 'pos_is_call_center',
        'value' => 'pos.IS_CALL_CENTER',
        'label' => 'Qua TĐ'
    ],*/

    //'isCallCenterConfirmed',
    //'status',
//    [
//        'attribute' => 'status',
//        'format' => 'raw',
//        'value' => 'imgestatus',
//        'vAlign'=>'middle',
//        'hAlign'=>'center',
//
//    ],

    'to_address',

/*    [
        'format' => 'raw',
        'value' => 'suggest',
        
        'label' => 'Hướng dẫn'
    ],*/
    //'distance',
    //'total_fee',

//            [
//                'attribute' => 'created_at',
//                'format' => 'raw',
//                'value' => 'changeTime',
//                'label' => 'Thời gian tạo'
//            ],
    [
        'attribute' => 'updated_at',
        'format' => 'raw',
        'vAlign'=>'top',
        'hAlign'=>'center',
        'value' => 'changeUpdateTime',
        'label' => 'Trạng thái'
    ],

    //'order_data_item',
    // 'pos_workstation',
    //'user_id',

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
        'format' => 'raw',
        'value' => 'actions',
        'label' => 'Thao tác',
        'vAlign'=>'top',
        'hAlign'=>'center',
        
    ],


//    [
//        'class' => 'yii\grid\ActionColumn',
//        //'template'=>'{view}{update}{delete}'
//    ],
];
?>

<style>
    .label-detail{
        margin-left: 1%;
    }

</style>

<div class="orderonlinelog-index">
    <?php Pjax::begin([
        'id' => 'medicine'
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,

        'columns' => $gridColumns,
        'panel' => [
            'type' => GridView::TYPE_SUCCESS,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
        ],
        'toolbar' => [
            //'{export}',
            //Html::submitButton('Tạo đơn hàng', ['class' => 'btn btn-success']),
//            Html::a("Tạo đơn hàng", ['orderonlinelog/creatorder','id' =>'' ], ['class' => 'btn btn-success']),
//            Html::a("Làm mới", ['orderonlinelog/indexstatic'], ['class' => 'btn btn-success','id' => 'refreshButton']),
        ]
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>




<style type="text/css">
    #target {
        cursor: pointer;
        font-weight: bold;
        font-style: italic;
        color: #003399;
    }
    td {
        border-bottom: 1px solid #CCC;
    }
</style>



