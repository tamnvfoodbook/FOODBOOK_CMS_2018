<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
//use yii\widgets\Pjax;
use yii\helpers\Url;


$this->title = 'Báo cáo món ăn';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    [
        'class'=>'kartik\grid\SerialColumn',
        'vAlign'=>'top'
    ],
    [
        'attribute' => 'POS_ID',
        'label' => 'Nhà hàng',
        'value'=> function($data,$row) use ($allPosMap){

            return @$allPosMap[$data[POS_ID]];
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

    [
        'attribute' => 'ACTIVE',
    ],
    [
        'attribute' => 'DEACTIVE',
    ],
    [
        'attribute' => 'UPDATED',
    ],
    [
        'attribute' => 'LAST_UPDATED',
    ],
    [
        'attribute' => 'TOTAL',
    ],


    /*[
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
    ],*/


    [
        'class' => 'kartik\grid\ActionColumn',
        'vAlign'=>'top',
        'template'=>'{view}'

    ],
];

?>
<br>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title">'.$this->title.'</h3>',
    ],
    'toolbar' => [
//        [
//            'content'=>
//        ],
        '{toggleData}',
        '{export}',
        //$fullExportMenu,
    ]
]);
?>