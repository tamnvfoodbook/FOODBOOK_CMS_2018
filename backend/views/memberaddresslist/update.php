<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberaddresslist */

$this->title = 'Update Memberaddresslist: ' . ' ' . $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Memberaddresslists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->_id, 'url' => ['view', 'id' => (string)$model->_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="memberaddresslist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
