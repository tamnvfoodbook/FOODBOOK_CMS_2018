
<?php
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = $this->title;
$this->title = 'Theo dõi tổng đài';



$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
//    [
//        'attribute' => 'cid_name',
//        'label' => 'Trạng thái',
//        'format' => 'raw',
//        'value' => function ($model) {
//            //return '<a href="#" id="target" class="target">'.@$model['cid_name'].'</a>';
//            return $model["status"] == 'NORMAL_CLEARING' ? '<image src="images/icon_phone_green.png"></image>' : '<image src="images/icon_phone_red.png"></image>';
//        },
//    ],
    [
        'attribute' => 'cid_name',
        'label' => 'Số điện thoại',
        'format' => 'raw',
        'value' => function ($model) {
            return '<a href="#" id="target" class="target">'.@$model['cid_name'].'</a>';
        },
    ],
    [
        'attribute' => 'name',
        'label' => 'Tên khách hàng',
    ],
    [
        'attribute' => 'start',
        'label' => 'Thời điểm gọi',
    ],
    [
        'attribute' => 'destination',
        'label' => 'Số nhánh',
    ],
//    [
//        'attribute' => 'status',
//        'label' => 'Trạng thái',
//    ],

    [
        'label' => 'Thao tác',
        'format' => 'raw',
        'value' => function ($model) {
            return Html::a("Tạo đơn", ['orderonlinelog/creatorder','id' => @$model['cid_name'] ], ['class' => 'btn btn-success']).' '.Html::a("Đặt bàn", ['orderonlinelog/creatorder','id' =>@$model['cid_name'] ,'isBooking' =>1 ], ['class' => 'btn btn-success']);
        },
    ],
];
?>
<br>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book-icon"></i> '.$this->title.'</h3>',
    ],
    'containerOptions' => [
        'format' => 'number',
        'thousandSep'=>','

    ],
    'toolbar' => [
        [
            'content'=>
                $this->render('_search', ['model' => $searchModel,'timeRanger' => $timeRanger])
        ],
        '{toggleData}',
        '{export}',
        //$fullExportMenu,
    ]
]);
?>



<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/popup-session.css" type="text/css" />
    <style type="text/css">
        .target{
            cursor: pointer;
            font-weight: bold;
            font-style: italic;
            color: #003399;
        }
        td {
            border-bottom: 1px solid #CCC;
        }
    </style>

    <script src="js/jquery-1.6.1.min.js" type="text/javascript"></script>
    <script src="js/jssip-sample-silent.js" type="text/javascript"></script>

    <!-- 0.7.4 -->
    <script src="js/jssip.js" type="text/javascript"></script>
    <script src="js/rtcninja-temasys.min.js" type="text/javascript"></script>

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
                    window.setTimeout('location.reload()', 1);
                    console.log("*** on_popup >_ display_name (Ext or Phonenumber): "
                    + INSTANCE.display_name
                    + "; direction: "
                    + INSTANCE.direction);

                    // PUT_YOUR_CODE_HERE
                };

                on_accepted = function() {
                    console.log("*** on_accepted >_ display_name (Ext or Phonenumber): "
                    + INSTANCE.display_name
                    + "; direction: "
                    + INSTANCE.direction);

                    console.log(INSTANCE);
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
</head>

</html>

