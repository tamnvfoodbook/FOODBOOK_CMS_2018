<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmpartner */

$this->title = 'Sửa đối tác : ' . ' ' . $model->PARTNER_NAME;
$this->params['breadcrumbs'][] = ['label' => 'Dmpartners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PARTNER_NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Sửa';
?>
<div class="dmpartner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
