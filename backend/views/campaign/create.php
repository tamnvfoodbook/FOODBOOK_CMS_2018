<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CAMPAIGN */

$this->title = 'Create Campaign';
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-create">
    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'posNameMap' => $posNameMap,
        'itemMap' => $itemMap,
        'couponList' => $couponList,
    ]) ?>

</div>
