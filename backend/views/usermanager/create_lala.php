<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Tạo quản lý';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form_lala', [
        'model' => $model,
        'posParentSession' => $posParentSession,
        'posMap' => $posMap ,
        'dmPosParent' => $dmPosParent,
        'type' => $type,
        'checkCreat' => 1,
    ]) ?>

</div>
