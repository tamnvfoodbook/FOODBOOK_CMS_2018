<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Mgsalemanager */

$this->title = 'Create Mgsalemanager';
$this->params['breadcrumbs'][] = ['label' => 'Mgsalemanagers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mgsalemanager-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
