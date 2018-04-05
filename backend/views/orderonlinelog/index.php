<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\assets\AppAsset;
use yii\bootstrap\Modal;
use backend\models\OrderonlinelogpendingSearch;


AppAsset::register($this);
$this->registerJsFile('js/jquery-1.11.3.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/jquery-1.6.1.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/jssip-sample-impl.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/jssip.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/rtcninja-temasys.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('css/popup-session.css', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderonlinelogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Theo dõi đơn hàng';

if($callcenter_ext){
    echo '
        <div class="row">
            <div class="col-md-6">
                <h5>Trạng thái tổng đài: <strong style="color: blue;"><span id="ext_current_state"></span>&nbsp;<span id="relogin"></span></strong></h5>
                <h5>Số máy lẻ: <strong style="color: blue;"><span id="ext_current"></span></strong></h5>
            </div>
            <div class="col-md-6 text-right">
                <div><label class="label-sound">Âm báo</label></div>
                <div>
                    <label class="switch">
                        <input type="checkbox" id="checkboxSound">
                        <div class="slider round"></div>
                    </label>
                </div>
            </div>
        </div>
        ';
}

?>

<script type="text/javascript">
    var str = getCookie("username");
    var checksoundOff = 1;
    if(str != ""){
        var arrChecksound = str.split("_");
        if(arrChecksound[1] == 0){
            checksoundOff = 0;
        }
    }
    if(checksoundOff == '1'){
        var checkBoxSoundElm = document.getElementById("checkboxSound");
        if (checkBoxSoundElm){
            checkBoxSoundElm.checked = true;
        }
    }

    $('input:checkbox').change(
        function(){
            if ($(this).is(':checked')) {
                var checkValue = 1;
            }else{
                checkValue = 0;
            }
            checkCookie(checkValue);
        });

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function checkCookie(checkValue) {
        var userId = '<?= \Yii::$app->session->get('username')?>' ;
//        var user = getCookie("username");
        var user = userId+"_"+checkValue;
        setCookie("username", user, 365);
    }


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

 <br>
<?php
// Check Đặt bàn
$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'vAlign'=>'top',

    ],
    [
        'attribute' => 'pos_is_call_center',
        'format' => 'raw',
        'value' => 'iscallcenter',
        'label' => 'TĐ',
        
    ],
    'foodbook_code',
    [
        'attribute' => 'booking_info',
        'format' => 'raw',
        'value' => 'bookinginfo',
        'label' => 'Loại giao hàng'
    ],
    //'_id',

//    'ahamove_code',

    //'username',
    //'user_phone',
    //'coupon_log_id',
    //'pos_id',
    [
        'attribute' => 'user_phone',
        'value' => 'memberinfo',
        'label' => 'Khách hàng',
        'format' => 'html'
    ],
    [
        'attribute' => 'pos_id',
        'value'=> function($data,$row) use ($allPosMap){
            return @$allPosMap[$data->pos_id];
        },
        //'group'=>true,  // enable grouping
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> $allPosMap,  // Biến Status được khai báo tại config/params.php
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn nhà hàng',
            'class' =>'select2-filter' // Set width của filter
        ],
    ],
    /*[
        'attribute' => 'pos_id',
        'format' => 'raw',
        'value' => 'posphonenumber',
        'label' => 'SĐT Nhà hàng'
    ],*/


    /*[
        'attribute' => 'pos_is_call_center',
        'value' => 'pos.IS_CALL_CENTER',
        'label' => 'Qua TĐ'
    ],*/

    //'isCallCenterConfirmed',
    //'status',
    /*[
        'attribute' => 'status',
        'format' => 'raw',
        'value' => 'imgestatus',
        'vAlign'=>'middle',
        'hAlign'=>'center',

    ],*/

//    'to_address',
    //'distance',
    //'total_fee',

            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => 'creatTime',
                'label' => 'Thời gian tạo'
            ],


    //'order_data_item',
    // 'pos_workstation',
    //'user_id',

    //'duration',
    //'isFromFoodbook',

    //'address_id',



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

//    [
//        'format' => 'raw',
//        'value' => 'suggest',
//        'label' => 'Hướng dẫn',
//    ],


//    [
//        'attribute' => 'created_by',
//        'label' => 'Nguồn tạo',
//    ],

    [
        'attribute' => 'updated_at',
        'hAlign'=>'center',
        'format' => 'raw',
        'value' => 'changeUpdateTime',
        'vAlign'=>'top',
        'label' => 'Trạng thái',
        'headerOptions' => ['style'=>'text-align:center'],
    ],
    [
        'format' => 'raw',
        'value' => 'actions',
        'label' => 'Thao tác',
        'vAlign'=>'top',
        'hAlign'=>'center',
    ],
    /*[
        'format' => 'raw',
        'value' => 'vieworder',
        'label' => '',
        'vAlign'=>'middle',
        'hAlign'=>'center',
        ,
    ],*/

//    [
//        'class' => 'yii\grid\ActionColumn',
//        'template'=>'{view}{delete}'
//    ],
];
?>

<div class="orderonlinelog-index">
    <?php Pjax::begin([
        'id' => 'medicine'
    ]);
    $searchBookingModel = new \backend\models\BookingonlinelogSearch();
    $checkNewBooking = $searchBookingModel->checkNewbooking();
//    echo '<pre>';
//    var_dump($checkNewBooking);
//    var_dump($checkNewBooking);
//    echo 'hello';
//    echo '</pre>';

    // Nếu như có đơn đặt bàn thì hiện thông báo
    if($checkNewBooking){
        echo '<script type="text/javascript">play_sound(2);</script>';
    }

    $searchPending = new OrderonlinelogpendingSearch();
    $checkNewPending = $searchPending->checkNewPending();

    // Nếu như có đơn pending thì hiện thông báo
    if($checkNewPending){
        echo '<script type="text/javascript">play_sound(3);</script>';
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


<?php
        $script = <<< JS
        $(document).ready(function() {
            setInterval(function(){ $("#refreshButton").click(); }, 20000);
        });
JS;

$this->registerJs($script);
?>

<style type="text/css">
    #target {
        cursor: pointer;
        font-weight: bold;
        font-style: italic;
        color: #003399;
    }
    td {
        border-bottom: 1px solid #CCC;
    }
</style>


<script type="text/javascript">
    $(document).ready(function() {
        var user_ext =  '<?= $callcenter_ext ?>';
        var ws_server_posparent =  '<?= $ws_server ?>';
        var ws_server_password =  '<?= $ws_pass ?>';
        if(user_ext){
            var ws_server = ws_server_posparent;
            var ext = user_ext;
            var pwd = ws_server_password;
            $("#ext_current").text(ext);

            INSTANCE.login(ws_server, ext, pwd);

            $('[id="target"]').bind( "click", function() {
                var target = $(this).text();
                INSTANCE.call(target);
            });

            on_loggedin = function() {
                console.log("*** on_loggedin");
                $("#ext_current_state").text("ONLINE");
                $("#relogin").text("");
                // PUT_YOUR_CODE_HERE
            };

            on_login_failed = function() {
                console.log("*** on_login_failed");
                $("#ext_current_state").text("offline");
                $("#relogin").text("(Re-Login)");
                // PUT_YOUR_CODE_HERE
            };

            on_disconnected = function() {
                console.log("*** on_disconnected");
                $("#ext_current_state").text("offline");
                $("#relogin").text("(Re-Login)");
                // PUT_YOUR_CODE_HERE
            };

            on_popup = function() {
                console.log(INSTANCE);
                console.log("*** on_popup >_ display_name (Ext or Phonenumber): "
                + INSTANCE.display_name
                + "; direction: "
                + INSTANCE.direction);
                // PUT_YOUR_CODE_HERE
            };

            on_accepted = function() {

                //console.log(INSTANCE);
                console.log("*** on_accepted >_ display_name (Ext or Phonenumber): "
                + INSTANCE.display_name
                + "; direction: "
                + INSTANCE.direction);
                // PUT_YOUR_CODE_HERE
            };

            on_ended = function() {

                console.log("*** on_ended >_ display_name (Ext or Phonenumber): "
                + INSTANCE.display_name
                + "; direction: "
                + INSTANCE.direction);
                // PUT_YOUR_CODE_HERE
            };

            on_denied = function() {
                console.log("*** on_denied >_ display_name (Ext or Phonenumber): "
                + INSTANCE.display_name
                + "; direction: "
                + INSTANCE.direction);
                // PUT_YOUR_CODE_HERE
            };

        }

    });
</script>

<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {display:none;}

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>

