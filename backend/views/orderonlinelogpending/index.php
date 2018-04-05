<?php


use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\models\OrderonlinelogpendingSearch;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderonlinelogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Tổng đài đơn hàng chờ';

?>

<br>
<?php
// Check Đặt bàn
$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'vAlign'=>'top',

    ],
    //'_id',

    'foodbook_code',
    [
        'attribute' => 'booking_info',
        'format' => 'raw',
        'value' => 'bookinginfo',
        'label' => 'Loại giao hàng'
    ],
    //'username',
//    'user_phone',

    //'coupon_log_id',
    //'pos_id',
    [
        'attribute' => 'user_phone',
        'label' => 'Khách hàng',
        'format' => 'raw',
        'value'=> function($data,$row) /*use ($allMemberMap)*/{
//            var_dump(@$data->user_status);
            $name = '';
            if($data->username){
                $name = $data->username;
            }else{
                if($data->user_status){
                    $name = @$data->user_status;
                }/*else{
                    $name = @$allMemberMap[$data->user_phone];;
                }*/
            }
            $result = $data->user_phone.'</br>'.$name;
            return $result;
        },
    ],
    [
        'attribute' => 'pos_id',
        'value'=> function($data,$row) use ($allPosMap){
            return @$allPosMap[$data->pos_id];
        },
    ],
    'to_address',

    [
        'label' => 'Danh sách món',
        'format' => 'raw',
        'value'=> function($data,$row){
            $listItem = NULL;
            foreach((array)$data->order_data_item as $item){
                if(isset($item['Item_Name'])){
                    $note = '';
                    if(@$item['Note']){
                        $note = '-'.$item['Note'].'';
                    }
                    $listItem = $listItem.$item['Item_Name'].'('.$item['Quantity'].')'.$note.'<br/>';
                }
            }

            return $listItem;

        },
    ],
     'note',

    [
        'attribute' => 'created_by',
        'label' => 'Nguồn tạo',
    ],

    [
        'attribute' => 'update_at',
        'hAlign'=>'center',
        'format' => 'raw',
        'value' => 'changeUpdateTime',
        'vAlign'=>'top',
        'label' => 'Thời gian chờ',
        'headerOptions' => ['style'=>'text-align:center'],
    ],

//    [
//        'class' => 'yii\grid\ActionColumn',
//        'template'=>'{update} {delete}'
//    ],
    [
        'format' => 'raw',
        'label' => 'Thao tác',
        'value' => 'actions'
    ],

];
?>

<div class="orderonlinelog-index">
    <?php Pjax::begin([
        'id' => 'medicine'
    ]);


    /*$searchBookingModel = new \backend\models\BookingonlinelogSearch();
    $checkNewBooking = $searchBookingModel->checkNewbooking();*/

    // Nếu như có đơn đặt bàn thì hiện thông báo
    /*if($checkNewBooking){
        echo '<script type="text/javascript">play_sound(2);</script>';
    }*/


    $searchOrderModel = new \backend\models\OrderonlinelogSearch();
    $checkNewOrder = $searchOrderModel->checkNewOrder();

    // Nếu như có đơn đặt bàn thì hiện thông báo
    if($checkNewOrder){
        // echo '<script type="text/javascript">play_sound(1);</script>';
    }


    $searchPending = new OrderonlinelogpendingSearch();
    $checkNewPending = $searchPending->checkNewPending();

    // Nếu như có đơn pending thì hiện thông báo
    if($checkNewPending){
        // echo '<script type="text/javascript">play_sound(3);</script>';
    }

    // End nếu như có đơn đặt bàn thì hiện thông báo

    ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
//        'pjax' => true,
//        'pjaxSettings' => [
//            'options' => [
//                'id' => 'grid',
//            ],
//            'loadingCssClass' => false,
//            'neverTimeout'=>true,
//        ],

        'columns' => $gridColumns,
        'panel' => [
            'type' => GridView::TYPE_SUCCESS,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
        ],
        'toolbar' => [
            //'{export}',
            //Html::button('Tạo đơn bằng số điện thoại', ['class' => 'btn btn-primary']),
            Html::a("Tạo đơn hàng", ['orderonlinelog/creatorder','id' =>'' ], ['class' => 'btn btn-success','target'=>'_blank','data-pjax'=>"0"]),
            Html::a("Đặt bàn", ['orderonlinelog/creatorder','id' =>'','isBooking' =>1 ], ['class' => 'btn btn-success']),
            Html::a("Làm mới", ['index'], ['class' => 'btn btn-success','id' => 'refreshButton']),
        ]
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>
<script>
    function play_sound(type) {
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '/music/sound_file'+ type +'.mp3');
        audioElement.setAttribute('autoplay', 'autoplay');
        audioElement.load();
        audioElement.play();
        // Show popup notify
        document.addEventListener('DOMContentLoaded', function () {
            if (Notification.permission !== "granted")
                Notification.requestPermission();
        });


        if (!Notification) {
            alert('Trình duyệt của bạn không cho phép bật thông báo, xin vui lòng thử lại.');
            return;
        }

        if (Notification.permission !== "granted")
            Notification.requestPermission();
        else {
            if(type == 1){
                var notification = new Notification('Đơn hàng mới từ Foodbook', {
                    icon: 'http://image.foodbook.vn/images/fb/ic_lancher_158x158.png',
                    body: "Vừa có đơn hàng mới, Click tại đây để kiểm tra đơn hàng! "
                });

                notification.onclick = function () {
                    window.open("index.php?r=orderonlinelog");
                };
            }else if(type == 2){
                notification = new Notification('Đặt bàn mới từ Foodbook', {
                    icon: 'http://image.foodbook.vn/images/fb/ic_lancher_158x158.png',
                    body: "Vừa đặt bàn mới , Click tại đây để kiểm tra đặt bàn!"
                });

                notification.onclick = function () {
                    window.open("index.php?r=bookingonline");
                };
            }else{
                notification = new Notification('Đơn hàng chờ mới từ Foodbook', {
                    icon: 'http://image.foodbook.vn/images/fb/ic_lancher_158x158.png',
                    body: "Vừa đơn hàng chờ mới , Click tại đây để kiểm tra đơn hàng chờ!"
                });

                notification.onclick = function () {
                    window.open("index.php?r=orderonlinelogpending");
                };
            }

        }
        // End Show popup notify
    }
</script>

<?php
$script = <<< JS
        $(document).ready(function() {
            setInterval(function(){ $("#refreshButton").click(); }, 5000);
        });
JS;

$this->registerJs($script);
?>