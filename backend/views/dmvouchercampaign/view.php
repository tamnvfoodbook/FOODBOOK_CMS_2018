<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Dmvouchercampaign;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmvouchercampaign */

$this->title = $model->VOUCHER_NAME;
$this->params['breadcrumbs'][] = ['label' => 'Các chiến dịch', 'url' => ['statistics']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmvouchercampaign-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if($model->ACTIVE){
                echo Html::a('Hủy', ['delete', 'id' => $model->ID], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);
            }

         ?>
        <?php if($model->TIME_HOUR_DAY)
            echo Html::a('Danh sách mã', ['detail', 'id' => $model->ID,'name' => $model->VOUCHER_NAME], [
            'class' => 'btn btn-primary'
        ]);
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'ID',
            'VOUCHER_NAME',
            [
                'attribute' => 'ACTIVE',
                'value' => call_user_func(function ($data) {
                    return ($data->ACTIVE) ? 'Đang chạy' : 'Đã dừng';
                }, $model),
            ],
            //'VOUCHER_DESCRIPTION:ntext',
//            'POS_PARENT',
            [
                'attribute' => 'LIST_POS_ID'
            ],

//            [
//                'attribute' => 'CITY_ID',
//                'value' => $model->city->CITY_NAME
//            ],

            [
                'attribute' => 'QUANTITY_PER_DAY',
                'value' => call_user_func(function ($data) {
                    return ($data->QUANTITY_PER_DAY == 0) ? 'Không giới hạn' : $data->QUANTITY_PER_DAY ;
                }, $model),
            ],
            [
                'attribute' => 'TIME_HOUR_DAY',
                'label' => 'Số lượng đã phát hành'
            ],[
                'attribute' => 'DATE_CREATED',
                'value' => date(Yii::$app->params['DATE_FORMAT'],strtotime($model->DATE_CREATED))
            ],
            [
                'attribute' => 'DATE_START',
                'value' => date(Yii::$app->params['DATE_FORMAT'],strtotime($model->DATE_START))
            ],
            [
                'attribute' => 'DATE_END',
                'value' => date(Yii::$app->params['DATE_FORMAT'],strtotime($model->DATE_END))
            ],
            [
                'attribute' => 'DATE_LOG_START',
                'value' => date(Yii::$app->params['DATE_FORMAT'],strtotime($model->DATE_LOG_START))
            ],
            'MANY_TIMES_CODE',
            //'TIME_HOUR_DAY',
//            [
//                'attribute' => 'TIME_HOUR_DAY',
//                'value' => $model->timehourdaybeautiful,
//            ],
//            [
//                'attribute' => 'TIME_DATE_WEEK',
//                'value' => $model->dateofweek,
//            ],

            //'TIME_DATE_WEEK:datetime',
            //'AMOUNT_ORDER_OVER',
            //'DISCOUNT_TYPE',
            //'DISCOUNT_AMOUNT',
//            'MANAGER_ID',
//            'MANAGER_NAME',
//            'AFFILIATE_ID',
//            'AFFILIATE_DISCOUNT_TYPE',

            [
                'attribute' => 'DISCOUNT_TYPE',
                'label' => 'Giảm giá',
                'value' => call_user_func(function ($data) {
                    return ($data->DISCOUNT_TYPE == 1) ? $data->DISCOUNT_AMOUNT.' đ' : $data->DISCOUNT_EXTRA*100 .' %';
                }, $model),
            ],
            [
                'attribute' => 'DISCOUNT_MAX',
                'value' => call_user_func(function ($data) {
                    return ($data->DISCOUNT_MAX == 0) ? 'Không giới hạn' : $data->DISCOUNT_MAX ;
                }, $model),
            ],
//            'AFFILIATE_DISCOUNT_AMOUNT',
//            'AFFILIATE_DISCOUNT_EXTRA',
            //'ITEM_TYPE_ID_LIST',
            //'IS_ALL_ITEM',

            [
                'attribute' => 'CAMPAIGN_TYPE',
                'value' => call_user_func(function ($data) {
                    if(isset(Yii::$app->params['campainType'][$data->CAMPAIGN_TYPE])){
                        return @Yii::$app->params['campainType'][$data->CAMPAIGN_TYPE];
                    }else{
                        return $data->CAMPAIGN_TYPE;
                    }

                }, $model),
            ],
            [
                'attribute' => 'IS_ALL_ITEM',
                'label' => 'Món áp dụng / Món được tặng',
                'value' => call_user_func(function ($data) {
                    return ($data->IS_ALL_ITEM == 1) ? 'Tất cả các món' : $data->ITEM_ID_LIST;
                }, $model),
            ],
            'APPLY_ITEM_ID',
            'ITEM_TYPE_ID_LIST',
            'APPLY_ITEM_TYPE',
            'NUMBER_ITEM_BUY',
            'NUMBER_ITEM_FREE',
            'SAME_PRICE',
            'LIMIT_DISCOUNT_ITEM',
            [
                'attribute' => 'DISCOUNT_ONE_ITEM',
                'value' => call_user_func(function ($data) {
                    $discountOneItemValue  = [0 => 'Không', 1 => 'Giảm giá cho món giá cao nhất', 2 => 'Giảm giá cho món thấp nhất'];
                    return $discountOneItemValue[$data->DISCOUNT_ONE_ITEM];
                }, $model),
            ],
            'MIN_QUANTITY_DISCOUNT',
            'AMOUNT_ORDER_OVER',
            'DURATION',
            [
                'attribute' => 'REQUIED_MEMBER',
                'value' => call_user_func(function ($data) {
                    return ($data->REQUIED_MEMBER == 1) ? 'Có' : 'Không';
                }, $model),
            ],
            'SMS_CONTENT',

//            'LUCKY_NUMBER',
//            'IS_OTS',
        ],
    ]) ?>

</div>
