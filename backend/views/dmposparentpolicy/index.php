<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmitemSearch */
/* @var $allPosMap backend\controllers\DmitemController */
/* @var $itemTypeMasterMap backend\controllers\DmitemController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chính sách thương hiệu';
$this->params['breadcrumbs'][] = $this->title;
?>
<br>

<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'ID',
    'POS_PARENT',
    'EXCHANGE_POINT',
    'DESCRIPTION',
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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
    'toolbar' => [
        //'{export}',
        ['content'=>
            Html::a('Tạo mới ', ['create'], ['class' => 'btn btn-success'])
        ],
    ]
]);
?>