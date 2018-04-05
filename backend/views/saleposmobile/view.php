<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Saleposmobile */

$this->title = $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Saleposmobiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saleposmobile-view">

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
            'pos_id',
            'pr_key',
            'status',
            'ticket_name',
            'user_id',
            'time_update',
            'date_time',
            'trans_type',
            'data_sale_detail',
        ],
    ]) ?>

</div>
