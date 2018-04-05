<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmmembershiptype */

$this->title = 'Create Dmmembershiptype';
$this->params['breadcrumbs'][] = ['label' => 'Dmmembershiptypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmmembershiptype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
