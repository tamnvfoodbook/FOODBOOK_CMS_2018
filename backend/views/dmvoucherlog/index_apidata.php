<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;


use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmvouchercampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách mã đã được tạo chiến dịch '.'"'.$name.'"';
$this->params['breadcrumbs'][] = ['label' => $name, 'url' => ['view','id' => $id,'total_voucher_log' => '' ]];
$this->params['breadcrumbs'][] = "Danh sách mã";

$dataProvider->pagination = false;
//echo '<pre>';
//var_dump($data);
//echo '</pre>';

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'voucher_code',
        'label'=>'Mã',

    ],
    [
        'attribute' => 'date_start',
        'label'=>'Ngày bắt đầu',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->date_start));
        },
    ],

    [
        'attribute' => 'date_end',
        'label'=>'Ngày kết thúc',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->date_end));
        },
    ],

    [
        'attribute' => 'date_created',
        'label'=>'Giảm giá',
        'value' => function ($model){
            return ($model->discount_type == 1) ? $model-> discount_amount.'đ' : $model->discount_extra*100 .'%' ;
        },
    ],

    [
        'attribute' => 'status',
        'label'=>'Trạng thái',
        'value' => function ($model){
            return Yii::$app->params['VOUCHER_LOG_STATUS'][$model->status];
        },
    ],
    [
        'attribute' => 'buyer_info',
        'label'=>'Người nhận',
        /*'value' => function ($model){
            return ($model->discount_type == 1) ? number_format($model-> discount_amount).'đ' : $model->discount_extra*100 .'%' ;
        },*/
    ],

    [
        'label'=>'Nhà hàng sử dụng',
        'value' => function ($model){
            return @$model->used_pos_name;
        },
    ],
    [
        'format' => 'raw',
        'value' => function ($data){
            return Html::a('Chi tiết',['dmvoucherlog/check','vouchercode' => $data->voucher_code ], ['class' => 'btn btn-success detail','target'=>'_blank']);
        },
        'label' => 'Chi tiết'
    ],
];

$gridColumnsExport = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'voucher_code',
        'label'=>'Mã',
    ],
    [
        'attribute' => 'date_start',
        'label'=>'Ngày bắt đầu',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->date_start));
        },
    ],
    [
        'attribute' => 'date_end',
        'label'=>'Ngày kết thúc',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->date_end));
        },
    ],
    [
        'attribute' => 'date_created',
        'label'=>'Giảm giá',
        'value' => function ($model){
            return ($model->discount_type == 1) ? $model-> discount_amount.'đ' : $model->discount_extra*100 .'%' ;
        },
    ],

    [
        'attribute' => 'status',
        'label'=>'Trạng thái',
        'value' => function ($model){
            return Yii::$app->params['VOUCHER_LOG_STATUS'][$model->status];
        },
    ],
    [
        'attribute' => 'buyer_info',
        'label'=>'Người nhận',
        /*'value' => function ($model){
            return ($model->discount_type == 1) ? number_format($model-> discount_amount).'đ' : $model->discount_extra*100 .'%' ;
        },*/
    ],

    [
        'label'=>'Nhà hàng sử dụng',
        'value' => function ($model){
            return @$model->used_pos_name;
        },
    ],
    [
        'attribute' => 'amount_order_over',
//        'label'=>'Trạng thái',
    ],
    [
        'attribute' => 'is_all_item',
//        'label'=>'Trạng thái',
    ],
    [
        'attribute' => 'item_type_id_list',
//        'label'=>'Trạng thái',
    ],
    [
        'attribute' => 'used_discount_amount',
//        'label'=>'Trạng thái',
    ],
    [
        'attribute' => 'used_bill_amount',
//        'label'=>'Trạng thái',
    ],
    [
        'attribute' => 'used_sale_tran_id',
//        'label'=>'Trạng thái',
    ],
    [
        'attribute' => 'apply_item_id',
//        'label'=>'Trạng thái',
    ],
    [
        'attribute' => 'apply_item_type',
//        'label'=>'Trạng thái',
    ],

    [
        'attribute' => 'number_item_buy',
//        'label'=>'Trạng thái',
    ],
    [
        'attribute' => 'number_item_free',
//        'label'=>'Trạng thái',
    ],
    [
        'attribute' => 'same_price',
//        'label'=>'Trạng thái',
    ],
];


?>
<br>

<?php $fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumnsExport,
    //'pjaxContainerId' => 'kv-pjax-container',
    'dropdownOptions' => [
        'label' => 'Export Full',
        'class' => 'btn btn-default',
        'itemsBefore' => [
            '<li class="dropdown-header">Export All Data</li>',
        ],
    ],
    'exportConfig' => [
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_PDF => false,
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_EXCEL => false,
        ExportMenu::FORMAT_EXCEL_X => false,
        ExportMenu::FORMAT_CSV => [
            'iconOptions' => ['class' => 'text-primary'],
            'linkOptions' => [],
            'mime' => 'application/csv',
            'extension' => 'csv',
            'writer' => 'CSV'
        ],
    ]
]);
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title">'.$this->title.'</h3>',
    ],
    'toolbar' => [

//        '{toggleData}',
//        '{export}',
        $fullExportMenu,
    ]

]);
?>

<?php
Modal::begin([
    'header' => '<h4 class="header"></h4>',
//    'footer' => '<input id= "btn_seteatwith" type="submit" value="Chọn" class="btn btn-success">',
    'footer' => '',
    'id' => 'creatCam',
]);
echo '<div class="" id="modal-content">hello</div>';

Modal::end();
?>

<script>
    $(function(){
        $('.detail').click(function(){
            var vouchercode = $(this).attr('id');
            $('.header').html('Chi tiết mã ' + vouchercode);

            $.ajax({type: "GET",
                    url: "<?= Url::toRoute('/dmvoucherlog/checkajax')?>",
                    data: { vouchercode : vouchercode },

                    beforeSend: function() {
                        //that.$element is a variable that stores the element the plugin was called on
                        $("#w0-container").addClass("fb-grid-loading");
                    },
                    complete: function() {
                        //$("#modalButton").removeClass("loading");
                        $("#w0-container").removeClass("fb-grid-loading");
                    },

                    success:function(result){
                        $('#creatCam').modal('show')
                            .find('#modal-content')
                            .load($(this).attr('value'));

                        $('#modal-content').html(result);

                    }}
            );
        });
    });


</script>

