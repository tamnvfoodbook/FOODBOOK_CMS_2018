<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmfacebookpageconfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmfacebookpageconfigs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmfacebookpageconfig-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dmfacebookpageconfig', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'PAGE_ID',
            'POS_PARENT',
            'PAGE_ACCESS_TOKEN',
            'URL_POINT_POLICY:url',
            'URL_PROMOTION:url',
            // 'CREATED_AT',
            // 'UPDATED_AT',
            // 'PERSISTENT_MENU:ntext',
            // 'MESSAGE_GREETING',
            // 'MESSAGE_ERROR',
            // 'MESSAGE_CHECKIN',
            // 'MESSAGE_MEMBER_POINT',
            // 'MESSAGE_MEMBER_NO_POINT',
            // 'MESSAGE_NO_GIFT_POINT',
            // 'MESSAGE_GET_MENU',
            // 'MESSAGE_TOKEN_ORDER',
            // 'MESSAGE_ORDER_ONLINE',
            // 'MESSAGE_BOOKING_ONLINE',
            // 'MESSAGE_REQUIED_RATE',
            // 'MESSAGE_REQUIED_REGISTER',
            // 'MESSAGE_REGISTER_SUCCESS',
            // 'MESSAGE_NO_DAILY_VOUCHER',
            // 'MESSAGE_MISS_DAILY_VOUCHER',
            // 'MESSAGE_SENT_DAILY_VOUCHER',
            // 'MESSAGE_LIMIT_DAILY_VOUCHER',
            // 'SUB_TITLE_HOTLINE',
            // 'SUB_TITLE_PROMOTION',
            // 'SUB_TITLE_POLICY_POINT',
            // 'MESSAGE_GET_POS',
            // 'AUTO_REPLY_MENU:ntext',
            // 'STATUS_BOTCHAT',
            // 'JSON_FUNCTION:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
