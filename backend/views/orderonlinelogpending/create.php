<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Orderonlinelogpending */

$this->title = 'Create Orderonlinelogpending';
$this->params['breadcrumbs'][] = ['label' => 'Orderonlinelogpendings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orderonlinelogpending-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
