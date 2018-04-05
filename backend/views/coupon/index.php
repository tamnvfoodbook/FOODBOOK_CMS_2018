<?php

use yii\helpers\Html;
use yii\grid\GridViewCoupon;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CouponSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Coupons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Coupon', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridViewCoupon::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'_id',
            //'className',
            //'Pos_Id',
            'Coupon_Name',
            'Coupon_Log_Date',
            'Denominations',
            'Active',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}'
            ],
        ],
    ]); ?>

</div>
