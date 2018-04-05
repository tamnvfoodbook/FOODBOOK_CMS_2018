<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmitemtypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nhóm món';
$this->params['breadcrumbs'][] = $this->title;


$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'POS_ID',
        'value' => function ($data) use ($allPosMap){
            return @$allPosMap[$data['POS_ID']];
        },
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
    'ITEM_TYPE_ID',
    'ITEM_TYPE_NAME',
    'MAX_ITEM_CHOICE',
    'ACTIVE',
    // 'LAST_UPDATED',

    ['class' => 'yii\grid\ActionColumn',
        'template'=>'{view} {update}'
    ],
];


?> <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Nhà hàng</h3>',
    ],
    'toolbar' => [

        ['content'=>
            Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success'])
        ],
        '{export}',
    ]
]);
?>
