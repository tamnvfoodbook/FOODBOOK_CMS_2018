<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmtagrelate */

$this->title = $model->TAG_ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmtagrelates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmtagrelate-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'TAG_ID' => $model->TAG_ID, 'POS_ID' => $model->POS_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'TAG_ID' => $model->TAG_ID, 'POS_ID' => $model->POS_ID], [
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
            'TAG_ID',
            'POS_ID',
            'PIORITY',
        ],
    ]) ?>

</div>
