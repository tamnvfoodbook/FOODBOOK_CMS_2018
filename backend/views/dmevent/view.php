<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmevent */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmevents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmevent-view">

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
            'EVENT_NAME',
            'POS_PARENT',
            'DATE_CREATED',
            'DATE_UPDATED',
            'DATE_START',
            'ACTIVE',
            'MANAGER_ID',
            'MIN_EAT_COUNT',
            'MAX_EAT_COUNT',
            'MIN_PAY_AMOUNT',
            'MAX_PAY_AMOUNT',
            'LAST_VISIT_FREQUENCY',
            'CAMPAIGN_ID',
            'STATUS',
            'EXPECTED_APPROACH',
            'PRACTICAL_APPROACH',
        ],
    ]) ?>

</div>
