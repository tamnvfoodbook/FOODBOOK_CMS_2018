<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmtimeorder */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmtimeorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmtimeorder-view">

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
            'TYPE',
            'DAY_OF_WEEK',
            'TIME_START',
            'TIME_END',
            'DAY_OFF',
            'ACTIVE',
        ],
    ]) ?>

</div>
