<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmpartner */

$this->title = 'Sửa commission' . ' ' . $model->pos_id;
$this->params['breadcrumbs'][] = ['label' => 'Commission', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pos_id, 'url' => ['view', 'id' => $model->_id]];
$this->params['breadcrumbs'][] = 'Sửa';
?>
<div class="dmpartner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_change_commission', [
        'model' => $model,
    ]) ?>

</div>
