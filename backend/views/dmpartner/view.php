<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmpartner */

$this->title = $model->PARTNER_NAME;
$this->params['breadcrumbs'][] = ['label' => 'Đối tác', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmpartner-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Sửa', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Xóa', ['delete', 'id' => $model->ID], [
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
            'PARTNER_NAME',
            'DESCRIPTION:ntext',
            'AVATAR_IMAGE',
            'ACTIVE',
        ],
    ]) ?>

</div>
