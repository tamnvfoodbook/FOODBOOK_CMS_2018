<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderrateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



?>

    <?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        //'pos_id',
        [
            'attribute' => 'pos_id',
            'value' => function ($model) use ($allPosMap) {
                return @$allPosMap[$model['pos_id']];
            },
            'label' => 'Nhà hàng'
        ],

        //'dmShift',
        //'member_id',
        //'created_at',

        [
            'attribute' => 'rate_average',
            'format'=>['decimal',2],
            'label' => 'Điểm trung bình',
        ],
        [
            'attribute' => 'count_rate',
            'label' => 'Lần đánh giá',
        ],
        [
            'attribute' => 'reson_expensive_price',
            'label' => 'Đồ ăn đắt',
        ],
        [
            'attribute' => 'reson_bad_service',
            'label' => 'Dịch vụ kém',
        ],
        [
            'attribute' => 'reson_bad_food',
            'label' => 'Đồ ăn tồi',
        ],
        [
            'attribute' => 'reson_bad_shipper',
            'label' => 'Giao hàng kém',
        ],
        [
            'attribute' => 'reson_other',
            'label' => 'Đánh giá khác',
        ],

//         'reson_expensive_price',
//         'reson_bad_service',
//         'reson_bad_shipper',
//         'reson_other',
        //'reson_note',
        // 'published',


//        ['class' => 'yii\grid\ActionColumn',
//            'template'=>'{view} {update}'
//        ],

    ];
    ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showPageSummary' =>false,
//        'filterModel' => $searchModel,
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
//            '{toggleData}',
            '{export}',
            //$fullExportMenu,
        ]
    ]);
    ?>

