<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Orderrate */

$this->title = $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Orderrates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orderrate-view">

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
            'pos_parent',
            'dmShift',
            'member_id',
            'created_at',
            'score',
            'reson_bad_food',
            'reson_expensive_price',
            'reson_bad_service',
            'reson_bad_shipper',
            'reson_other',
            'reson_note',
            'published',
        ],
    ]) ?>

</div>
