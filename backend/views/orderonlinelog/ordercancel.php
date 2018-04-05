<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('js/jquery-1.11.3.min.js', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderonlinelogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orderonline Cancel logs';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="orderonlinelog-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= Html::a("Refresh", ['orderonlinelog/index'], ['class' => 'btn btn-lg btn-primary','id' => 'refreshButton']) ?>
    <?= GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'pos_is_call_center',
                'format' => 'raw',
                'value' => 'iscallcenter',
                'label' => 'Qua TĐ'
            ],
            [
                'attribute' => 'address',
                'format' => 'raw',
                'value' => 'checkAddress',
                'label' => 'Location'
            ],

            //'_id',
            'foodbook_code',
            //'username',
            'user_phone',
            //'coupon_log_id',
            //'pos_id',
            [
                'attribute' => 'pos_id',
                'value' => 'pos.POS_NAME',
                'label' => 'Nhà hàng'
            ],


            /*[
                'attribute' => 'pos_is_call_center',
                'value' => 'pos.IS_CALL_CENTER',
                'label' => 'Qua TĐ'
            ],*/

            //'isCallCenterConfirmed',
            'status',

            'to_address',
            //'distance',
            //'total_fee',

//            [
//                'attribute' => 'created_at',
//                'format' => 'raw',
//                'value' => 'changeTime',
//                'label' => 'Thời gian tạo'
//            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => 'changeUpdateTime',
                'label' => 'Thời cập nhật'
            ],

            //'order_data_item',
            // 'pos_workstation',
            //'user_id',

             //'duration',
             //'isFromFoodbook',

             //'address_id',


             //'ahamove_code',
             //'supplier_id',
             //'supplier_name',
            // 'shared_link',

            // 'note',
             //'payment_method',
             //'payment_info',
             //'isCallCenterConfirmWithPos',
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template'=>'{update} {delete} {toahamove} {confirmtopos}'
//
//            ],

            [
                'format' => 'raw',
                'value' => 'actions',
                'label' => 'Actions'
            ],
            [
                'format' => 'raw',
                'value' => 'suggest',
                'label' => 'Suggest'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}'

            ],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end(); ?>

</div>



<?php
/*$script = <<< JS
$(document).ready(function() {
    setInterval(function(){ $("#refreshButton").click(); }, 5000);
});
JS;
$this->registerJs($script);*/
?>
