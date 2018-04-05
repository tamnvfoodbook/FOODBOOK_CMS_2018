<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Tạo tài khoản';
$this->params['breadcrumbs'][] = ['label' => 'Tài khoản', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'posParentSession' => $posParentSession,
        'allPosMap' => $allPosMap,
        'dmPosParent' => $dmPosParent,
        'type' => $type,
        'checkCreat' => 1,
    ]) ?>

</div>
