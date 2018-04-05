<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmitemSearch */
/* @var $allPosMap backend\controllers\DmitemController */
/* @var $itemTypeMasterMap backend\controllers\DmitemController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Điểm khách hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<BR>

<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'MEMBERSHIP_ID',
    'POS_PARENT',
    'AMOUNT',
    'POINT',
    'EAT_FIRST_DATE',
    // 'EAT_LAST_DATE',
    // 'EAT_COUNT',
    // 'EAT_COUNT_FAIL',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view} {update}'
    ],
];
?>

<?=Html::beginForm(['dmitem/setactive'],'post');?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
    'toolbar' => [
        //'{export}',
    ]
]);
?>

<?= Html::endForm();?>
