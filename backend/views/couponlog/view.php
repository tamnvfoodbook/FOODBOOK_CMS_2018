<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\COUPONLOG */

$this->title = $model->Coupon_Name;
$this->params['breadcrumbs'][] = ['label' => 'Couponlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="couponlog-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!--Html::a('Update', ['update', 'id' => (string)$model->_id], ['class' => 'btn btn-primary'])-->
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
            //'_id',
            //'className',
            [
                'attribute' => 'Pos_Id',
                'value' => $model->pos->POS_NAME,
            ],
            //'Pos_Parent',
            'User_Id',
            [
                'attribute' => 'Coupon_Id',
                'value' => $model->coupon->Coupon_Name,
            ],

            'User_Id_Parent',
            'Coupon_Name',
            'Coupon_Log_Date',
            'Coupon_Log_Start',
            'Coupon_Log_End',
            'Denominations',
            //'Share_Quantity',
            'Type',
            'Active',
            //'Pr_Key',
        ],
    ]) ?>

</div>
