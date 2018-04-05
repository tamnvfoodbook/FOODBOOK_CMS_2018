<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Callcenterlog */

$this->title = 'Create Callcenterlog';
$this->params['breadcrumbs'][] = ['label' => 'Callcenterlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="callcenterlog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
