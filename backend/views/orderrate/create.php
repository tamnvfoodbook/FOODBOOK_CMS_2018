<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Orderrate */

$this->title = 'Create Orderrate';
$this->params['breadcrumbs'][] = ['label' => 'Orderrates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orderrate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
