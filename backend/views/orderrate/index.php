<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderrateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orderrates';
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<div class="orderrate-index">
    <?php
    $gridColumns = [

        ['class' => 'yii\grid\SerialColumn'],
        //'pos_id',
        //'pos_parent',
        [
            'attribute' => 'pos_parent',
            'filterType'=> GridView::FILTER_SELECT2,
            'filter'=> $allPosparentMap,
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>[
                'placeholder'=>'Chọn thương hiệu',
                'class' =>'select2-filter' // Set width của filter
            ],

        ],
        [
            'attribute' => 'pos_id',
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

        ],


        //'dmShift',
        //'member_id',
        //'created_at',
        [
            'attribute' => 'member_id',
            'value' => 'memberInfo',
            'format' => 'raw'
        ],

        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return date(Yii::$app->params['DATE_TIME_FORMAT'],$model->created_at->sec);
            },

            //'width' => '110px',
            'filterType'=> GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions' => [
                'presetDropdown' => true,
                'pluginOptions' => [
                    'format' => 'DD-MM-YYYY',
                    'separator' => ' - ',
                    'opens'=>'left',
                ] ,
            ],
        ],

        'score',
        [
            'attribute' => 'reson',
            'headerOptions' => ['style'=>'color:#3c8dbc'],
            'label' => 'Đánh giá',
            'filterType'=> GridView::FILTER_SELECT2,
            'filter'=> [1 => 'Đồ ăn kém',2 => 'Giá đắt', 3 => 'dịch vụ kém',4 => 'Giao hàng kém', 5 => 'Đánh giá khác'],
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>[
                'placeholder'=>'Chọn loại',
                'class' =>'select2-filter-city' // Set width của filter
            ],

        ],
        // 'reson_expensive_price',
        // 'reson_bad_service',
        // 'reson_bad_shipper',
        // 'reson_other',
        //'reson_note',
        [
            'attribute' => 'reson_note',
            'width' => '300px'

        ],
        // 'published',


//        ['class' => 'yii\grid\ActionColumn',
//            'template'=>'{view} {update}'
//        ],

    ];
    ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'pjax' => true,
        //'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'columns' => $gridColumns,
        'panel' => [
            'type' => GridView::TYPE_SUCCESS,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-cutlery"></i> '.$this->title.'</h3>',
        ],
        'toolbar' => [
//            [
//                'content'=>
//                    Html::a('Tạo nhà hàng', ['create'], ['class' => 'btn btn-success']),
//            ],
            '{toggleData}',
            '{export}',

            //$fullExportMenu,
        ]
    ]);
    ?>




</div>
