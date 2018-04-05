<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DmPosStats */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dm Pos Stats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-pos-stats-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
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
            'ID',
            'POS_ID',
            'POS_PARENT',
            'CREATED_AT',
            'SUM_USER_CHECKIN',
            'SUM_USER_ORDER_ONLINE',
            'SUM_PRICE_ONLINE',
            'SUM_USER_ORDER_OFF',
            'SUM_PRICE_OFF',
            'SUM_COUPON_USED',
            'SUM_COUPON_PRICE',
            'SUM_COUPON_AVAILABLE',
            'SUM_USER_SHARED_FB',
            'SUM_USER_WISHLIST',
        ],
    ]) ?>

</div>
