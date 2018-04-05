<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmmemberactionlog */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmmemberactionlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmmemberactionlog-view">

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
            'CREATED_AT',
            'USER_ID',
            'SPIN_RESULT',
            'DESCRIPTION',
            'POS_PARENT',
            'LOG_TYPE',
            'AMOUNT',
            'VOUCHER_LOG',
            'PAYMENT_METHOD',
            'RECEIVER_PHONE',
            'BANK_ACCOUNT',
            'UPDATED_AT',
            'WITHDRAW_STATE',
        ],
    ]) ?>

</div>
