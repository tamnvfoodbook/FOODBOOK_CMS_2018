<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmtagrelate */

$this->title = 'Update Dmtagrelate: ' . ' ' . $model->TAG_ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmtagrelates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TAG_ID, 'url' => ['view', 'TAG_ID' => $model->TAG_ID, 'POS_ID' => $model->POS_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmtagrelate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
