<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmitemtypemasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh mục Item Type Master';
$this->params['breadcrumbs'][] = $this->title;
?>

<BR>

<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    'ID',
    'ITEM_TYPE_MASTER_NAME',
    'DESCRIPTION',
    'SORT',
    //'IMAGE_PATH',
    [
        'attribute' => 'IMAGE_PATH',
        'format' => ['image',['width'=>'50','height'=>'50']],
    ],

    ['class' => 'yii\grid\ActionColumn'],
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
                Html::a('Create', ['create'], ['class' => 'btn btn-success'])
        ],
        //$fullExportMenu,
    ]
]);
?>
