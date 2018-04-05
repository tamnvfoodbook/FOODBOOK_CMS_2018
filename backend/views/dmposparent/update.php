<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposparent */

$this->title = 'Update Dmposparent: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmposparents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmposparent-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'partnerMap' => $partnerMap,
        'partnerIdMap' => $partnerIdMap,
        'posModelMap' => $posModelMap,
        'configSMSMap' => $configSMSMap,
    ]) ?>

</div>
