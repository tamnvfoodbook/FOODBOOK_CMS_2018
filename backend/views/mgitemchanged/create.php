<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Mgitemchanged */

$this->title = 'Create Mgitemchanged';
$this->params['breadcrumbs'][] = ['label' => 'Mgitemchangeds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mgitemchanged-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
