<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmmembershippoint */

$this->title = 'Sửa điểm thành viên: ' . ' ' . $model->MEMBERSHIP_ID;
$this->params['breadcrumbs'][] = ['label' => 'Điểm thành viên', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MEMBERSHIP_ID, 'url' => ['view', 'MEMBERSHIP_ID' => $model->MEMBERSHIP_ID, 'POS_PARENT' => $model->POS_PARENT]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmmembershippoint-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
