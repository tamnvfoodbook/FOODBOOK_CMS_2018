<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmzalopageconfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmzalopageconfigs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmzalopageconfig-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dmzalopageconfig', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'PAGE_ID',
            'POS_PARENT',
            'ZALO_OA_KEY',
            'URL_POINT_POLICY:url',
            'URL_PROMOTION:url',
            // 'MESSAGE_ERROR',
            // 'MESSAGE_TITLE_CHECKIN',
            // 'MESSAGE_CHECKIN',
            // 'MESSAGE_MEMBER_POINT',
            // 'MESSAGE_MEMBER_NO_POINT',
            // 'MESSAGE_NO_GIFT_POINT',
            // 'MESSAGE_GET_MENU',
            // 'MESSAGE_TOKEN_ORDER',
            // 'MESSAGE_TITLE_ORDER_ONLINE',
            // 'MESSAGE_ORDER_ONLINE',
            // 'MESSAGE_TITLE_BOOKING',
            // 'MESSAGE_BOOKING_ONLINE',
            // 'MESSAGE_TITLE_RATE',
            // 'MESSAGE_REQUIED_RATE',
            // 'MESSAGE_TITLE_REQUIED_REGISTER',
            // 'MESSAGE_REQUIED_REGISTER',
            // 'MESSAGE_REGISTER_SUCCESS',
            // 'MESSAGE_NO_DAILY_VOUCHER',
            // 'MESSAGE_MISS_DAILY_VOUCHER',
            // 'MESSAGE_SENT_DAILY_VOUCHER',
            // 'MESSAGE_LIMIT_DAILY_VOUCHER',
            // 'MESSAGE_TITLE_LIST_POS',
            // 'MESSAGE_LIST_POS',
            // 'MESSAGE_TITLE_MEMBERSHIP_INFO',
            // 'MESSAGE_TITLE_PROMOTION',
            // 'MESSAGE_VIEW_ALL_ARTICLES',
            // 'MESSAGE_SHOW_PROMOTION',
            // 'MESSAGE_TITLE_GET_MENU',
            // 'CREATED_AT',
            // 'UPDATED_AT',
            // 'JSON_FUNCTION:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
