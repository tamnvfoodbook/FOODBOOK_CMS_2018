<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmpolicyimage */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmpolicyimages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmpolicyimage-view">

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
            'IMAGE_LINK',
            'DESCRIPTION',
            'DESCRIPTION_URL:url',
            'SORT',
            'DATE_CREATED',
            'DATE_START',
            'DATE_END',
            'LIST_POS_PARENT',
            'ACTIVE',
        ],
    ]) ?>

</div>
