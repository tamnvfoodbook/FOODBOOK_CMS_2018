<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmdistrict */
/* @var $allCityMap backend\models\Dmdistrict */

$this->title = 'Create Dmdistrict';
$this->params['breadcrumbs'][] = ['label' => 'Dmdistricts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmdistrict-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allCityMap' => $allCityMap,
    ]) ?>

</div>
