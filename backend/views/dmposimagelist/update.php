<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposimagelist */
/* @var $allPosMap backend\controllers\DmposimagelistController */

$this->title = 'Update Dmposimagelist: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmposimagelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmposimagelist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
    ]) ?>

</div>
