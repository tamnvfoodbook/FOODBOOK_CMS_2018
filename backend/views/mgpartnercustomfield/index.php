<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmpositemSearch */
/* @var $allPosMap backend\controllers\DmpositemController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh mục nhà hàng';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    '_id',
    'partner_id',
    'partner_name',
    [
        'attribute' => 'pos_id',
        'value' => function ($model) use($allPosMap){
            return $allPosMap[$model->pos_id];
        },
        'label' => 'Nhà hàng'
    ],
    'pos_parent',
    // 'pos_name',
    // 'tags',
    // 'time_delivery',
    // 'image_url',
    // 'image_thumb_url',
    // 'active',
    // 'created_at',

    ['class' => 'yii\grid\ActionColumn'],
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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Nhà hàng</h3>',
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

