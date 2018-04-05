<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmposmaster */

$this->title = 'Create Dmposmaster';
$this->params['breadcrumbs'][] = ['label' => 'Dmposmasters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmposmaster-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'cityMap' => $cityMap,
    ]) ?>

</div>
