<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmvoucherlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tra mã Voucher';
$this->params['breadcrumbs'][] = $this->title;


$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    //'POS_PARENT',
    //'POS_ID',
//    'VOUCHER_CODE',
    [
        'attribute' => 'VOUCHER_CODE',
//        'width' => '110px',
    ],
//    'VOUCHER_CAMPAIGN_ID',
//    'VOUCHER_CAMPAIGN_NAME',
    //'VOUCHER_DESCRIPTION:ntext',
/*    [
        'attribute' => 'DISCOUNT_TYPE',
        'label' => 'Giảm giá',
        'value' => 'discountValue',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> [1 => 'Giảm tiền', 2 => 'Giảm %'],
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Loại oại giảm giá',
            'class' =>'select2-filter-city' // Set width của filter
        ],
    ],*/
//     'DATE_CREATED',
//     'DATE_START',
//     'DATE_END',
    // 'DATE_HASH',
    // 'AMOUNT_ORDER_OVER',
    // 'DISCOUNT_TYPE',
    // 'DISCOUNT_AMOUNT',
    // 'DISCOUNT_EXTRA',
    // 'IS_ALL_ITEM',
    // 'ITEM_TYPE_ID_LIST',
     //'STATUS',
    [
        'attribute' => 'DATE_START',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_TIME_FORMAT_2'],strtotime($model->DATE_START));
        }

    ],
    [
        'attribute' => 'DATE_END',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_TIME_FORMAT_2'],strtotime($model->DATE_END));
        }

    ],
    [
        'attribute' => 'USED_DATE',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_TIME_FORMAT_2'],strtotime($model->USED_DATE));
        }

    ],
    [
        'attribute' => 'USED_POS_ID',
        'value' => function ($model) use ($allPosMap){
            return @$allPosMap[$model->USED_POS_ID];
        }
    ],
    [
        'attribute' => 'USED_DISCOUNT_AMOUNT',
        'format'=>['decimal',0]
        /*'format' => 'raw',
        'value' => 'statusText'*/
    ],
    [
        'attribute' => 'USED_BILL_AMOUNT',
        'format'=>['decimal',0]
        /*'format' => 'raw',
        'value' => 'statusText'*/
    ],
    'USED_SALE_TRAN_ID',
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

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}'
    ],
];
?>

<br>
<div>
    <?= $this->render('_search_check', [
        'model' => $searchModel,
        'allPosMap' => $allPosMap,
    ])?>
</div>


<div class="grid-view"><div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <?= $this->title ?></h3>
        </div>
        <div class="rc-handle-container">
            <div class="box-body">
                <div>
                    <?php
//                    var_dump($model);
//                    die();
                    if(@$model->VOUCHER_CODE){
                        echo $this->render('view', [
                            'model' => $model,
                        ]);
                    }else{
                        echo '<p class="text-center">Không có dữ liệu</p>';
                    }
                    ?>
                </div>
            </div><!-- /.box-body -->
        </div>
</div>







