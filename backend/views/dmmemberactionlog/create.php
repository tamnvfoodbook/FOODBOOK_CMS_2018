<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmmemberactionlog */

$this->title = 'Create Dmmemberactionlog';
$this->params['breadcrumbs'][] = ['label' => 'Dmmemberactionlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmmemberactionlog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
