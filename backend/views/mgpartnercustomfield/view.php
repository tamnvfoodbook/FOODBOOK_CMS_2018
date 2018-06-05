<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Mgpartnercustomfield */

$this->title = $model->partner_name. ' - '.$model->pos_name;
$this->params['breadcrumbs'][] = ['label' => 'Mgpartnercustomfields', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mgpartnercustomfield-view">

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
//            '_id',
            'partner_id',
            'partner_name',
            'pos_id',
            'pos_name',
            'pos_parent',
            'tags',
//            'time_delivery',
            'image_url',
            'image_thumb_url',
            'active',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
