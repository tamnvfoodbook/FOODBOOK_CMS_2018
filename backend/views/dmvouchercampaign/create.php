<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmvouchercampaign */
/* @var $timeHourDayArr backend\controllers\DmvouchercampaignController */
/* @var $allCityMap backend\controllers\DmvouchercampaignController */

$this->title = 'Tạo chiến dịch';
$this->params['breadcrumbs'][] = ['label' => 'Phiếu giảm giá', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmvouchercampaign-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allCityMap' => $allCityMap,
        'posParentMap' => $posParentMap,
        'timeHourDayArr' => $timeHourDayArr,
        'timeDayOfWeekArr' => $timeDayOfWeekArr,
    ]) ?>

</div>
