<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CouponlogSearch */
/* @var $dataProviderPos backend\models\CouponlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Couponlogs';
$this->params['breadcrumbs'][] = $this->title;
//echo '<pre>';
//var_dump($dataProviderPos->checkTab);
//echo '</pre>';
//die();
?>
<div class="couponlog-index">

    <p>
        <?= Html::a('Tạo Couponlog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right ui-sortable-handle">
            <li class="pull-left header"><i class="fa fa-inbox"></i>Coupon Log</li>
            <li class="active" ><a data-toggle="tab" href="#postype">Phạm vi nhà hàng</a></li>
            <li ><a data-toggle="tab" href="#posparentType">Phạm vi chuỗi</a></li>
            <li><a data-toggle="tab" href="#fbType">Phạm vi Toàn Foodbook</a></li>
        </ul>
        <div class="tab-content no-padding">
            <!-- Morris chart - Sales -->
            <div style="position: relative; height: auto;" id="postype" class="chart tab-pane active">
                <?= GridView::widget([
                    'dataProvider' => $dataProviderPos,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'Pos_Id',
                            'value' => 'pos.POS_NAME',

                            //'filterType'=> '\kartik\widgets\Select2',
                            'filterType'=> GridView::FILTER_SELECT2,

                            'filter'=> $allPosMap,
                            'filterWidgetOptions'=>[
                                'pluginOptions'=>['allowClear'=>true],
                            ],
                            'filterInputOptions'=>[
                                'placeholder'=>'Chọn nhà hàng',
                                'class' =>'select2-filter' // Set width của filter

                            ],

                        ],
                        [
                            'attribute' => 'dmmembership',
                            'value' => 'dmmembership.MEMBER_NAME',
                            'label' => 'Tên khách hàng'
                        ],
                        [
                            'attribute' => 'User_Id',
                        ],
                        [
                            'attribute' => 'Coupon_Log_Date',
                            'value' => 'coupondate',
                        ],
                        [
                            'attribute' => 'Coupon_Log_Start',
                            'value' => 'couponStartdate',
                        ],
                        [
                            'attribute' => 'Coupon_Log_End',
                            'value' => 'couponEnddate',
                        ],


                        //'Coupon_Id',
                        //'User_Id_Parent',
                        //'Coupon_Name',

                        'Denominations',
                        //'Share_Quantity',
                        //'Type',
                        'Active',
                        'Pr_Key',

                        ['class' => 'yii\grid\ActionColumn',
                            'template'=>'{view}{delete}'
                        ],
                    ],
                ]); ?>
            </div>
            <div style="position: relative;  height: auto;" id="posparentType" class="chart tab-pane">
                <?= GridView::widget([
                    'dataProvider' => $dataProviderParent,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'_id',
                        //'className',
                        //'Pos_Id',
                        'Pos_Parent',

                        [
                            'attribute' => 'dmmembership',
                            'value' => 'dmmembership.MEMBER_NAME',
                            'label' => 'Tên khách hàng'
                        ],
                        'User_Id',

                        //'Coupon_Id',
                        //'User_Id_Parent',
                        //'Coupon_Name',
                        [
                            'attribute' => 'Coupon_Log_Date',
                            'value' => 'coupondate',
                        ],
                        [
                            'attribute' => 'Coupon_Log_Start',
                            'value' => 'couponStartdate',
                        ],
                        [
                            'attribute' => 'Coupon_Log_End',
                            'value' => 'couponEnddate',
                        ],
                        'Denominations',
                        //'Share_Quantity',
                        //'Type',
                        'Active',
                        'Pr_Key',

                        ['class' => 'yii\grid\ActionColumn',
                            'template'=>'{view}{delete}'
                        ],
                    ],
                ]); ?>
            </div>
            <div style="position: relative;  height: auto;" id="fbType" class="chart tab-pane">
                <?= GridView::widget([
                    'dataProvider' => $dataProviderFb,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'_id',
                        //'className',
                        //'Pos_Id',
                        //'Pos_Parent',
                        [
                            'attribute' => 'dmmembership',
                            'value' => 'dmmembership.MEMBER_NAME',
                            'label' => 'Tên khách hàng'
                        ],
                        'User_Id',
                        //'Coupon_Id',
                        //'User_Id_Parent',
                        //'Coupon_Name',
                        [
                            'attribute' => 'Coupon_Log_Date',
                            'value' => 'coupondate',
                        ],
                        [
                            'attribute' => 'Coupon_Log_Start',
                            'value' => 'couponStartdate',
                        ],
                        [
                            'attribute' => 'Coupon_Log_End',
                            'value' => 'couponEnddate',
                        ],
                        'Denominations',
                        //'Share_Quantity',
                        //'Type',
                        'Active',
                        //'Pr_Key',

                        ['class' => 'yii\grid\ActionColumn',
                            'template'=>'{view}{delete}'
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>


</div>
