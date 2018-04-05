<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmtimeorder */

$this->title = 'Khai báo thời gian';
$this->params['breadcrumbs'][] = ['label' => 'Khai báo thời gian', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmtimeorder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
    ]) ?>

</div>
