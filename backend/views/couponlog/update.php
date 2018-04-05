<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\COUPONLOG */

$this->title = 'Update Couponlog: ' . ' ' . $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Couponlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->_id, 'url' => ['view', 'id' => (string)$model->_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="couponlog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'posNameMap' => $posNameMap,
        'posNameUserMap' => $posNameUserMap,
        'couponList' => $couponList,
        'posParentMap' => $posParentMap,
        'managerMap' => $managerMap,
    ]) ?>

</div>
