<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmposimagelistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $allPosMap backend\controllers\DmposimagelistController */

$this->title = 'Dmposimagelists';
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

        'filter'=> $allPosMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn nhà hàng',
            'class' =>'select2-filter' // Set width của filter

        ],
        'group' => true,
    ],

    'DESCRIPTION',
    [
        'value' => 'IMAGE_PATH',
        'format' => ['image',['width'=>'50','height'=>'50']],
    ],
    [
        'attribute' => 'ACTIVE',
        'value' => 'ACTIVE',
        'filter' => Html::activeDropDownList($searchModel, 'ACTIVE', ['1'=>'Active','0'=> 'Deactive'],['class'=>'form-control','prompt' => 'Chọn trạng thái']),
    ],
    'SORT',

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{forgot}{view}{update}{delete}',
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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>'.$this->title.'</h3>',
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
