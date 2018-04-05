<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmposparent */

$this->title = 'Create Dmposparent';
$this->params['breadcrumbs'][] = ['label' => 'Dmposparents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmposparent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'partnerMap' => $partnerMap,
        'partnerIdMap' => $partnerIdMap,
        'configSMSMap' => $configSMSMap,
    ]) ?>

</div>
