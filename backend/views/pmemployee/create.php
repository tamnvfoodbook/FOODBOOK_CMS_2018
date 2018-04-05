<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pmemployee */

$this->title = 'Tạo nhân viên';
$this->params['breadcrumbs'][] = ['label' => 'Nhân viên', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pmemployee-create">

    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
        'permitArray' => $permitArray,
        'autogenId' => $autogenId,
    ]) ?>

</div>
