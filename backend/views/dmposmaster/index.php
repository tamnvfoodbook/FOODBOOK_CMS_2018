<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmposmasterSearch */
/* @var $allCityMap backend\controllers\DmposmasterController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nhóm điểm';
$this->params['breadcrumbs'][] = $this->title;
?>

<BR>

<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    //'ID',
    'POS_MASTER_NAME',
    'DESCRIPTION',
    //'IMAGE_PATH',
    [
        'attribute' => 'IMAGE_PATH',
        'format' => ['image',['width'=>'50','height'=>'50']],
    ],
    //'IS_COLLECTION',
    //'ACTIVE',
    [
        'attribute' => 'ACTIVE',
        'value' => 'ACTIVE',
        'filter' => Html::activeDropDownList($searchModel, 'ACTIVE', ['1'=>'Active','0'=> 'Deactive'],['class'=>'form-control','prompt' => 'Chọn trạng thái']),
    ],

//    'FOR_BREAKFAST',
//    'FOR_LUNCH',
//    'FOR_DINNER',
//    'FOR_MIDNIGHT',
    'SORT',
    //'CITY_ID',

    [
        'attribute' => 'CITY_ID',
        'value' => 'city.CITY_NAME',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> $allCityMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn nhà hàng',
            'class' =>'select2-filter' // Set width của filter

        ],
        /*'group' => true,*/
    ],


    //'TIME_START',
    // 'DAY_ON',
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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
    'hover' =>true,
    'toolbar' => [
        //'{export}',
        //$fullExportMenu,
        ['content'=>
            Html::a('Create', ['create'], ['class' => 'btn btn-success'])
        ],
    ]
]);
?>

