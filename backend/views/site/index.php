<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use backend\assets\AppAsset;
AppAsset::register($this);

$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->title = 'Tổng quan';

//Yii::error('pushNotifications');

?>
<?= $this->render('_form_calendar', [
    'countIds' => $countIds,
]) ?>

<div class="box box-default" id="sale_by_time">
    <?= $this->render('_form_today', [
        'priceToday' => $priceToday,
        'orderToday' => $orderToday,
        'dataToday' => $dataToday,

        'TA_Count' => @$TA_Count,
        'OTS_Count' => @$OTS_Count,
        'comment' => $comment,

        'newMember' => $newMember,
        'oldMember' => $oldMember,
        'allMember' => $allMember,
        'Comment_In_Fb_Count' => @$Comment_In_Fb_Count,
        'Comment_In_Rate_Count' => @$Comment_In_Rate_Count,

        'totalRate' => $totalRate,
        'avg_rate' => $avg_rate,
        'oderRateSorted' => $oderRateSorted,
        //'Share_Facebook_Count' => $Share_Facebook_Count,
//        'shareFacebook' => $shareFacebook,
        'orderpriceDetail' => $orderpriceDetail,
        'posNameMap' => $posNameMap,
        //'rateArrayByStat' => $rateArrayByStat,
//        'facebookDetail' => $facebookDetail,
        'dateTextLabel' => $dateTextLabel,
        'date_start' => $date_start,
        'date_end' => $date_end,
    ]) ?>
</div><!-- /.box -->

<?= $this->render('_form_chart', [
    'arrayOrderOnline' => @$arrayOrderOnline,
    'allDay_test' => $allDay_test,
    'arrayOrderOffline' => @$arrayOrderOffline,
    'arrayRate' => @$arrayRate,
    'arrayShareFB' => @$arrayShareFB,
    'arrayWishlist' => @$arrayWishlist,
    'orderPie' => @$orderPie,
    'dataOnWeek' => $dataOnWeek,

]) ?>
