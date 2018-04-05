<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmuserpartner */

$this->title = 'Sửa tài khoản đối tác: ' . ' ' . $model->PARTNER_NAME;
$this->params['breadcrumbs'][] = ['label' => 'Tài khoản đối tác', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PARTNER_NAME, 'url' => ['view', 'id' => $model->PARTNER_NAME]];
$this->params['breadcrumbs'][] = 'Sửa';
?>
<div class="dmuserpartner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'posParentMap' => $posParentMap,
    ]) ?>

</div>
