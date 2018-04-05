<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmvouchercampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Phiếu giảm giá';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    'ID',
    //'CITY_ID',
    'POS_PARENT',
    //'POS_ID',

    [
        'attribute' => 'POS_ID',
        'width'=>'250px',
        'value' => function($model) {
            return ($model->POS_ID) ? $model->pos->POS_NAME : 'Toàn hệ thống '.$model->POS_PARENT;
        },

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
    [
        'attribute' => 'CITY_ID',
        'width'=>'100px',
        'value' => 'city.CITY_NAME',
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

    'VOUCHER_NAME',
    //'VOUCHER_DESCRIPTION:ntext',
    'QUANTITY_PER_DAY',
    'DATE_CREATED',
    // 'DATE_UPDATED',
     'DATE_START',
     'DATE_END',
    // 'TIME_HOUR_DAY',
    // 'TIME_DATE_WEEK:datetime',
    // 'AMOUNT_ORDER_OVER',
    // 'DISCOUNT_TYPE',
    // 'DISCOUNT_AMOUNT',
    // 'DISCOUNT_EXTRA',
    // 'IS_ALL_ITEM',
    // 'ITEM_TYPE_ID_LIST',
    //'ACTIVE',
    [
        'attribute' => 'ACTIVE',
        'width'=>'100px',
    ],
    // 'MANAGER_ID',
    // 'MANAGER_NAME',
    // 'AFFILIATE_ID',
    // 'AFFILIATE_DISCOUNT_TYPE',
    // 'AFFILIATE_DISCOUNT_AMOUNT',
    // 'AFFILIATE_DISCOUNT_EXTRA',

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}{delete}'
    ],
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
    'filterModel' => $searchModel,
    'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
    'toolbar' => [
        //'{export}',
        //$fullExportMenu,
        ['content'=>
            Html::a('Tạo chiến dịch', ['create'], ['class' => 'btn btn-success'])
        ],
    ]
]);
?>
