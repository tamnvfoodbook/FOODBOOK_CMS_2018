<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Saleposmobile */

$this->title = 'Update Saleposmobile: ' . ' ' . $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Saleposmobiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->_id, 'url' => ['view', 'id' => (string)$model->_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="saleposmobile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
