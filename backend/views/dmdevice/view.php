<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmdevice */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmdevices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmdevice-view">

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
            'DEVICE_ID',
            'DEVICE_TYPE',
            'PUSH_ID',
            'MSISDN',
            'LAST_UPDATED',
            'ACTIVE',
            'VERSION',
            'CREATED_AT',
            'MODEL',
            'LANGUAGE',
        ],
    ]) ?>

</div>
