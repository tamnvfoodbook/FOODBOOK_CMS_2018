<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmdeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmdevices';
$this->params['breadcrumbs'][] = $this->title;
?>

<BR>

<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    //'ID',
    'DEVICE_ID',
    [
        'attribute' => 'DEVICE_TYPE',
        'value' => 'dischargedLabel',
        'filter' => Html::activeDropDownList($searchModel, 'DEVICE_TYPE', ['1'=>'ANDROID','2'=> 'IOS'],['class'=>'form-control','prompt' => 'Chọn trạng thái']),
    ],
    //'PUSH_ID',
    'MSISDN',
    'VERSION',
    [
        'attribute' => 'LAST_UPDATED',
        'value' => 'LAST_UPDATED',
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
    ],

    [
        'attribute' => 'CREATED_AT',
        'value' => 'CREATED_AT',
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
    ],
    //'CREATED_AT',
    'MODEL',
    'LANGUAGE',
    [
        'attribute' => 'ACTIVE',
        'value' => 'ACTIVE',
        'filter' => Html::activeDropDownList($searchModel, 'ACTIVE', ['1'=>'Active','0'=> 'Deactive'],['class'=>'form-control','prompt' => 'Chọn trạng thái']),
    ],

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}',
    ],
];
?>



<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'pjax' => true,
    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-cutlery"></i> '.$this->title.'</h3>',
    ],
    /*'toolbar' => [
        //'{export}',
        [
            'content'=>
                Html::a('Creat', ['create'], ['class' => 'btn btn-success']),
        ],
        //$fullExportMenu,
    ]*/
]);
?>
