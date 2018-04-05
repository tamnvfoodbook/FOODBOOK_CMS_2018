<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposmaster */
/* @var $cityMap backend\models\Dmposmaster */

$this->title = 'Update Dmposmaster: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmposmasters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmposmaster-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'cityMap' => $cityMap,
    ]) ?>

</div>
