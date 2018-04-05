<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmdistrictSearch */
/* @var $allDistrictMap backend\controllers\DmdistrictController */
/* @var $allCityMap backend\controllers\DmdistrictController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'District';
$this->params['breadcrumbs'][] = $this->title;
?>

<BR>

<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'ID',
        'width' => '70px'

    ],
    //'DISTRICT_NAME',
    [
        'attribute' => 'DISTRICT_NAME',
        'value' => 'DISTRICT_NAME',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> $allDistrictMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn Quận/ Huyện',
            'class' =>'select2-filter' // Set width của filter
        ],
    ],
    [
        'attribute' => 'CITY_ID',
        'value' => 'city.CITY_NAME',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> $allCityMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn thành phố',
            'class' =>'select2-filter' // Set width của filter
        ],
    ],

    'SORT',

    ['class' => 'yii\grid\ActionColumn',
        'template'=>'{view} {update}'
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
    'toolbar' => [
        //'{export}',
        [
            'content'=>
                Html::a('Creat', ['create'], ['class' => 'btn btn-success']),
        ],
        //$fullExportMenu,
    ]
]);
?>