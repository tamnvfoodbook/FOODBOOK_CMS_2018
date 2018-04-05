<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmmembershiptyperelate */

$this->title = 'Create Dmmembershiptyperelate';
$this->params['breadcrumbs'][] = ['label' => 'Dmmembershiptyperelates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmmembershiptyperelate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
