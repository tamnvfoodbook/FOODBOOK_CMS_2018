<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Wmslideimagelist */

$this->title = 'Update Wmslideimagelist: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách slide', 'url' => ['index','id' => $model->POS_ID]];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wmslideimagelist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
