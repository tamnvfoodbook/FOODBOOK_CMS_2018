<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmvouchercampaign */

$this->title = 'Sửa chiến dịch: ' . ' ' . $model->VOUCHER_NAME;
$this->params['breadcrumbs'][] = ['label' => 'Chiến dịch', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->VOUCHER_NAME]];
$this->params['breadcrumbs'][] = 'Sửa';
?>

<div class="dmvouchercampaign-update">
    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
        'allItemsMap' => $allItemsMap,
        'allItemTypeMap' => $allItemTypeMap
    ]) ?>

</div>
