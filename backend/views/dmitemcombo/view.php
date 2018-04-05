<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmitemcombo */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmitemcombos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmitemcombo-view">

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
            'ITEM_ID',
            'COMBO_ITEM_ID_LIST',
            'QUANTITY',
            'TA_PRICE',
            'OTS_PRICE',
            'TA_DISCOUNT',
            'OTS_DISCOUNT',
            'SORT',
            'CREATED_AT',
        ],
    ]) ?>

</div>
