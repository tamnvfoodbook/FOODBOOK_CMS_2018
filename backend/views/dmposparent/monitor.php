<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmposparentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Theo dõi thương hiệu';
$this->params['breadcrumbs'][] = $this->title;
?>
<BR>

<?php
$gridColumns = [

    ['class' => 'yii\grid\SerialColumn'],

    'ID',
    'NAME',
    //'DESCRIPTION',
    [
        'attribute' => 'SOURCE',
        'width'=>'310px',
        //'filterType'=> '\kartik\widgets\Select2',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> $allPartnerMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn nguồn',
            'class' =>'select2-filter' // Set width của filter

        ],
    ],
    //'CREATED_AT',
    [
        'attribute' => 'CREATED_AT',
        //'label' => 'Ngày tạo',
        'filterType'=> GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
            'presetDropdown' => true,
            'pluginOptions' => [
                'format' => 'YYYY-MM-DD',
                'separator' => ' - ',
                'opens'=>'left',
            ] ,
        ],
        //'format' => 'raw',
    ],
//    'IMAGE',
    [
        //'attribute' => 'IMAGE',
        //'width' => '60px',
        'value' => 'countpos',
        'label' => 'Số điểm',
        'headerOptions' => ['style'=>'color:#3c8dbc'],

    ],


//    [
//        'class' => 'yii\grid\ActionColumn',
//        'template'=>'{view} {update}'
//    ],

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
    'toolbar' => [
        //'{export}',
        /*[
            'content'=>
                Html::a('Creat', ['create'], ['class' => 'btn btn-success']),
        ],*/
        //$fullExportMenu,
    ]
]);
?>