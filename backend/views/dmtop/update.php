<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DmPosStats */

$this->title = 'Update Dm Pos Stats: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dm Pos Stats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dm-pos-stats-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
