<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Mgitemchanged */

$this->title = $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Mgitemchangeds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mgitemchanged-view">

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
            'pos_parent',
            'pos_id',
            'last_changed',
            'reversion',
            'changed',
            'last_broadcast',
        ],
    ]) ?>

</div>
