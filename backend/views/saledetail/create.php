<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SALEDETAIL */

$this->title = 'Create Saledetail';
$this->params['breadcrumbs'][] = ['label' => 'Saledetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saledetail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
