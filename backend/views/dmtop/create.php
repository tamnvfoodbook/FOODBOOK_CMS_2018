<?php

use yii\helpers\Html;
use datepick\src;


/* @var $this yii\web\View */
/* @var $model backend\models\DmPosStats */

$this->title = 'Create Dm Pos Stats';
$this->params['breadcrumbs'][] = ['label' => 'Dm Pos Stats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-pos-stats-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
