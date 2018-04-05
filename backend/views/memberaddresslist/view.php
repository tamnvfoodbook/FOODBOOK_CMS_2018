<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberaddresslist */

$this->title = $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Memberaddresslists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberaddresslist-view">

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
            'user_id',
            'alias_name',
            'extend_address',
            'full_address',
            'city_id',
            'district_id',
            'created_at',
            'longitude',
            'latitude',
        ],
    ]) ?>

</div>
