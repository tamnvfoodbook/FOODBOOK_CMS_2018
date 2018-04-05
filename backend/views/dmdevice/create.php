<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmdevice */

$this->title = 'Create Dmdevice';
$this->params['breadcrumbs'][] = ['label' => 'Dmdevices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmdevice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
