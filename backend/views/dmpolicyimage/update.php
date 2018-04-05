<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmpolicyimage */

$this->title = 'Update Dmpolicyimage: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Ảnh sticker', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmpolicyimage-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'cityMap' => $cityMap,
        'posparentMap' => $posparentMap,
    ]) ?>

</div>
