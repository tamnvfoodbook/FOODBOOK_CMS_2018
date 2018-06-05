<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Mgpartnercustomfield */

$this->title = 'Update Mgpartnercustomfield: ' . ' ' . $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Mgpartnercustomfields', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->_id, 'url' => ['view', 'id' => (string)$model->_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mgpartnercustomfield-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'partnerMap' => $partnerMap,
        'allPosMap' => $allPosMap,
    ]) ?>

</div>
