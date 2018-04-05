<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Orderonlinelog */

$this->title = 'Tạo đơn hàng';
$this->params['breadcrumbs'][] = ['label' => 'Đơn hàng online', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orderonlinelog-create">
    <?= $this->render('_form_creat', [
        'model' => $model,
        'phoneNumber' => $phoneNumber,
        'nameMember' => $nameMember,
        'allPosMap' => $allPosMap,
        'lastOrder' => $lastOrder,
        'allPosToCheckDistanceMap' => $allPosToCheckDistanceMap
    ]) ?>

</div>
