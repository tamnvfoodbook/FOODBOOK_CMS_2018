<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CAMPAIGN */

$this->title = 'Tạo loại voucher mới';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách e - voucher', 'url' => ['evoucher']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-create">
    <h2><?= Html::encode($this->title) ?></h2>
    <?php
        if(isset($allPosMap)){
            echo $this->render('_form_evoucher',[
                'model' => $model,
                'allPosMap' => $allPosMap,
                'itemMap' => $itemMap,
                'iteTypemMap' => $iteTypemMap,
                'partnerMap' => $partnerMap,
            ]);
        }else{
            echo $this->render('_form_evoucher_follow',[
                'model' => $model,
                'campaginsMap' => $campaginsMap,
                'paramData' => $paramData,
                'partnerMap' => $partnerMap,
            ]);
        }
    ?>
</div>
