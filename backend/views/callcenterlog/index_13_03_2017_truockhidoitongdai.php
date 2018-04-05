
<?php
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = $this->title;
if($all){
    $this->title = 'Lịch sử cuộc gọi đã nhận';
}else{
    $this->title = 'Lịch sử cuộc gọi nhỡ';
}


$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'attribute' => 'cid_name',
        'label' => 'Người gọi đến',
        'format' => 'raw',
        'value' => function ($model) {
            return '<a href="#" id="target" class="target">'.@$model['cid_name'].'</a>';
        },
    ],
//    [
//        'attribute' => 'source',
//        'label' => 'Số nhánh',
//    ],
    [
        'attribute' => 'start',
        'label' => 'Thời gian bắt đầu',
        //'pageSummary' => true
    ],
    [
        'attribute' => 'duration',
        'label' => 'Thời gian',
        //'pageSummary' => true
    ],
    [
        'attribute' => 'status',
        'label' => 'Trạng thái',
    ],

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
    'showFooter' => true,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book-icon"></i> '.$this->title.'</h3>',
    ],
    'showPageSummary' => true,
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
    <title>Sample</title>
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
    <script src="js/jssip-sample-impl.js" type="text/javascript"></script>

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
<body>

<!--<div style="position: fixed; top: 30px; right: 256px">
    <h5>Ext Current: <strong style="color: blue;"><span id="ext_current"></span></strong></h5>
    <h5>Status: <strong style="color: blue;"><span id="ext_current_state"></span>&nbsp;<span id="relogin"></span></strong></h5>
</div>-->

<!--
<table id="mytable" cellspacing="0" summary="Click To Call Sample">
    <tr>
        <th scope="col" abbr="Configurations" class="nobg">Ext(s)</th>
        <th scope="col" abbr="101"><a id="target" >0979358807</a></th>
        <th scope="col" abbr="102"><a id="target" >102</a></th>
        <th scope="col" abbr="103"><a id="target" >103</a></th>
        <th scope="col" abbr="104"><a id="target" >104</a></th>
    </tr>
</table>-->

</body>
</html>

