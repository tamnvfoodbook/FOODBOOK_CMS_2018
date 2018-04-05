<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmposimagelist */

$this->title = 'Create Dmposimagelist';
$this->params['breadcrumbs'][] = ['label' => 'Dmposimagelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmposimagelist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
    ]) ?>

</div>
