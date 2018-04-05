<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CAMPAIGN */

$this->title = 'Update Campaign: ' . ' ' . $model->Campaign_Name;
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Campaign_Name, 'url' => ['view', 'id' => (string)$model->Campaign_Name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="campaign-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'posNameMap' => $posNameMap,
        'itemMap' => $itemMap,
        'couponList' => $couponList,
    ]) ?>

</div>
