<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmcity */

$this->title = 'Create Dmcity';
$this->params['breadcrumbs'][] = ['label' => 'Dmcities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmcity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
