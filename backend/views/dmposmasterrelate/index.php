<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmposmasterrelateSearch */
/* @var $allPosMasterMap backend\controllers\DmposmasterrelateController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quan hệ Nhà hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<BR>

<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'ID',
        'width' => '100px',

    ],
    //'POS_ID',
    [
        'attribute' => 'POS_ID',
        'value' => 'pos.POS_NAME',
        'label' => 'Nhà hàng',
        'width' => '150px',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> $allPosMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn nhà hàng',
            'class' =>'select2-filter' // Set width của filter
        ],
        'group'=>true,  // enable grouping

    ],
    [
        'attribute' => 'POS_MASTER_ID',
        'value' => 'posmaster.POS_MASTER_NAME',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> $allPosMasterMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn loại',
            'class' =>'select2-filter' // Set width của filter
        ],
    ],
    [
        'attribute' => 'city',
        'value' => 'city',
        'label' => 'Thành phố',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> $allCityMap,
        'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
],
        'filterInputOptions'=>[
        'placeholder'=>'Chọn loại',
        'class' =>'select2-filter' // Set width của filter
],
    ],
    //'POS_MASTER_ID',
    'SORT',

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update}'
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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-cutlery"></i>'.$this->title.'</h3>',
    ],
    'toolbar' => [
        //'{export}',
        [
            'content'=>
                Html::a('Create', ['create'], ['class' => 'btn btn-success']),
        ],
        //$fullExportMenu,
    ]
]);
?>
