<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Memberaddresslist */

$this->title = 'Create Memberaddresslist';
$this->params['breadcrumbs'][] = ['label' => 'Memberaddresslists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberaddresslist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
