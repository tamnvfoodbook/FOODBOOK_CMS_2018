<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmpos */

$this->title = 'Tạo nhà hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmpos-create">

    <?= $this->render('_form_pos', [
        'model' => $model,
        'allCurrencyMap' => $allCurrencyMap,
        'cityMap' => $cityMap,
        'country_codes' => $country_codes,
    ]) ?>
</div>
