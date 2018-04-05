<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmitem */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Nhà hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmitem-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID' => $model->ID, 'POS_ID' => $model->POS_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID' => $model->ID, 'POS_ID' => $model->POS_ID], [
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
            'ITEM_ID',
            'ITEM_TYPE_ID',
            'ITEM_NAME',
            'ITEM_MASTER_ID',
            'ITEM_TYPE_MASTER_ID',
            'ITEM_IMAGE_PATH_THUMB',
            'ITEM_IMAGE_PATH',
            'DESCRIPTION:ntext',
            'OTS_PRICE',
            'TA_PRICE',
            'POINT',
            'IS_GIFT',
            'SHOW_ON_WEB',
            'SHOW_PRICE_ON_WEB',
            'ACTIVE',
            'SPECIAL_TYPE',
            'LAST_UPDATED',
            'FB_IMAGE_PATH',
            'FB_IMAGE_PATH_THUMB',
            'ALLOW_TAKE_AWAY',
            'IS_EAT_WITH',
            'REQUIRE_EAT_WITH',
            'ITEM_ID_EAT_WITH',
            'IS_FEATURED',
        ],
    ]) ?>

</div>
