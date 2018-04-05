<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmtagrelate */

$this->title = 'Create Dmtagrelate';
$this->params['breadcrumbs'][] = ['label' => 'Dmtagrelates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmtagrelate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
