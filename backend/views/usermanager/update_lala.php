<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Sửa: ' . ' ' . $model->USERNAME;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->USERNAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Sửa';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_lala', [
        'model' => $model,
        'user' => $user,
        'posMap' => $posMap,
        'dmPosParent' => $dmPosParent,
        'posParentSession' => $posParentSession,
        'type' => $type,
    ]) ?>

</div>
