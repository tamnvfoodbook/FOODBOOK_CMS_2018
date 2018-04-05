<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modelsDmpartnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Commission';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'partner_name',
        'label' => 'Đối tác',
        'width' => '150px',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> $partnerMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn đối tác',
            'class' =>'select2-filter' // Set width của filter
        ],

    ],
    [
        'attribute' => 'pos_name',
        'label' => 'Nhà hàng',
        'width' => '150px',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> $allPosMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn nhà hàng',
            'class' =>'select2-filter' // Set width của filter
        ],
    ],
    [
        'attribute' => 'pos_parent',
        'label' => 'Thương hiệu',
        'width' => '150px',
        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> $posparentMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn thương hiệu',
            'class' =>'select2-filter' // Set width của filter
        ],
    ],

//    'partner_id',
//    'partner_name',
//    'pos_parent',
//    'pos_id',
//    'pos_name',
    [
        'attribute' => 'commission_rate',
        'label' => 'Commission rate (%)',
        'value' => function ($model) {
            return @$model['commission_rate']*100;
        },
    ],
    [
        'attribute' => 'created_at',
        'label' => 'Ngày tạo',
        'value' => function ($model) {
            if(@$model['created_at']){
                return date(Yii::$app->params['DATE_TIME_FORMAT'],strtotime($model['created_at']));
            }

        },
    ],
    [
        'attribute' => 'updated_at',
        'label' => 'Lần cuối cập nhật',
        'value' => function ($model) {
            if(@$model['updated_at']){
                return date(Yii::$app->params['DATE_TIME_FORMAT'],strtotime($model['updated_at']));
            }

        },
    ],

    [
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'headerOptions' => ['style'=>'color:#3c8dbc'],
        'value' => function ($data){
            return Html::a('Sửa', ['update','id' => $data['id'] ], ['class' => 'btn btn-primary']);
        },
        'label' => 'Thao tác'
    ],
];
?>
<br>
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
        ['content'=>
            Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success'])
        ],
    ]
]);
?>
