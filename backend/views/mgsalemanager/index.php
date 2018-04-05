<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MgsalemanagerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mgsalemanagers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mgsalemanager-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Mgsalemanager', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            '_id',
            'pos_name',
            'pos_type',
            'channels',
            'pos_parent',
            // 'pos_id',
            // 'tran_id',
            // 'tran_date',
            // 'created_at',
            // 'discount_extra',
            // 'discount_extra_amount',
            // 'service_charge',
            // 'service_charge_amount',
            // 'coupon_amount',
            // 'coupon_code',
            // 'ship_fee_amount',
            // 'discount_amount_on_item',
            // 'original_amount',
            // 'vat_amount',
            // 'bill_amount',
            // 'total_amount',
            // 'membership_name',
            // 'membership_id',
            // 'sale_note',
            // 'tran_no',
            // 'sale_type',
            // 'hour',
            // 'pos_city',
            // 'pos_district',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
