<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmvoucherlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách mã đã sử dụng';
$this->params['breadcrumbs'][] = $this->title;


$gridColumns = [
    ['class'=>'kartik\grid\SerialColumn',],
    [
        'attribute' => 'USED_POS_ID',
        'value' => function ($model) use ($allPosMap){
            return @$allPosMap[$model->USED_POS_ID];
        }
    ],
    [
        'attribute' => 'COUNT_BILL',
        'format'=>['decimal',0],
        'label' => 'Số lượng sử dụng',
        'pageSummary'=>true,
        'pageSummaryFunc'=>GridView::F_SUM
        /*'format' => 'raw',
        'value' => 'statusText'*/
    ],

    [
        'attribute' => 'SUM_DISCOUNT_AMOUNT',
        'format'=>['decimal',0],
        'label' => 'Tiền giảm giá',
        'pageSummary'=>true,
        'pageSummaryFunc'=>GridView::F_SUM
        /*'format' => 'raw',
        'value' => 'statusText'*/
    ],
    [
        'attribute' => 'SUM_USED_BILL_AMOUNT',
        'format'=>['decimal',0],
        'label' => 'Tổng hóa đơn',
        'pageSummary'=>true,
        'pageSummaryFunc'=>GridView::F_SUM
        /*'format' => 'raw',
        'value' => 'statusText'*/
    ],
    [
        'attribute' => 'AVG_USED_DISCOUNT_AMOUNT',
        'format'=>['decimal',0],
        'label' => 'Bình quân giảm giá'
        /*'format' => 'raw',
        'value' => 'statusText'*/
    ],

    [
        'attribute' => 'AVG_USED_BILL_AMOUNT',
        'format'=>['decimal',0],
        'label' => 'Bình quân hóa đơn'
        /*'format' => 'raw',
        'value' => 'statusText'*/
    ],
    // 'BUYER_INFO',
    // 'AFFILIATE_ID',
    // 'AFFILIATE_DISCOUNT_TYPE',
    // 'AFFILIATE_DISCOUNT_AMOUNT',
    // 'AFFILIATE_DISCOUNT_EXTRA',
    // 'AFFILIATE_USED_TOTAL_AMOUNT',
    // 'USED_DATE',
    // 'USED_DISCOUNT_AMOUNT',
    // 'USED_BILL_AMOUNT',
    // 'USED_MEMBER_INFO',
//     'USED_POS_ID',
    // 'USED_SALE_TRAN_ID',

/*    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}'
    ],*/
];
?>

<br>
<div>
    <?= $this->render('_search_report', [
        'model' => $searchModel,
//        'allPosMap' => $allPosMap,
        'allCampaginMap' => $allCampaginMap,

    ])?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
    //'pjax' => true,
    //'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
    'showPageSummary' => true,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-books"></i> '.$this->title.'</h3>',
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



