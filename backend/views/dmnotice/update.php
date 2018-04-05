<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmnotice */

$this->title = 'Sửa thông báo: ' . ' ' . $model->TITLE;
$this->params['breadcrumbs'][] = ['label' => 'Thông báo', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TITLE, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Sửa';
?>
<div class="dmnotice-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
    ]) ?>

</div>
