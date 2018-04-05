<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pmemployee */

$this->title = 'Sửa thông tin: ' . ' ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Nhân viên', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Sửa';
?>
<div class="pmemployee-update">
    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
        'permitArray' => $permitArray,
        'autogenId' => $autogenId,
    ]) ?>

</div>
