<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmshipfee */

$this->title = 'Tạo ship Fee';
$this->params['breadcrumbs'][] = ['label' => 'Dmshipfees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmshipfee-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
    ]) ?>

</div>
