<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Orderonlinelog */
/* @var $itemsMap backend\controllers\OrderonlinelogController */

$this->title = 'Cập nhật đơn hàng: ' . ' ' . $model->user_phone;
$this->params['breadcrumbs'][] = ['label' => 'Orderonlinelogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_phone, 'url' => ['view', 'id' => (string)$model->_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="orderonlinelog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update', [
        'model' => $model,
        'pos' => $pos,
        'itemsMap' => $itemsMap,
        'allPosMap' => $allPosMap,
        'allPosToCheckDistanceMap' => $allPosToCheckDistanceMap,
        'itemList' => $itemList,
        //'arrayLocation' => $arrayLocation,
    ]) ?>

</div>
