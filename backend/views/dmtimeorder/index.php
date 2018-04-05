<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmtimeorderSearch */
/* @var $posActiveMap backend\controllers\DmtimeorderController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thời gian bán Delivery';
$this->params['breadcrumbs'][] = $this->title;
?>

<BR>

<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    //'ID',
    //'POS_ID',
    [
        'attribute' => 'POS_ID',
        'value' => 'pos.POS_NAME',

        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> $posActiveMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn nhà hàng',
            'class' =>'select2-filter' // Set width của filter
        ],
    ],
    //'TYPE',
    [
        'attribute' => 'TYPE',
        'value' => 'type',
    ],
    [
        'attribute' => 'DAY_OF_WEEK',
        'value' => 'changeDate',
    ],
    'TIME_START',
    'TIME_END',
    'DAY_OFF',
    //'ACTIVE',
    [
        'attribute' => 'ACTIVE',
        'value' => 'ACTIVE',
        'filter' => Html::activeDropDownList($searchModel, 'ACTIVE', ['1'=>'Active','0'=> 'Deactive'],['class'=>'form-control','prompt' => 'Chọn trạng thái']),
    ],

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update}{delete}'
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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-time"> </i> '.$this->title.'</h3>',
    ],
    'toolbar' => [
        //'{export}',
        [
            'content'=>
                Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success']),
        ],
        //$fullExportMenu,
    ]
]);
?>
