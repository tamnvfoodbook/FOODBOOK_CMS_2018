<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmdistrict */
/* @var $allCityMap backend\models\Dmdistrict */

$this->title = 'Update Dmdistrict: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmdistricts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmdistrict-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allCityMap' => $allCityMap,
    ]) ?>

</div>
