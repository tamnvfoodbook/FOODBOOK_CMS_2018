<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmposmasterrelate */

$this->title = 'Create Dmposmasterrelate';
$this->params['breadcrumbs'][] = ['label' => 'Dmposmasterrelates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmposmasterrelate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
        'allPosmasterMap' => $allPosmasterMap,
    ]) ?>

</div>
