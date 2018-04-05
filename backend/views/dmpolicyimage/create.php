<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmpolicyimage */
/* @var $cityMap backend\controllers\DmcityController */

$this->title = 'Create Dmpolicyimage';
$this->params['breadcrumbs'][] = ['label' => 'Ảnh sticker', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmpolicyimage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'cityMap' => $cityMap,
        'posparentMap' => $posparentMap,
    ]) ?>

</div>
