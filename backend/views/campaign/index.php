<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaigns';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    //'_id',
    //'Pos_Id',
    [
        'attribute' => 'Pos_Id',
        'value' => 'pos.POS_NAME',
    ],
    [
        'attribute' => 'City_Id',
        'value' => 'city.CITY_NAME',
    ],
    'Campaign_Name',

    [
        'attribute' => 'Campaign_Created_At',
        'value' => 'campaigndate',
    ],
    [
        'attribute' => 'Campaign_Start',
        'value' => 'campaignStartdate',
    ],
    [
        'attribute' => 'Campaign_End',
        'value' => 'campaignEnddate',
    ],
    [
        'attribute' => 'Coupon_Id',
        'value' => 'coupon.Denominations',
    ],
    [
        'attribute' => 'Hex_Color',
        'value' => 'color',
        'format' => 'raw',
    ],

    //'Coupon_Id',
    //'Item_Id_List',
    //'Hex_Color',
    'Active',
    'Sort',

    ['class' => 'yii\grid\ActionColumn',
        'template'=>'{view}{update}'
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
        $fullExportMenu,
        ['content'=>
            Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success'])
        ],
    ]
]);
?>

