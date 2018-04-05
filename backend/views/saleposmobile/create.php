<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Saleposmobile */

$this->title = 'Create Saleposmobile';
$this->params['breadcrumbs'][] = ['label' => 'Saleposmobiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saleposmobile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
