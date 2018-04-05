<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmvoucherlog */

$this->title = $model->VOUCHER_CODE;
$this->params['breadcrumbs'][] = ['label' => 'Dmvoucherlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmvoucherlog-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'VOUCHER_CODE',
//            'VOUCHER_CAMPAIGN_ID',
            'VOUCHER_CAMPAIGN_NAME',
            'VOUCHER_DESCRIPTION:ntext',
//            'POS_PARENT',
//            'POS_ID',
//            'DATE_CREATED',
            [                      // the owner name of the model
                'label' => 'Ngày tạo',
                'value' => date(Yii::$app->params['DATE_TIME_FORMAT_2'],strtotime($model->DATE_CREATED)),
            ],
            [                      // the owner name of the model
                'label' => 'Ngày phát hành',
                'value' => date(Yii::$app->params['DATE_TIME_FORMAT_2'],strtotime($model->DATE_START)),
            ],
            [                      // the owner name of the model
                'label' => 'Ngày kết thúc',
                'value' => date(Yii::$app->params['DATE_TIME_FORMAT_2'],strtotime($model->DATE_END)),
            ],
            'BUYER_INFO',
//            'DATE_START',
//            'DATE_END',
//            'DATE_HASH',
//            'AMOUNT_ORDER_OVER',
//            'DISCOUNT_TYPE',
           /* [                      // the owner name of the model
                'attribute' => 'DISCOUNT_TYPE',
                'value' => ($model->DISCOUNT_TYPE == 1) ? number_format($model->AFFILIATE_DISCOUNT_AMOUNT) : $model->DISCOUNT_EXTRA*100
            ],*/
//            'DISCOUNT_AMOUNT',
//            'DISCOUNT_EXTRA',
//            'IS_ALL_ITEM',
//            'ITEM_TYPE_ID_LIST',
//            'STATUS',
            [                      // the owner name of the model
                'attribute' => 'STATUS',
                'value' => Yii::$app->params['VOUCHER_LOG_STATUS'][$model->STATUS]
            ],
//            'BUYER_INFO',
//            'AFFILIATE_ID',
//            'AFFILIATE_DISCOUNT_TYPE',
//            'AFFILIATE_DISCOUNT_AMOUNT',
//            'AFFILIATE_DISCOUNT_EXTRA',
//            'AFFILIATE_USED_TOTAL_AMOUNT',
//            'USED_DATE',
            [                      // the owner name of the model
                'label' => 'Ngày sử dụng',
                'value' => ($model->STATUS == 2) ? date(Yii::$app->params['DATE_TIME_FORMAT_2'],strtotime($model->USED_DATE)) : null,
            ],
            [                      // the owner name of the model
                'attribute' => 'USED_DISCOUNT_AMOUNT',
                'value' => number_format($model->USED_DISCOUNT_AMOUNT),
            ],
            [                      // the owner name of the model
                'attribute' => 'USED_BILL_AMOUNT',
                'value' => number_format($model->USED_BILL_AMOUNT),
            ],
            'USED_MEMBER_INFO',
            'USED_POS_ID',
//            [                      // the owner name of the model
//                'label' => 'Ngày sử dụng',
//                'value' => $allPosMap[$model->USED_POS_ID],
//            ],
            'USED_SALE_TRAN_ID',
        ],
    ]) ?>

</div>
