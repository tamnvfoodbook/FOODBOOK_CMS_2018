<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmposparentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmposparents';
$this->params['breadcrumbs'][] = $this->title;
?>
<BR>

<?php
$gridColumns = [

    ['class' => 'yii\grid\SerialColumn'],

    'ID',
    'NAME',
//    [
//        'attribute' => 'DESCRIPTION',
//        'width' => '160px',
//    ],

    'AHAMOVE_ID',
    //'POS_TYPE',
    //'IMAGE',
    [
        'attribute' => 'IMAGE',
        'width' => '60px',
        'format' => ['image',['width'=>'50','height'=>'50']],
        'label' => 'Thumb',
    ],

    [
        'attribute' => 'POS_TYPE',
        'value' => 'postypelabel',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> [0 => 'Mix Pos', 1 => 'Pos Pc', 2 => 'Pos Mobile'],
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn...',
            'class' =>'select2-filter-city' // Set width của filter
        ],

    ],
    [
        'attribute' => 'IS_GIFT_POINT',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> [0 => 'Không tích điểm', 1 => 'Có tích điểm'],
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn...',
            'class' =>'select2-filter-city' // Set width của filter
        ],

    ],
    [
        'class' => 'yii\grid\ActionColumn',
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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-cutlery"></i>'.$this->title.'</h3>',
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