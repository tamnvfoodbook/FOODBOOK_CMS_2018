<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmmembershippoint */

$this->title = $model->MEMBERSHIP_ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmmembershippoints', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmmembershippoint-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'MEMBERSHIP_ID' => $model->MEMBERSHIP_ID, 'POS_PARENT' => $model->POS_PARENT], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'MEMBERSHIP_ID' => $model->MEMBERSHIP_ID, 'POS_PARENT' => $model->POS_PARENT], [
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
            'MEMBERSHIP_ID',
            'POS_PARENT',
            'AMOUNT',
            'POINT',
            'EAT_FIRST_DATE',
            'EAT_LAST_DATE',
            'EAT_COUNT',
            'EAT_COUNT_FAIL',
        ],
    ]) ?>

</div>
