<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmeventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sự kiện CSKH';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

//    'id',
    'event_name',
    [
        'label'=>'Giảm giá',
        'format' => 'raw',
        'value'=>function ($data) {
            if($data->discount_type == 1){
                return $data->discount_amount.' VNĐ';
            }else{
                return $data->discount_extra * 100 .'%';
            }
        },
    ],
    [
        'label'=>'Số lần',
        'format' => 'raw',
        'value'=>function ($data) {
            return $data->min_eat_count.' - '.$data->max_eat_count;
        },
    ],
    [
        'label'=>'Số tiền',
        'format' => 'raw',
        'value'=>function ($data) {
            return $data->min_pay_amount.' - '.$data->max_pay_amount;
        },
    ],
    [
        'label'=>'Tiếp cận dự kiến',
        'format' => 'raw',
        'value'=>function ($data) {
            return $data->expected_approach;
        },
    ],
    [
        'label'=>'Tiếp cận thực tế',
        'format' => 'raw',
        'value'=>function ($data) {
            return $data->practical_approach;
        },
    ],
    [
        'label'=>'Ngày tối thiểu chưa trở lại',
        'width' => '100px',
//        'format' => 'raw',
        'value'=>function ($data) {
            return $data->last_visit_frequency;
        },
    ],
    [
        'label'=>'Ngày bắt đầu',
        'format' => 'raw',
        'value'=>function ($data) {
            return $data->date_start;
        },
    ],
    [
        'label'=>'Trạng thái',
        'format' => 'raw',
        'value'=>function ($data) {
            return $data->status ? "Hoàn thành" : "Chờ chạy";
        },
    ],
    [
        'format' => 'raw',
        'value'=>function ($data) {
            return $data->status ? "Active" : "Deactive";
        },
    ],

//    'status',
    'active',
//    'last_visit_frequency',

    ['class' => 'yii\grid\ActionColumn'],
];
?>
<BR>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
//    'pjax' => true,
//    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
    'columns' => $gridColumns,

    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
    'toolbar' => [
        //'{export}',
//        ['content'=>
//            Html::a('Create', ['create'], ['class' => 'btn btn-success'])
//        ],
    ]
]);
?>

