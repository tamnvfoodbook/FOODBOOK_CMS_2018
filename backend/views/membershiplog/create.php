<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Membershiplog */

$this->title = 'Create Membershiplog';
$this->params['breadcrumbs'][] = ['label' => 'Membershiplogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="membershiplog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
