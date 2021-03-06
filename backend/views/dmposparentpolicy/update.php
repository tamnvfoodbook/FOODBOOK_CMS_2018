<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposparentpolicy */

$this->title = 'Sửa chính sách thương hiệu: ' . ' ' . $model->POS_PARENT;
$this->params['breadcrumbs'][] = ['label' => 'Chính sách thương hiệu', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmposparentpolicy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
