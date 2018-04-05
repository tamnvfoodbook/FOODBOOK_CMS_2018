<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmeventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chiến dịch CSKH';
$this->params['breadcrumbs'][] = $this->title;

$campainType = [
    1 => 'SMS',
    2 => 'Zalo',
    3 => 'Facebook'
];

//echo '<pre>';
//var_dump($dataProvider);
//echo '</pre>';
//die();

$gridColumns1 = [
    ['class' => 'yii\grid\SerialColumn'],

//    'membership_id',
    [
        'attribute' => 'date_created',
        'width' => '95px',
        'label' => 'Ngày tạo',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->date_created));
        },
    ],
    [
        'attribute' => 'date_start',
        'label' => 'Ngày bắt đầu',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->date_start));
        },
    ],
    [
        'attribute' => 'event_name',
        'label' => 'Tên chiến dịch'
    ],
    [
        'attribute' => 'send_type',
        'label' => 'Kênh',
        'value' => function ($model) use ($campainType){
            return @$campainType[$model->send_type];
        },
    ],
    [
        'label' => 'Điều kiện',
        'format' => 'raw',
        'value' => function ($model){
            if($model->max_eat_count == Yii::$app->params['maxAmount']){
                $model->max_eat_count = 'không giới hạn';
            }else{
                $model->max_eat_count = number_format($model->max_eat_count);
            }

            return '<div id="Tooltip_Text_container">
                        <span>Xem</span>
                        <a href="#">
                        <div class="tooltips">
                            Số lần ăn từ: <b>'.number_format($model->min_eat_count).'</b> lần đến <b>'.$model->max_eat_count.'</b> lần<br/>
                            Số tiền ăn từ: <b>'.number_format(@$model->min_pay_amount).'</b> đ đến <b>'.number_format($model->max_pay_amount).' </b> đ<br/>
                            Số điểm từ: <b>'.number_format(@$model->min_point).'</b> điểm đến <b>'.number_format($model->max_point).' </b> điểm<br/>
                        </div>
                        </a>
                    </div>';
        },
    ],
    [
        'attribute' => 'campaign_id',
        'format' => 'raw',
        'value' => function ($model) use($campaginsMap){
            return '<a href="#" onclick="campagindetail('.@$model->campaign_id.');">'.@$campaginsMap[@$model->campaign_id].'</a>';
        },
        'label' => 'Loại Voucher',
    ],


    [
        'attribute' => 'expected_approach',
        'label' => 'Số lượng tiếp cận',
        'format' => 'raw',
        'value' => function ($model){
            if($model->expected_approach){
                $content = '<p>Dự kiến: '.@$model->expected_approach.'</p> Thực tế: '. @$model->practical_approach .' ('.number_format(@$model->practical_approach/$model->expected_approach*100) .'%)</p>';
            }else{
                $content = '<p>Dự kiến: '.@$model->expected_approach.'</p> Thực tế: '.@$model->practical_approach.' </p>';
            }

            return $content;
        },

    ],

    [
        'attribute' => 'running_result.member_used_voucher',
        'format' => 'raw',
        'value' => function ($model){
            if($model->expected_approach != 0 && @$model->running_result->member_used_voucher != 0 ){
                $content = @$model->running_result->member_used_voucher .' ('.number_format(@$model->running_result->member_used_voucher/$model->expected_approach*100) .'%)</p>';
            }else{
                $content = '0';
            }

            return $content;
        },
        'label' => 'Khách đến ăn',
    ],

    [
        'attribute' => 'running_result.total_amount',
        'format' => 'raw',
        'width' => '200px',
        'value' => function ($model){
            if(@$model->running_result->total_amount){
                $content = '<p>Trước giảm giá: '.@$model->running_result->total_amount.'</p> Sau giảm giá: '. @$model->running_result->discount_amount .' ('.number_format(@$model->running_result->discount_amount/@$model->running_result->total_amount*100) .'%)</p>';
            }else{
                $content = '<p>Trước giảm giá: '.@$model->running_result->total_amount.'</p> Sau giảm giá: '. @$model->running_result->discount_amount.'</p>';
            }

            return $content;
        },
        'label' => 'Doanh số',
    ],

    [
        'attribute' => 'status',
        'value' => function ($model){
            return ($model->status == 1) ? 'Đã gửi' : 'Chờ gửi';
        },
        'label' => 'Gửi tin'
    ],

    [
        'format' => 'raw',
        'label' => 'Trạng thái',
        'value' => function ($model){
            if($model->status == 0){
                return Html::a("Hủy", ['dmevent/remove','id' =>$model->id ], ['class' => 'btn btn-danger','data-confirm' => 'Bạn có chắc chắn hủy ?']);
            }else{
                return 'Hoàn thành';
            }
        }
    ],

];
$gridColumns2 = [
    ['class' => 'yii\grid\SerialColumn'],

//    'membership_id',
    [
        'attribute' => 'date_created',
        'label' => 'Ngày tạo',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->date_created));
        },
    ],
    [
        'attribute' => 'date_start',
        'label' => 'Ngày bắt đầu',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->date_start));
        },
    ],
    [
        'attribute' => 'event_name',
        'format' => 'raw',
        'label' => 'Tên sự kiện'
    ],

    [
        'attribute' => 'send_type',
        'label' => 'Kênh',
        'value' => function ($model) use ($campainType){
            return @$campainType[$model->send_type];
        },
    ],

    [
        'attribute' => 'content_message',
        'label' => 'Tin nhắn',
    ],

    [
        'attribute' => 'expected_approach',
        'label' => 'Số lượng tiếp cận',
        'format' => 'raw',
        'value' => function ($model){
            if($model->expected_approach){
                $content = '<p>Dự kiến: '.@$model->expected_approach.'</p> Thực tế: '. @$model->practical_approach .' ('.number_format(@$model->practical_approach/$model->expected_approach*100) .'%)</p>';
            }else{
                $content = '<p>Dự kiến: '.@$model->expected_approach.'</p> Thực tế: '.@$model->practical_approach.' </p>';
            }

            return $content;
        },

    ],


    [
        'attribute' => 'status',
        'format' => 'raw',
        'value' => function ($model){
            return ($model->status == 1) ? 'Hoàn thành' : 'Chờ gửi';
        },
        'label' => 'Trạng thái'
    ],
    [
        'format' => 'raw',
        'value' => function ($model){
            if($model->status == 0){
                return Html::a("Hủy", ['dmevent/remove','id' =>$model->id ], ['class' => 'btn btn-danger','data-confirm' => 'Bạn có chắc chắn hủy ?']);
            }else{
                return 'Hoàn thành';
            }
        }
    ],
];

if($searchModel->EVENT_TYPE != 2){
    $gridColumns = $gridColumns1;
}else{
    $gridColumns = $gridColumns2;
}

?>

<?php
Modal::begin([
    'header' => '<h4>Chi tiết loại Voucher</h4>',
    'id' => 'modal',
]);
echo '<div id="capagindetail">';?>
<?php echo '</div>';
Modal::end();
?>


<br>
<div>
    <?= $this->render('_search_report', [
        'model' => $searchModel,
    ])?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title">'.$this->title.'</h3>',
    ],
    'toolbar' => [
        '{toggleData}',
        '{export}',
        //$fullExportMenu,
    ]

]);
?>
<style>
    .element-extend{
        word-break: break-all;
    }

    div#Tooltip_Text_container {
        max-width: 25em;
        height: auto;
        display: inline;
        position: relative;
    }

    div#Tooltip_Text_container a {
        text-decoration: none;
        color: black;
        cursor: default;
        font-weight: normal;
    }

    div#Tooltip_Text_container a div.tooltips {
        visibility: hidden;
        opacity: 0;
        transition: visibility 0s linear 0.2s, opacity 0.2s linear;
        position: absolute;
        left: 10px;
        top: 18px;
        width: 30em;
        border: 1px solid #404040;
        padding: 0.2em 0.5em;
        cursor: default;
        line-height: 140%;
        font-size: 12px;
        font-family: 'Segoe UI';
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        -moz-box-shadow: 7px 7px 5px -5px #666;
        -webkit-box-shadow: 7px 7px 5px -5px #666;
        box-shadow: 7px 7px 5px -5px #666;
        background: #E4E5F0  repeat-x;
    }

    div#Tooltip_Text_container:hover a div.tooltips {
        visibility: visible;
        opacity: 1;
        transition-delay: 0.2s;
    }


    div#Tooltip_Text_container:hover a div.tooltips {
        visibility: visible;
        opacity: 1;
        transition-delay: 0.2s;
    }

</style>

 <script>
     $(function() {
         $( '.booking_step[title]' ).tooltip();
     });

     // Script Popup Order Detail
     function campagindetail(campaginId){
         $.ajax({type: "GET",
                 url: "<?= Url::toRoute('campaindetail')?>",
                 data: { 'campagin_id' : campaginId },

                 success:function(result){
                     $('#capagindetail').html(result);
                 }}
         );

         $('#modal').modal('show')
             .find('#capagindetail')
             .load($(this).attr('value'));

     }
 </script>