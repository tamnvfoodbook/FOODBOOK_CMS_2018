<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model backend\models\Orderonlinelog */

$this->title = 'đơn hàng '.$model->foodbook_code.' Lúc ('.date(Yii::$app->params['DATE_TIME_FORMAT'],strtotime($model->created_at)).')';
$this->params['breadcrumbs'][] = ['label' => 'Đơn hàng online', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<br>
<div class="orderonlinelog-view">
    <!-- Custom tabs (Charts with tabs)-->
    <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">
            <li class="active"><a href="#revenue-chart" data-toggle="tab">Tổng quan</a></li>
            <li><a href="#sales-chart" data-toggle="tab">Thời gian</a></li>
            <li><a href="#dilivery-chart" data-toggle="tab">Vận chuyển</a></li>
            <li><a href="#lala-report" data-toggle="tab">Đối soát Lala</a></li>
            <li class="pull-left header"><i class="fa fa-inbox"></i> Chi tiết <?= $this->title ?> </li>
        </ul>
        <div class="tab-content no-padding">
            <!-- Morris chart - Sales -->
            <div class="chart tab-pane active" id="revenue-chart">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'_id',
                        //'posname',
                        'foodbook_code',
                        [
                            'attribute' => 'pos_id',
                            'value' => $model->pos->POS_NAME
                        ],

                        //'user_id',
                        //'isFromFoodbook',
//                        'order_data_item',
                        [
                            'attribute' => 'order_data_item',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'amount',
                            'value' => number_format($model->amount),
                        ],
                        [
                            'attribute' => 'discount_items',
                            'value' => number_format($model->discount_items),
                        ],
                        [
                            'attribute' => 'voucher',
                            'value' => number_format($model->voucher['used_discount_amount']),
                        ],

                        [
                            'attribute' => 'service_charge',
                            'value' => $model->service_charge*100 .'%',
                        ],

                        [
                            'attribute' => 'vat_tax_rate',
                            'value' => $model->vat_tax_rate*100 .'%',
                        ],
                        [
                            'attribute' => 'total_amount',
                            'value' => number_format($model->total_amount),
                            'label' => 'Tổng tiền (Sau chiết khấu)'
                        ],
                        [
                            'attribute' => 'ship_price_real',
                            'value' => $model->ship_price_real,
                        ],
                        'username',
                        'user_phone',
                        'status',
                        'to_address',
                        'coupon_log_id',
                        [
                            'value' => @$model->voucher['voucher_code'],
                            'label' => 'Mã voucher'
                        ],

                        //'pos_workstation',
                        //'duration',
                        //'address_id',,
                        'note',
                        //'payment_method',
                        [
                            'attribute' => 'paymentInfo',
                            'value' => Yii::t('yii',@$model->paymentInfo['payment_method'])
                        ],
                        //'payment_info',
                        //'booking_info',
                    ],
                ]) ?>
            </div>
            <div class="chart tab-pane" id="sales-chart">
                <?php

                    if($model->time_confirmed){
                        $time_confirmed = date('H:i:s d-m-Y',strtotime($model->time_confirmed));
                    }else{
                        $time_confirmed = $model->time_confirmed;
                    }

                    if($model->time_cancelled){
                        $time_cancelled = date('H:i:s d-m-Y',strtotime($model->time_cancelled));
                    }else{
                        $time_cancelled = $model->time_cancelled;
                    }

                    if($model->time_assigning){
                        $time_assigning = date('H:i:s d-m-Y',strtotime($model->time_assigning));
                    }else{
                        $time_assigning = $model->time_assigning;
                    }

                    if($model->time_accepted){
                        $time_accepted = date('H:i:s d-m-Y',strtotime($model->time_accepted));
                    }else{
                        $time_accepted = $model->time_accepted;
                    }

                    if($model->time_inprocess){
                        $time_inprocess = date('H:i:s d-m-Y',strtotime($model->time_inprocess));
                    }else{
                        $time_inprocess = $model->time_inprocess;
                    }

                    if($model->time_completed){
                        $time_completed = date('H:i:s d-m-Y',strtotime($model->time_completed));
                    }else{
                        $time_completed = $model->time_completed;
                    }

                    if($model->time_failed){
                        $time_failed = date('H:i:s d-m-Y',strtotime($model->time_failed));
                    }else{
                        $time_failed = $model->time_failed;
                    }

                    echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'_id',
                        //'created_at',
                        [
                            'attribute' => 'created_at',
                            'value' => date('H:i:s d-m-Y',strtotime($model->created_at))
                        ],
                        [
                            'attribute' => 'time_confirmed',
                            'value' => $time_confirmed
                        ],
                        [
                            'attribute' => 'time_cancelled',
                            'value' => $time_cancelled
                        ],
                        [
                            'attribute' => 'time_assigning',
                            'value' => $time_assigning
                        ],
                        [
                            'attribute' => 'time_accepted',
                            'value' => $time_accepted
                        ],
                        [
                            'attribute' => 'time_inprocess',
                            'value' => $time_inprocess
                        ],
                        [
                            'attribute' => 'time_completed',
                            'value' => $time_completed
                        ],
                        [
                            'attribute' => 'time_failed',
                            'value' => $time_failed
                        ],
                    ],
                ]) ?>
            </div>
            <div class="chart tab-pane" id="dilivery-chart" >
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'_id',
                        'ship_price_real',
//                        'total_fee',
                        //'duration',
                        'ahamove_code',
                        'supplier_id',
                        'supplier_name',
                        'shared_link',
                        //'payment_info',
                        'distance',
                    ],
                ]) ?>
            </div>

            <div class="chart tab-pane" id="lala-report" >
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'amount_total_item',
                            'format'=>['decimal',0],
                            'label' => 'Tổng tiền',
                            'pageSummary' => true,
                        ],
                        [
                            'attribute' => 'amount_driver_pay_mechant',
                            'format'=>['decimal',0],
                            'label' => 'Tài xế đã trả NH',
                            'pageSummary' => true,

                        ],
                        [
                            'attribute' => 'amount_partner_commission',
                            'format'=>['decimal',0],
                            'label' => 'NH discount LALA',
                            'pageSummary' => true,
                        ],
                        [
                            'attribute' => 'amount_partner_pay_merchant',
                            'format'=>['decimal',0],
                            'label' => 'LALA còn trả NH',
                            'pageSummary' => true,
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div><!-- /.nav-tabs-custom -->

</div>
