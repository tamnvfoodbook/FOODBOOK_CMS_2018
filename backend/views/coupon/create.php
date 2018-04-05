<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\COUPON */

$this->title = 'Create Coupon';
$this->params['breadcrumbs'][] = ['label' => 'Coupons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'posIdList' => $posIdList,
    ]) ?>

</div>
