<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Mgsalemanager */

$this->title = $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Mgsalemanagers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mgsalemanager-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => (string)$model->_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => (string)$model->_id], [
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
            '_id',
            'pos_name',
            'pos_type',
            'channels',
            'pos_parent',
            'pos_id',
            'tran_id',
            'tran_date',
            'created_at',
            'discount_extra',
            'discount_extra_amount',
            'service_charge',
            'service_charge_amount',
            'coupon_amount',
            'coupon_code',
            'ship_fee_amount',
            'discount_amount_on_item',
            'original_amount',
            'vat_amount',
            'bill_amount',
            'total_amount',
            'membership_name',
            'membership_id',
            'sale_note',
            'tran_no',
            'sale_type',
            'hour',
            'pos_city',
            'pos_district',
        ],
    ]) ?>

</div>
