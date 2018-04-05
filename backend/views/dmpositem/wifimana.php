<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\WmitemimagelistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wmitemimagelists';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],

    //'ID',
    //'POS_ID',
    'NAME',
    'PRICE',
    'DESCRIPTION',
     //'IMAGE_PATH',
    [
        'attribute' => 'IMAGE_PATH',
        'format' => ['image',['width'=>'50','height'=>'50']],
        'label' => 'Ảnh',
    ],
     'ACTIVE',
     'SORT',

    ['class' => 'kartik\grid\ActionColumn'],
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
        /*['content'=>
            Html::a('Create Dmpos', ['create'], ['class' => 'btn btn-success'])
        ],*/
    ]
]);
?>