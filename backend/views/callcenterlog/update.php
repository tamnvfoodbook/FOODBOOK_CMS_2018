<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Callcenterlog */

$this->title = 'Update Callcenterlog: ' . ' ' . $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Callcenterlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->_id, 'url' => ['view', 'id' => (string)$model->_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="callcenterlog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
