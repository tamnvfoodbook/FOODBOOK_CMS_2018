<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmfacebookpageconfig */

$this->title = 'Update Dmfacebookpageconfig: ' . ' ' . $model->PAGE_ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmfacebookpageconfigs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PAGE_ID, 'url' => ['view', 'id' => $model->PAGE_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmfacebookpageconfig-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
