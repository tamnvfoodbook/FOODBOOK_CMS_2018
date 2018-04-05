<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposimagelist */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmposimagelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmposimagelist-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
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
            'DESCRIPTION',
            'IMAGE_PATH',
            'ACTIVE',
            'SORT',
        ],
    ]) ?>

</div>
