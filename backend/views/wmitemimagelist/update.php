<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Wmitemimagelist */

$this->title = 'Sửa ảnh: ' . ' ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Nhà hàng', 'url' => ['dmpositem/index']];
$this->params['breadcrumbs'][] = ['label' => 'Danh sách ảnh', 'url' => ['index','id' => $model->POS_ID]];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wmitemimagelist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
