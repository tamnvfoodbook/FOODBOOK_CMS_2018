<?php

use kartik\grid\GridView;
use backend\assets\AppAsset;

AppAsset::register($this);


if(@$result->data->user_info->Member_Name){
    $this->title = @$result->data->user_info->Member_Name .' - Loại thành viên : '.@$result->data->user_info->Membership_Type_Name .' - Số điểm : '.@$result->data->user_info->Point  ;
}else{
    $this->title = @$result->data->user_info->Id .' - Loại thành viên : '.@$result->data->user_info->Membership_Type_Name .' - Số điểm : '.@$result->data->user_info->Point  ;
}


$gridColumns = [
    //['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'foodbook_code',
        'label' => 'Code'
    ],
    [
        'attribute' => 'pos_id',
        'value' => function ($model) use($allPosMap){
            return $allPosMap[$model->pos_id];
        },
        'label' => 'Nhà hàng'
    ],
    //'ahamove_code',
    //'user_id',
    [
        'attribute' => 'to_address',
        'label' => 'Địa chỉ'
    ],
    //'username',
    //'user_phone',
    //'coupon_log_id',
    [
        'attribute' => 'amount',
        'label' => 'Tổng tiền',
        //'value' => 'creatTime',
    ],[
        'attribute' => 'created_at',
        'label' => 'Ngày tạo',
        //'value' => 'creatTime',
    ],

//    [
//        'attribute' => 'note',
//        'width' => '200px'
//    ],
];
?>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
    'toolbar' => null
]);
?>