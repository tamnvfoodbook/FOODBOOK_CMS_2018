<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmshipfeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmshipfees';
$this->params['breadcrumbs'][] = $this->title;


$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    //'ID',
    [
        'attribute' => 'POS_ID',
        'value' => 'pos.POS_NAME',
        'group'=> true,
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> $allPosMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn nhà hàng',
            'class' =>'select2-filter' // Set width của filter

        ],
        /*'group' => true,*/
    ],

    'FROM_KM',
    'TO_KM',
    'FROM_AMOUNT',
    'TO_AMOUNT',
    [
        'attribute' => 'FEE',
        'value' => 'convertfee',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> $allFee,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn Fee',
            'class' =>'select2-filter' // Set width của filter

        ],
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'template'=>'{view} {update}'
    ],
];

?>
<br>


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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Nhà hàng</h3>',
    ],
    'toolbar' => [
        //'{export}',
        ['content'=>
            Html::a('Create', ['create'], ['class' => 'btn btn-success'])
        ],
    ]
]);
?>
