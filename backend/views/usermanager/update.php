<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Sửa tài khoản: ' . ' ' . $model->USERNAME;
$this->params['breadcrumbs'][] = ['label' => 'Tài khoản', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Sửa';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'user' => $user,
        //'posSelected' => $posSelected,
        'allPosMap' => $allPosMap,
        'dmPosParent' => $dmPosParent,
        'posParentSession' => $posParentSession,
        'type' => $type,
    ]) ?>

</div>
