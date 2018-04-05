<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmevent */

$this->title = 'Tạo sự kiện CSKH';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách sự kiện', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmevent-create">
    <?= $this->render('_form', [
        'model' => $model,
        'campains' => $campains,
    ]) ?>

</div>
