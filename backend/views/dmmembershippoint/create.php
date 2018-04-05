<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmmembershippoint */

$this->title = 'Create Dmmembershippoint';
$this->params['breadcrumbs'][] = ['label' => 'Dmmembershippoints', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmmembershippoint-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
