<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposmasterrelate */

$this->title = 'Update Dmposmasterrelate: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmposmasterrelates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmposmasterrelate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
        'allPosmasterMap' => $allPosmasterMap,
    ]) ?>

</div>
