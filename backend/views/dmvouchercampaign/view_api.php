<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Dmvouchercampaign;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmvouchercampaign */

//echo '<pre>';
//var_dump($model);
//echo '</pre>';
//die();

?>
<div class="dmvouchercampaign-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'ID',
            [
                'attribute' => 'voucher_campaign_name',
                'label' => 'Tên'
            ],
            [
                'attribute' => 'pos_id',
                'value' => call_user_func(function ($data) {
                    if($data->pos_id == 0){
                        return 'Toàn hệ thống';
                    }else{
                        return 'Giám giá cho điểm';
                    }
                }, $model),
                'label' => 'Áp dụng'
            ],

            [
                'attribute' => 'discount_type',
                'value' => call_user_func(function ($data) {
                    if($data->discount_type == 1){
                        return $data->discount_extra*100 .'%';
                    }else{
                        return number_format($data->discount_amount). 'đ';
                    }
                }, $model),
                'label' => 'Giảm giá'
            ],
            [
                'attribute' => 'quantity_per_day',
                'label' => 'Số lượng được phép tặng mỗi ngày'
            ],
            [
                'attribute' => 'duration',
                'label' => 'Thời gian kể từ ngày phát hành'
            ],



//            [
//                'attribute' => 'discount_max',
//                'label' => 'Mức giảm giá tối đa'
//            ],
            [
                'attribute' => 'campaign_type',
                'value' => call_user_func(function ($data) {
                    return Yii::$app->params['campainType'][$data->campaign_type];
                }, $model),
                'label' => 'Loại chương trình'
            ],
            [
                'attribute' => 'active',
                'value' => call_user_func(function ($data) {
                    return ($data->active == 1) ? 'Đang hoạt động' : 'Đã dừng';
                }, $model),
                'label' => 'Trạng thái'
            ],
            [
                'attribute' => 'requied_member',
                'value' => call_user_func(function ($data) {
                    return ($data->active == 1) ? 'Có' : 'Không';
                }, $model),
                'label' => 'Yêu cầu mã hội viên'
            ],


        ],
    ]) ?>

</div>
