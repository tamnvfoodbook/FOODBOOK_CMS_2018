<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$mapEvent = [
    'birthday' => 'Sinh nhật',
    'membership_money_spent' => 'Thay đổi mức chi tiêu',
    'bill_printed' => 'Khi in hóa đơn',
    'remind_voucher' => 'Voucher sắp hết hạn',
    'remind_return' => 'Lâu ngày không trở lại',
    'membership_card_changed' => 'Thay đổi loại thành viên',
];
$this->title = 'Sự kiện'.$mapEvent[$triggername];

$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'label' => 'Nội dung gửi',
        'value' => function ($model) {
            if(@$model->trigger_message){
                return 'Tin nhắn: '.$model->trigger_message;
            }else{
                return 'Voucher: '.@$model->trigger_voucher_campaign;
            }
        },
    ],
    [
        'label' => 'Mức chi tiêu',
        'value' => function ($model) {
                return number_format($model->trigger_bill_printed->min_amount) .' - '. number_format(@$model->trigger_bill_printed->max_amount);
        },
    ],
    [
        'attribute' => 'created_at',
        'label' => 'Ngày tạo',
        'value' => function ($model) {
            if(@$model->created_at){
                return date(Yii::$app->params['DATE_TIME_FORMAT'],strtotime($model->created_at));
            }
        },
    ],
    [
        'attribute' => 'updated_at',
        'label' => 'Cập nhật',
        'value' => function ($model) {
            if(@$model->updated_at){
                return date(Yii::$app->params['DATE_TIME_FORMAT'],strtotime($model->updated_at));
            }
        },
    ],
    [
        'attribute' => 'active',
        'label' => 'Trạng thái',
        'value' => function ($model) {
            return ($model->active) ? 'Active' : "Deactive";

        },
    ],

    [
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'headerOptions' => ['style'=>'color:#3c8dbc'],
        'value' => function ($model){
            return Html::a('Hủy', ['cancel','id' => $model->Id , 'trigger_name' => $model->trigger_name ], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('backend', 'Bạn có chắc chắn muốn hủy ?'),
                ],
            ]);
        },
        'label' => 'Thao tác'
    ],

];
?>
<br>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,

    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
    'toolbar' => [
        //'{export}',
        ['content'=>
            Html::a('Tạo mới', ['create','triggername' => $triggername ], ['class' => 'btn btn-success'])
        ],
    ]
]);
?>
