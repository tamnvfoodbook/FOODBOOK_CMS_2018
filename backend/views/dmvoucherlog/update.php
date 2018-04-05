<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmvoucherlog */

$this->title = 'Update Dmvoucherlog: ' . ' ' . $model->VOUCHER_CODE;
$this->params['breadcrumbs'][] = ['label' => 'Dmvoucherlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->VOUCHER_CODE, 'url' => ['view', 'id' => $model->VOUCHER_CODE]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmvoucherlog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
