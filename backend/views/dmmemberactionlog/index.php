<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Lịch sử khách hàng hoạt động';
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    //'ID',
    'USER_ID',
    'CREATED_AT',
    'SPIN_RESULT',
    'DESCRIPTION',
    'POS_PARENT',
    'LOG_TYPE',
    'AMOUNT',
    'VOUCHER_LOG',
    'PAYMENT_METHOD',
    'UPDATED_AT',
    //'RECEIVER_PHONE',
    //'BANK_ACCOUNT',
     //'WITHDRAW_STATE',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}'
    ],
];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'pjax' => true,
    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
    'columns' => $gridColumns,

    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
    'toolbar' => [
        //'{export}',
        ['content'=>
            Html::a('Create', ['create'], ['class' => 'btn btn-success'])
        ],
    ]
]);
?>
