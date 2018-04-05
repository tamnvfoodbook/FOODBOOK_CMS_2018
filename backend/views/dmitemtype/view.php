<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmitemtype */

$this->title = $model->ITEM_TYPE_NAME;
$this->params['breadcrumbs'][] = ['label' => 'Nhóm món', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmitemtype-view">

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
            'ITEM_TYPE_ID',
            'ITEM_TYPE_NAME',
            'ACTIVE',
            'MIN_ITEM_CHOICE',
            'MAX_ITEM_CHOICE',
            'LAST_UPDATED',
        ],
    ]) ?>

</div>
