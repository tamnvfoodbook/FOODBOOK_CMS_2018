<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmshipfee */

$this->title = 'Update Dmshipfee: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmshipfees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmshipfee-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update', [
        'model' => $model,
        'allPosMap' => $allPosMap,
        'fee' =>$fee
    ]) ?>

</div>
