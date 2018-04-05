<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmzalopageconfig */

$this->title = $model->PAGE_ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmzalopageconfigs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmzalopageconfig-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->PAGE_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->PAGE_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'PAGE_ID',
            'POS_PARENT',
            'ZALO_OA_KEY',
            'URL_POINT_POLICY:url',
            'URL_PROMOTION:url',
            'MESSAGE_ERROR',
            'MESSAGE_TITLE_CHECKIN',
            'MESSAGE_CHECKIN',
            'MESSAGE_MEMBER_POINT',
            'MESSAGE_MEMBER_NO_POINT',
            'MESSAGE_NO_GIFT_POINT',
            'MESSAGE_GET_MENU',
            'MESSAGE_TOKEN_ORDER',
            'MESSAGE_TITLE_ORDER_ONLINE',
            'MESSAGE_ORDER_ONLINE',
            'MESSAGE_TITLE_BOOKING',
            'MESSAGE_BOOKING_ONLINE',
            'MESSAGE_TITLE_RATE',
            'MESSAGE_REQUIED_RATE',
            'MESSAGE_TITLE_REQUIED_REGISTER',
            'MESSAGE_REQUIED_REGISTER',
            'MESSAGE_REGISTER_SUCCESS',
            'MESSAGE_NO_DAILY_VOUCHER',
            'MESSAGE_MISS_DAILY_VOUCHER',
            'MESSAGE_SENT_DAILY_VOUCHER',
            'MESSAGE_LIMIT_DAILY_VOUCHER',
            'MESSAGE_TITLE_LIST_POS',
            'MESSAGE_LIST_POS',
            'MESSAGE_TITLE_MEMBERSHIP_INFO',
            'MESSAGE_TITLE_PROMOTION',
            'MESSAGE_VIEW_ALL_ARTICLES',
            'MESSAGE_SHOW_PROMOTION',
            'MESSAGE_TITLE_GET_MENU',
            'CREATED_AT',
            'UPDATED_AT',
            'JSON_FUNCTION:ntext',
        ],
    ]) ?>

</div>
