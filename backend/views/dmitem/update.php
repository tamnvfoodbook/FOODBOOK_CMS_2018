<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmitem */

$this->title = 'Update Dmitem: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmitems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID, 'POS_ID' => $model->POS_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmitem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
