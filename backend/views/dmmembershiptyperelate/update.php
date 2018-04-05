<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmmembershiptyperelate */

$this->title = 'Update Dmmembershiptyperelate: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmmembershiptyperelates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmmembershiptyperelate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
