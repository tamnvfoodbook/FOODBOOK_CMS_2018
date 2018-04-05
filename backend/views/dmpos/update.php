<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmpos */

$this->title = 'Sửa thông tin nhà hàng: ' . ' ' . $model->POS_NAME;
$this->params['breadcrumbs'][] = ['label' => 'Nhà hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->POS_NAME, 'url' => ['view', 'id' => $model->POS_NAME]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmpos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'posparents' => $posparents,
        'city' => $city,
        'district' => $district,
        'posmaster' => $posmaster,
        'country_codes' => $country_codes,
        'allDeliveryMap' => $allDeliveryMap,
    ]) ?>

</div>
