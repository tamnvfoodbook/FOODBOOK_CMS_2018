<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Bookingonlinelog */

$this->title = 'Create Bookingonlinelog';
$this->params['breadcrumbs'][] = ['label' => 'Bookingonlinelogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bookingonlinelog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
