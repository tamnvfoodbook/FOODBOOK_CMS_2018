<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modelsDmpartnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Báo cáo Commission';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'foodbook_code',
    [
        'attribute' => 'created_at',
        'label' => 'Ngày tạo',
    ],
    [
        'attribute' => 'order_data_item',
        'label' => 'Danh sách món ăn',
    ],
    [
        'attribute' => 'amount_total_item',
        'value' => function ($data){
            return number_format($data['amount_total_item']);
        },
        'label' => 'Tổng tiền',
        'pageSummary' => true,
    ],
    [
        'attribute' => 'amount_driver_pay_mechant',
        'value' => function ($data){
            return number_format($data['amount_driver_pay_mechant']);
        },
        'label' => 'Tài xế đã trả NH',
        'pageSummary' => true,

    ],
    [
        'attribute' => 'amount_partner_commission',
        'value' => function ($data){
            return number_format($data['amount_partner_commission']);
        },
        'label' => 'Hoa hồng cho LALA',
        'pageSummary' => true,
    ],
    [
        'attribute' => 'commission_rate',
        'format'=>['decimal',0],
        'label' => 'Hoa hồng (%)',
        'value' => function ($data){
            return $data['commission_rate']*100;
        },
    ],
    [
        'attribute' => 'amount_partner_pay_merchant',
        'value' => function ($data){
            return number_format($data['amount_partner_pay_merchant']);
        },
        'label' => 'LALA còn trả NH',
        'pageSummary' => true,
    ],
    'status',

    [
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'headerOptions' => ['style'=>'color:#3c8dbc'],
        'value' => function ($data){
            return Html::a('Chi tiết', ['detailorder','id' => $data['Id'] ], ['class' => 'btn btn-primary']);
        },
        'label' => 'Thao tác'
    ],
];
?>
<br>


<div>
    <?= $this->render('_search_report_by_day', [
        'model' => $searchModel,
        'dateTime' => $dateTime,
        'partnerMap' => $partnerMap,
        'posMapWithParent' => $posMapWithParent,
    ])?>
</div>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'showFooter' => true,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book-icon"></i> '.$this->title.'</h3>',
    ],
    'showPageSummary' => true,
    'containerOptions' => [
        'format' => 'number',
        'thousandSep'=>','

    ],
    'toolbar' => [
        /*[
            'content'=>
                $this->render('_search', ['model' => $searchModel,'timeRanger' => $timeRanger,'name' => $name,'total' => $total])
        ],*/
        '{toggleData}',
        '{export}',

        //$fullExportMenu,
    ]
]);
?>
