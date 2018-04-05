<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Orderonlinelog */

$this->title = 'Xử lý đơn hàng: ' . ' ' . $model->user_phone;
$this->params['breadcrumbs'][] = ['label' => 'Orderonlinelogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_phone, 'url' => ['view', 'id' => (string)$model->_id]];
$this->params['breadcrumbs'][] = 'Pick địa chỉ';
?>
<div class="orderonlinelog-update">
    <?= $this->render('_form_location', [
        'model' => $model,
        'pos' => $pos,
//        'firstLat' => $firstLat,
//        'firstLong' => $firstLong,
        'arrayLocation' => $arrayLocation,
    ]) ?>

</div>
