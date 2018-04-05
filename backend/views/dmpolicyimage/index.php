<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmpolicyimageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ảnh sticker';
$this->params['breadcrumbs'][] = $this->title;
//echo '<pre>';
//var_dump($cityMap);
//echo '</pre>';
//die();

$gridColumns = [

    ['class' => 'yii\grid\SerialColumn'],
//    'ID',
    'DESCRIPTION',
    'LIST_POS_PARENT',
    'DESCRIPTION_URL:url',
    'SORT',
    'DATE_CREATED',
    'DATE_START',
    'DATE_END',
    [
        'attribute' => 'IMAGE_LINK',
        'format' => ['image',['width'=>'50','height'=>'50']],
        'label' => 'Ảnh',
        'headerOptions' => ['style'=>'color:#3c8dbc'],
    ],
//    [
//        'attribute' => 'CITY_ID',
//        'filterType'=> GridView::FILTER_SELECT2,
//        'filter'=> $cityMap,
//        'filterWidgetOptions'=>[
//            'pluginOptions'=>['allowClear'=>true],
//        ],
//        'filterInputOptions'=>[
//            'placeholder'=>'Chọn thành phố',
//            //'class' =>'select2-filter' // Set width của filter
//        ],
//        'value' => function ($model) use($cityMap){
//            return $cityMap[$model->CITY_ID];
//        },
//    ],
    [
        'attribute' => 'CITY_ID',
        'value' => function ($model) use($cityMap){
            return @$cityMap[@$model->CITY_ID];
        },
        //'label' => 'Thành phố',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> $cityMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn thành phố',
            'class' =>'select2-filter-city' // Set width của filter
        ],
    ],
    'ACTIVE',
    ['class' => 'yii\grid\ActionColumn',
        'template'=>'{view} {update}'
    ],

];
?>
<BR>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    //'pjax' => true,
    //'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-picture"></i> '.$this->title.'</h3>',
    ],
    'toolbar' => [
            [
                'content'=>
                    Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success']),
            ],
        '{toggleData}',
        '{export}',

        //$fullExportMenu,
    ]
]);
?>



