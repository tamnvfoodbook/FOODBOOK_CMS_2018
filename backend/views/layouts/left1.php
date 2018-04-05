<?php
use backend\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\helpers\Html;

$posParent = \Yii::$app->session->get('pos_parent');
?>
<aside class="main-sidebar">
<section class="sidebar">
<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-left image">
        <?php

        $imgLink = \Yii::$app->session->get('image_logo');
        if(!$imgLink){
            $posParenModel = new \backend\models\DmposparentSearch();
            $posParen = $posParenModel->searchPosparentById($posParent);
            $imgLink = $posParen->LOGO;
            \Yii::$app->session->set('image_logo',$imgLink);
            Yii::error($imgLink);
            Yii::error($posParenModel);
        }

        /*if (!file_exists($imgLink)) {
           $imgLink = Yii::$app->request->baseUrl.'/images/user2-160x160.png';
        }*/
//        var_dump($imgLink);
//        die();
        ?>
        <img src="<?= $imgLink ?>" class="img-circle" style="height: 45px" alt="User Image"/>
    </div>
    <div class="pull-left info">
        <p><?php
            echo $posId = \Yii::$app->session->get('fullname');

            ?></p>
        <p><?php
            echo $posId = \Yii::$app->session->get('username');
            ?> <?= Html::a('(Logout)',
                ['/site/logout'],
                ['data-method' => 'post'],
                ['class'=>'btn btn-primary']) ?>
        </p>
    </div>
</div>
<?php

$type = \Yii::$app->session->get('type_acc');
$posId = \Yii::$app->session->get('pos_id_list');
$userId = \Yii::$app->session->get('user_id');
$calcenter_ext = \Yii::$app->session->get('callcenter_ext');
$ipcc_permission = \Yii::$app->session->get('ipcc_permission');

if($calcenter_ext){
    $callhistory = '<li><a href="index.php?r=callcenterlog"><span class="fa fa-circle-o"></span>Theo dõi cuộc gọi</a></li>';
    /*$callhistory = '<li class="treeview">
                                <a href="#">
                                    <i class="fa fa-history"></i> <span>Lịch sử cuộc gọi</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <!--<li><a href="index.php?r=callcenterlog"><span class="fa fa-circle-o"></span>Theo dõi cuộc gọi</a></li>-->
                                    <!--<li><a href="index.php?r=callcenterlog"><span class="fa fa-circle-o"></span>Lịch sử cuộc gọi nhỡ</a></li>
                                    <li><a href="index.php?r=callcenterlog&all=1"><span class="fa fa-circle-o"></span>Lịch sử cuộc gọi đã nhận</a></li>-->
                                </ul>
                            </li>';*/
}else{
    $callhistory = '';
}

$totalMenu = ['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['site']];
if($posParent == 'TSTOCO'){

    if ($type!= 1) { ?>
        <?php
        if($type == 2){
            echo Nav::widget(
                [
                    'encodeLabels' => false,
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => [
                        '<li class="header">Menu</li>',
                        /*['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['site/index1']],*/
                        ['label' => '<i class="fa fa-bar-chart"></i><span>Biểu đồ khách hàng</span>', 'url' => ['dmmembershippoint/staticcrm']],
                        ['label' => '<i class="fa fa-desktop"></i><span>Danh sách nhà hàng</span>', 'url' => ['/dmpositem/index']],
                        '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-phone-square"></i> <span>Tổng đài</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=orderonlinelogpending/index"><span class="fa fa-circle-o"></span>Tổng đài đơn hàng chờ</a></li>
                                        <li><a href="index.php?r=orderonlinelog"><span class="fa fa-circle-o"></span>Theo dõi đơn hàng</a></li>
                                        <li><a href="index.php?r=orderonlinelog/indexstatic"><span class="fa fa-circle-o"></span>Đơn hàng hủy</a></li>
                                        <!--<li><a href="index.php?r=orderonlinelog/allorderpos"><span class="fa fa-circle-o"></span>Danh sách đơn hàng</a></li>-->
                                        <li><a href="index.php?r=orderonlinelog/report"><span class="fa fa-circle-o"></span>Báo cáo đơn hàng</a></li>
                                        <li><a href="index.php?r=bookingonline"><span class="fa fa-circle-o"></span>Danh sách đặt bàn</a></li>
                                        '.$callhistory.'
                                        <li><a href="index.php?r=/orderonlinelog/reportall"><span class="fa fa-circle-o"></span>Thống kê đơn hàng</a></li>
                                    </ul>
                                </li>

                            </ul>',
                        '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-users"></i> <span>CRM - Maketing</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <!--<li><a href="index.php?r=dmevent/create"><span class="fa fa-circle-o"></span>Tạo Chiến dịch CSKH</a></li>-->
                                        <!--<li><a href="index.php?r=/dmevent"><span class="fa fa-circle-o"></span>Quản lý Chiến dịch CSKH</a></li>-->
                                        <li><a href="index.php?r=/dmevent/report"><span class="fa fa-circle-o"></span>Chiến dịch CSKH</a></li>
                                        <li><a href="index.php?r=dmmembership/report"><span class="fa fa-circle-o"></span>Danh sách khách hàng</a></li>
                                        <li><a href="index.php?r=/orderrate/report"><span class="fa fa-circle-o"></span>Báo cáo đánh giá</a></li>

                                    </ul>
                                </li>
                            </ul>',
                        '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-tags"></i> <span>E- Voucher</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=dmvouchercampaign/createevoucher"><span class="fa fa-circle-o"></span>Tạo loại voucher mới</a></li>
                                        <li><a href="index.php?r=dmvouchercampaign/statistics"><span class="fa fa-circle-o"></span>Quản lý loại voucher</a></li>
                                        <li><a href="index.php?r=dmvouchercampaign/sendevoucher"><span class="fa fa-circle-o"></span>Tặng 1 Voucher</a></li>
                                        <!--<li><a href="index.php?r=dmvouchercampaign/evoucher"><span class="fa fa-circle-o"></span>Quản lý E - Voucher</a></li>-->
                                        <li><a href="index.php?r=dmvouchercampaign/creatmulti"><span class="fa fa-circle-o"></span>Xuất mã Voucher hàng loạt</a></li>
                                        <li><a href="index.php?r=dmvoucherlog/check"><span class="fa fa-circle-o"></span>Tra mã Voucher</a></li>
                                        <li><a href="index.php?r=dmvoucherlog/report"><span class="fa fa-circle-o"></span>Báo cáo mã sử dụng</a></li>
                                    </ul>
                                </li>
                            </ul>',
                        '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-user"></i> <span>Quản lý tài khoản</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=usermanager/view&id='.$userId.'"><span class="fa fa-circle-o"></span>Tài khoản của tôi</a></li>
                                        <li><a href="index.php?r=usermanager"><span class="fa fa-circle-o"></span>Tài khoản chi nhánh</a></li>
                                        <li><a href="index.php?r=pmemployee"><span class="fa fa-circle-o"></span>Tài khoản nhân viên</a></li>
                                    </ul>
                                </li>
                            </ul>',
                        '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-server"></i> <span>Khác</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=dmposparent/connect"><span class="fa fa-circle-o"></span>Kết nối</a></li>
                                        <li><a href="index.php?r=dmposparent/posview"><span class="fa fa-circle-o"></span>Cấu hình hệ thống</a></li>
                                        <li><a href="index.php?r=dmzalopageconfig/zalofunction"><span class="fa fa-circle-o"></span>Cấu hình Zalo</a></li>
                                        <li><a href="index.php?r=dmfacebookpageconfig/menu"><span class="fa fa-circle-o"></span>Facebook Menu</a></li>
                                    </ul>
                                </li>
                            </ul>',

                        [
                            'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sing in</span>', //for basic
                            'url' => ['/site/login'],
                            'visible' =>Yii::$app->user->isGuest
                        ],
                    ],
                ]
            );
        }else{
            if($ipcc_permission == 1){
                echo Nav::widget(
                    [
                        'encodeLabels' => false,
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                            '<li class="header">Menu</li>',
                            /*['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['site/index1']],*/
                            ['label' => '<i class="fa fa-bar-chart"></i><span>Biểu đồ khách hàng</span>', 'url' => ['dmmembershippoint/staticcrm']],
                            ['label' => '<i class="fa fa-desktop"></i><span>Danh sách nhà hàng</span>', 'url' => ['/dmpositem']],
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-phone-square"></i> <span>Tổng đài</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=orderonlinelogpending"><span class="fa fa-circle-o"></span>Tổng đài đơn hàng chờ</a></li>
                                        <li><a href="index.php?r=orderonlinelog"><span class="fa fa-circle-o"></span>Theo dõi đơn hàng</a></li>
                                        <li><a href="index.php?r=orderonlinelog/indexstatic"><span class="fa fa-circle-o"></span>Đơn hàng hủy</a></li>
                                        <!--<li><a href="index.php?r=orderonlinelog/allorderpos"><span class="fa fa-circle-o"></span>Danh sách đơn hàng</a></li>-->
                                        <li><a href="index.php?r=orderonlinelog/report"><span class="fa fa-circle-o"></span>Báo cáo đơn hàng</a></li>
                                        <li><a href="index.php?r=bookingonline"><span class="fa fa-circle-o"></span>Danh sách đặt bàn</a></li>
                                        '.$callhistory.'
                                        <li><a href="index.php?r=/orderonlinelog/reportall"><span class="fa fa-circle-o"></span>Thống kê đơn hàng</a></li>
                                    </ul>
                                </li>

                            </ul>',
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-users"></i> <span>CRM- Maketing</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <!--<li><a href="index.php?r=dmevent/create"><span class="fa fa-circle-o"></span>Tạo Chiến dịch CSKH</a></li>-->
                                        <!--<li><a href="index.php?r=/dmevent"><span class="fa fa-circle-o"></span>Quản lý Chiến dịch CSKH</a></li>-->
                                        <li><a href="index.php?r=/dmevent/report"><span class="fa fa-circle-o"></span>Chiến dịch CSKH</a></li>
                                        <li><a href="index.php?r=dmmembership/report"><span class="fa fa-circle-o"></span>Danh sách khách hàng</a></li>
                                        <li><a href="index.php?r=/orderrate/report"><span class="fa fa-circle-o"></span>Báo cáo đánh giá</a></li>


                                    </ul>
                                </li>
                            </ul>',
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-tags"></i> <span>E- Voucher</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=dmvouchercampaign/createevoucher"><span class="fa fa-circle-o"></span>Tạo loại voucher mới</a></li>
                                        <li><a href="index.php?r=dmvouchercampaign/statistics"><span class="fa fa-circle-o"></span>Quản lý loại voucher</a></li>
                                        <li><a href="index.php?r=dmvouchercampaign/sendevoucher"><span class="fa fa-circle-o"></span>Tặng 1 Voucher</a></li>
                                        <!--<li><a href="index.php?r=dmvouchercampaign/evoucher"><span class="fa fa-circle-o"></span>Quản lý E - Voucher</a></li>-->
                                        <li><a href="index.php?r=dmvouchercampaign/creatmulti"><span class="fa fa-circle-o"></span>Xuất mã Voucher hàng loạt</a></li>
                                        <li><a href="index.php?r=dmvoucherlog/check"><span class="fa fa-circle-o"></span>Tra mã Voucher</a></li>
                                        <li><a href="index.php?r=dmvoucherlog/report"><span class="fa fa-circle-o"></span>Báo cáo mã sử dụng</a></li>
                                    </ul>
                                </li>
                        </ul>',
                            ['label' => '<i class="fa fa-user"></i><span>Tài khoản của tôi</span>', 'url' => ['/usermanager/view','id' => $userId]],
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-server"></i> <span>Khác</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=dmposparent/connect"><span class="fa fa-circle-o"></span>Kết nối</a></li>
                                        <li><a href="index.php?r=dmposstats"><span class="fa fa-circle-o"></span>Thống kê giao vận</a></li>
                                    </ul>
                                </li>
                            </ul>',
                            [
                                'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sing in</span>', //for basic
                                'url' => ['/site/login'],
                                'visible' =>Yii::$app->user->isGuest
                            ],
                        ],
                    ]
                );
            }elseif($ipcc_permission == 2 ){
                echo Nav::widget(
                    [
                        'encodeLabels' => false,
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                            '<li class="header">Menu</li>',
                            /*['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['site/index1']],*/
                            ['label' => '<i class="fa fa-bar-chart"></i><span>Biểu đồ khách hàng</span>', 'url' => ['dmmembershippoint/staticcrm']],
                            ['label' => '<i class="fa fa-desktop"></i><span>Danh sách nhà hàng</span>', 'url' => ['/dmpositem']],
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-phone-square"></i> <span>Tổng đài</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=orderonlinelogpending"><span class="fa fa-circle-o"></span>Tổng đài đơn hàng chờ</a></li>
                                        <li><a href="index.php?r=orderonlinelog"><span class="fa fa-circle-o"></span>Theo dõi đơn hàng</a></li>
                                        <li><a href="index.php?r=orderonlinelog/indexstatic"><span class="fa fa-circle-o"></span>Đơn hàng hủy</a></li>
                                        <!--<li><a href="index.php?r=orderonlinelog/allorderpos"><span class="fa fa-circle-o"></span>Danh sách đơn hàng</a></li>-->
                                        <li><a href="index.php?r=orderonlinelog/report"><span class="fa fa-circle-o"></span>Báo cáo đơn hàng</a></li>
                                        <li><a href="index.php?r=bookingonline"><span class="fa fa-circle-o"></span>Danh sách đặt bàn</a></li>
                                        '.$callhistory.'
                                    </ul>
                                </li>

                            </ul>',
                            /*'<ul class="sidebar-menu">
                                    <li class="treeview">
                                        <a href="#">
                                            <i class="fa fa-users"></i> <span>CRM - Maketing</span>
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <!--<li><a href="index.php?r=dmevent/create"><span class="fa fa-circle-o"></span>Tạo Chiến dịch CSKH</a></li>-->
                                            <!--<li><a href="index.php?r=/dmevent"><span class="fa fa-circle-o"></span>Quản lý Chiến dịch CSKH</a></li>-->
                                            <li><a href="index.php?r=/dmevent/report"><span class="fa fa-circle-o"></span>Chiến dịch CSKH</a></li>
                                            <li><a href="index.php?r=dmmembership/report"><span class="fa fa-circle-o"></span>Danh sách khách hàng</a></li>
                                            <li><a href="index.php?r=/orderrate/report"><span class="fa fa-circle-o"></span>Báo cáo đánh giá</a></li>
                                            <li><a href="index.php?r=/orderonlinelog/reportall"><span class="fa fa-circle-o"></span>Thống kê đơn hàng</a></li>

                                        </ul>
                                    </li>
                                </ul>',
                            '<ul class="sidebar-menu">
                                    <li class="treeview">
                                        <a href="#">
                                            <i class="fa fa-tags"></i> <span>E- Voucher</span>
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="index.php?r=dmvouchercampaign/createevoucher"><span class="fa fa-circle-o"></span>Tạo loại voucher mới</a></li>
                                            <li><a href="index.php?r=dmvouchercampaign/statistics"><span class="fa fa-circle-o"></span>Quản lý loại voucher</a></li>
                                            <li><a href="index.php?r=dmvouchercampaign/sendevoucher"><span class="fa fa-circle-o"></span>Tặng 1 Voucher</a></li>
                                            <!--<li><a href="index.php?r=dmvouchercampaign/evoucher"><span class="fa fa-circle-o"></span>Quản lý E - Voucher</a></li>-->
                                            <li><a href="index.php?r=dmvouchercampaign/creatmulti"><span class="fa fa-circle-o"></span>Xuất mã Voucher hàng loạt</a></li>
                                        </ul>
                                    </li>
                                </ul>',*/
                            ['label' => '<i class="fa fa-user"></i><span>Tài khoản của tôi</span>', 'url' => ['/usermanager/view','id' => $userId]],
                            /*'<ul class="sidebar-menu">
                                    <li class="treeview">
                                        <a href="#">
                                            <i class="fa fa-server"></i> <span>Khác</span>
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="index.php?r=dmposparent/connect"><span class="fa fa-circle-o"></span>Kết nối</a></li>
                                            <li><a href="index.php?r=dmposstats"><span class="fa fa-circle-o"></span>Thống kê giao vận</a></li>
                                        </ul>
                                    </li>
                                </ul>',*/
                            [
                                'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sing in</span>', //for basic
                                'url' => ['/site/login'],
                                'visible' =>Yii::$app->user->isGuest
                            ],
                        ],
                    ]
                );
            }else{
                echo Nav::widget(
                    [
                        'encodeLabels' => false,
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                            '<li class="header">Menu</li>',
                            /*['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['site/index1']],*/
                            ['label' => '<i class="fa fa-bar-chart"></i><span>Biểu đồ khách hàng</span>', 'url' => ['dmmembershippoint/staticcrm']],
                            ['label' => '<i class="fa fa-desktop"></i><span>Danh sách nhà hàng</span>', 'url' => ['/dmpositem']],
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-phone-square"></i> <span>CRM - Maketing</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <!--<li><a href="index.php?r=dmevent/create"><span class="fa fa-circle-o"></span>Tạo Chiến dịch CSKH</a></li>-->
                                        <!--<li><a href="index.php?r=/dmevent"><span class="fa fa-circle-o"></span>Quản lý Chiến dịch CSKH</a></li>-->
                                        <li><a href="index.php?r=/dmevent/report"><span class="fa fa-circle-o"></span>Chiến dịch CSKH</a></li>
                                        <li><a href="index.php?r=dmmembership/report"><span class="fa fa-circle-o"></span>Danh sách khách hàng</a></li>
                                        <li><a href="index.php?r=/orderrate/report"><span class="fa fa-circle-o"></span>Báo cáo đánh giá</a></li>
                                        <li><a href="index.php?r=/orderonlinelog/reportall"><span class="fa fa-circle-o"></span>Thống kê đơn hàng</a></li>
                                    </ul>
                                </li>
                            </ul>',
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-phone-square"></i> <span>E- Voucher</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=dmvouchercampaign/createevoucher"><span class="fa fa-circle-o"></span>Tạo loại voucher mới</a></li>
                                        <li><a href="index.php?r=dmvouchercampaign/statistics"><span class="fa fa-circle-o"></span>Quản lý loại voucher</a></li>
                                        <li><a href="index.php?r=dmvouchercampaign/sendevoucher"><span class="fa fa-circle-o"></span>Tặng 1 Voucher</a></li>
                                        <!--<li><a href="index.php?r=dmvouchercampaign/evoucher"><span class="fa fa-circle-o"></span>Quản lý E - Voucher</a></li>-->
                                        <li><a href="index.php?r=dmvouchercampaign/creatmulti"><span class="fa fa-circle-o"></span>Xuất mã Voucher hàng loạt</a></li>
                                        <li><a href="index.php?r=dmvoucherlog/check"><span class="fa fa-circle-o"></span>Tra mã Voucher</a></li>
                                        <li><a href="index.php?r=dmvoucherlog/report"><span class="fa fa-circle-o"></span>Báo cáo mã sử dụng</a></li>
                                    </ul>
                                </li>
                            </ul>',
                            ['label' => '<i class="fa fa-user"></i><span>Tài khoản của tôi</span>', 'url' => ['/usermanager/view','id' => $userId]],
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-server"></i> <span>Khác</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=dmposparent/connect"><span class="fa fa-circle-o"></span>Kết nối</a></li>
                                        <li><a href="index.php?r=dmposstats"><span class="fa fa-circle-o"></span>Thống kê giao vận</a></li>
                                    </ul>
                                </li>
                            </ul>',
                            [
                                'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sing in</span>', //for basic
                                'url' => ['/site/login'],
                                'visible' =>Yii::$app->user->isGuest
                            ],
                        ],
                    ]
                );
            }
        }


    }else{ ?>
        <li class="header">Menu</li>

        <!--Coupon menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-tags"></i> <span>Coupon</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/coupon']) ?>"><span class="fa fa-circle-o"></span>Tạo Coupon</a>
                    </li>
                    <li><a href="<?= \yii\helpers\Url::to(['/couponlog']) ?>"><span class="fa fa-circle-o"></span> Coupon Log</a>
                    </li>
                    <li><a href="<?= \yii\helpers\Url::to(['/campaign']) ?>"><span class="fa fa-circle-o"></span> Campaign</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmvouchercampaign']) ?>"><span class="fa fa-circle-o"></span>Voucher Campaign</a></li>
                    <li><a href="index.php?r=dmvoucherlog/check"><span class="fa fa-circle-o"></span>Tra mã Voucher</a></li>
                    <li><a href="index.php?r=dmvoucherlog/report"><span class="fa fa-circle-o"></span>Báo cáo mã sử dụng</a></li>
                </ul>
            </li>
        </ul>
        <!--./Coupon menu -->

        <!--Điểm bán hàng menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-desktop"></i> <span>Điểm bán hàng</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/dmpos']) ?>"><span class="fa fa-circle-o"></span>Điểm bán hàng</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmposimagelist']) ?>"><span class="fa fa-circle-o"></span>Ảnh nhà hàng</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmposmaster']) ?>"><span class="fa fa-circle-o"></span>Điểm bán hàng FB</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmposmasterrelate']) ?>"><span class="fa fa-circle-o"></span>Quan hệ điểm bán hàng</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmposparent']) ?>"><span class="fa fa-circle-o"></span>Điểm chính</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmposparentpolicy']) ?>"><span class="fa fa-circle-o"></span>Chính sách điểm chính</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmtimeorder']) ?>"><span class="fa fa-circle-o"></span>Khai báo thời gian</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmpos/ready']) ?>"><span class="fa fa-circle-o"></span>Trạng thái sẵn sàng</a></li>
                </ul>
            </li>
        </ul>
        <!--./Điểm bán hàng menu-->

        <!--Món ăn menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cutlery"></i> <span>Món ăn</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/dmitem']) ?>"><span class="fa fa-circle-o"></span>Món ăn</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmitem/reportitem']) ?>"><span class="fa fa-circle-o"></span>Báo cáo món ăn</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['dmitem/itemsupdate']) ?>"><span class="fa fa-circle-o"></span>Món ăn Update</a></li>
                    <!--<li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span> Món ăn Foodbook</a></li>-->
                    <li><a href="<?= \yii\helpers\Url::to(['/dmitemtypemaster']) ?>"><span class="fa fa-circle-o"></span>Nhóm món ăn FB</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmpositem']) ?>"><span class="fa fa-circle-o"></span>Nhà hàng</a></li>
                </ul>
            </li>
        </ul>
        <!--./Món ăn menu-->
        <!--./menu Giám sát hệ thống-->
        <ul class="sidebar-menu">
            <li><a href="<?= \yii\helpers\Url::to(['/dmpolicyimage']) ?>"><i class="fa fa-file-photo-o"></i> <span>Ảnh chính sách</span></a></li>
        </ul>

        <!--Danh mục menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-server"></i> <span>Tỉnh thành</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/dmcity']) ?>"><span class="fa fa-circle-o"></span>Thành phố</a>
                    </li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmdistrict']) ?>"><span class="fa fa-circle-o"></span>Quận huyện</a>
                </ul>
            </li>
        </ul>
        <!--./Danh mục menu-->






        <!--Thành viên menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Thành viên</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/usermanager']) ?>"><span class="fa fa-circle-o"></span>Danh sách thành viên</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmmembership']) ?>"><span class="fa fa-circle-o"></span>Danh sách khách hàng</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmmembershippoint']) ?>"><span class="fa fa-circle-o"></span>Điểm khách hàng</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmmemberactionlog']) ?>"><span class="fa fa-circle-o"></span>Lịch sử KH hoạt động</a></li>
                    <!--    <li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span>Loại thành viên</a></li>-->
                    <li><a href="<?= \yii\helpers\Url::to(['/dmdevice']) ?>"><span class="fa fa-circle-o"></span>Quản lý thiết bị</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/admin']) ?>"><span class="fa fa-circle-o"></span>Quản lý phân quyền</a></li>

                </ul>
            </li>
        </ul >
        <!--./Thành viên menu-->
        <!--Đối tác  menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Đối tác</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/dmpartner']) ?>"><span class="fa fa-circle-o"></span>Đối tác</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmuserpartner']) ?>"><span class="fa fa-circle-o"></span>Tài khoản đối tác</a></li>
                </ul>
            </li>
        </ul>
        <!--./đối tác menu-->


        <!--Cấu hình hệ thống menu-->
        <!--<ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-gear"></i> <span>Hệ thống</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?/*= \yii\helpers\Url::to(['/admin']) */?>"><span class="fa fa-circle-o"></span>Quản lý phân quyền</a></li>
                    <li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span>Cấu hình</a></li>
                    <li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span>Sec Log</a></li>
                    <li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span>Khai báo menu</a></li>
                    <li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span>Khai báo chức năng</a></li>
                    <li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span>Kích hoạt tài khoản</a></li>
                </ul>
            </li>
        </ul>-->
        <!--./Cấu hình hệ thống menu-->



        <!--Tổng đài  menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-phone-square"></i> <span>Tổng đài</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/orderonlinelog']) ?>"><span class="fa fa-circle-o"></span>Theo dõi đơn hàng</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/orderonlinelog/indexstatic']) ?>"><span class="fa fa-circle-o"></span>Đơn hàng hủy</a></li>
                    <!--<li><a href="<?/*= \yii\helpers\Url::to(['/orderonlinelog/allorder']) */?>"><span class="fa fa-circle-o"></span>Thống kê đơn hàng</a></li>-->
                    <li><a href="<?= \yii\helpers\Url::to(['/callcenterlog']) ?>"><span class="fa fa-circle-o"></span>Tổng đài điện thoại</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/bookingonline']) ?>"><span class="fa fa-circle-o"></span>Thống kê đặt bàn</a></li>
                </ul>
            </li>
        </ul>
        <!--./Tổng đài menu-->

        <!--Giám sát hệ thống menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-eye"></i><span>Giám sát hệ thống</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/dmposparent/monitor']) ?>"><span class="fa fa-circle-o"></span>TD Thương hiệu</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmpos/monitorfb','type' => 'fb']) ?>"><span class="fa fa-circle-o"></span>TD điểm FB</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmpos/monitorfb']) ?>"><span class="fa fa-circle-o"></span>TD điểm POSMOBILE</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/orderrate']) ?>"><span class="fa fa-circle-o"></span>TD lượt Rate</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/orderonlinelog/waitorder']) ?>"><span class="fa fa-circle-o"></span>TD đơn hàng chờ</a></li>
                </ul>
            </li>
        </ul>

        <!-- Push menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i> <span> Phí vận chuyển</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/dmshipfee']) ?>"><span class="fa fa-circle-o"></span>Quản lý phí vận chuyển</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!--./Push menu-->

        <!--./menu Giám sát hệ thống-->
        <ul class="sidebar-menu">
            <li><a href="<?= \yii\helpers\Url::to(['site/pushnote']) ?>"><i class="fa fa-envelope"></i> <span>Gửi thông báo</span></a></li>
        </ul>

    <?php
    }
}else{
    if ($type!= 1) {?>
        <?php
        if($type == 2){
            echo Nav::widget(
                [
                    'encodeLabels' => false,
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => [
                        '<li class="header">Menu</li>',
                        ['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['site/index1']],
                        ['label' => '<i class="fa fa-bar-chart"></i><span>Biểu đồ khách hàng</span>', 'url' => ['dmmembershippoint/staticcrm']],
                        ['label' => '<i class="fa fa-desktop"></i><span>Danh sách nhà hàng</span>', 'url' => ['/dmpositem/index']],
                        '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-phone-square"></i> <span>Tổng đài</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=orderonlinelogpending/index"><span class="fa fa-circle-o"></span>Tổng đài đơn hàng chờ</a></li>
                                        <li><a href="index.php?r=orderonlinelog"><span class="fa fa-circle-o"></span>Theo dõi đơn hàng</a></li>
                                        <li><a href="index.php?r=orderonlinelog/indexstatic"><span class="fa fa-circle-o"></span>Đơn hàng hủy</a></li>
                                        <!--<li><a href="index.php?r=orderonlinelog/allorderpos"><span class="fa fa-circle-o"></span>Danh sách đơn hàng</a></li>-->
                                        <li><a href="index.php?r=orderonlinelog/report"><span class="fa fa-circle-o"></span>Báo cáo đơn hàng</a></li>
                                        <li><a href="index.php?r=bookingonline"><span class="fa fa-circle-o"></span>Danh sách đặt bàn</a></li>
                                        '.$callhistory.'
                                        <li><a href="index.php?r=/orderonlinelog/reportall"><span class="fa fa-circle-o"></span>Thống kê đơn hàng</a></li>
                                    </ul>
                                </li>

                            </ul>',
                        '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-users"></i> <span>CRM - Maketing</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <!--<li><a href="index.php?r=dmevent/create"><span class="fa fa-circle-o"></span>Tạo Chiến dịch CSKH</a></li>-->
                                        <!--<li><a href="index.php?r=/dmevent"><span class="fa fa-circle-o"></span>Quản lý Chiến dịch CSKH</a></li>-->
                                        <li><a href="index.php?r=/dmevent/report"><span class="fa fa-circle-o"></span>Chiến dịch CSKH</a></li>
                                        <li><a href="index.php?r=dmmembership/report"><span class="fa fa-circle-o"></span>Danh sách khách hàng</a></li>
                                        <li><a href="index.php?r=/orderrate/report"><span class="fa fa-circle-o"></span>Báo cáo đánh giá</a></li>

                                    </ul>
                                </li>
                            </ul>',
                        '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-tags"></i> <span>E- Voucher</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=dmvouchercampaign/createevoucher"><span class="fa fa-circle-o"></span>Tạo loại voucher mới</a></li>
                                        <li><a href="index.php?r=dmvouchercampaign/statistics"><span class="fa fa-circle-o"></span>Quản lý loại voucher</a></li>
                                        <li><a href="index.php?r=dmvouchercampaign/sendevoucher"><span class="fa fa-circle-o"></span>Tặng 1 Voucher</a></li>
                                        <!--<li><a href="index.php?r=dmvouchercampaign/evoucher"><span class="fa fa-circle-o"></span>Quản lý E - Voucher</a></li>-->
                                        <li><a href="index.php?r=dmvouchercampaign/creatmulti"><span class="fa fa-circle-o"></span>Xuất mã Voucher hàng loạt</a></li>
                                        <li><a href="index.php?r=dmvoucherlog/check"><span class="fa fa-circle-o"></span>Tra mã Voucher</a></li>
                                        <li><a href="index.php?r=dmvoucherlog/report"><span class="fa fa-circle-o"></span>Báo cáo mã sử dụng</a></li>
                                    </ul>
                                </li>
                            </ul>',
                        '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-user"></i> <span>Quản lý tài khoản</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=usermanager/view&id='.$userId.'"><span class="fa fa-circle-o"></span>Tài khoản của tôi</a></li>
                                        <li><a href="index.php?r=usermanager"><span class="fa fa-circle-o"></span>Tài khoản chi nhánh</a></li>
                                        <li><a href="index.php?r=pmemployee"><span class="fa fa-circle-o"></span>Tài khoản nhân viên</a></li>
                                    </ul>
                                </li>
                            </ul>',
                        '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-server"></i> <span>Khác</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=dmposparent/connect"><span class="fa fa-circle-o"></span>Kết nối</a></li>
                                        <li><a href="index.php?r=dmposparent/posview"><span class="fa fa-circle-o"></span>Cấu hình hệ thống</a></li>
                                        <li><a href="index.php?r=dmzalopageconfig/zalofunction"><span class="fa fa-circle-o"></span>Cấu hình Zalo</a></li>
                                        <li><a href="index.php?r=dmfacebookpageconfig/menu"><span class="fa fa-circle-o"></span>Facebook Menu</a></li>
                                    </ul>
                                </li>
                            </ul>',

                        [
                            'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sing in</span>', //for basic
                            'url' => ['/site/login'],
                            'visible' =>Yii::$app->user->isGuest
                        ],
                    ],
                ]
            );
        }else{
            if($ipcc_permission == 1){
                echo Nav::widget(
                    [
                        'encodeLabels' => false,
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                            '<li class="header">Menu</li>',
                            ['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['site/index1']],
                            ['label' => '<i class="fa fa-bar-chart"></i><span>Biểu đồ khách hàng</span>', 'url' => ['dmmembershippoint/staticcrm']],
                            ['label' => '<i class="fa fa-desktop"></i><span>Danh sách nhà hàng</span>', 'url' => ['/dmpositem']],
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-phone-square"></i> <span>Tổng đài</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=orderonlinelogpending"><span class="fa fa-circle-o"></span>Tổng đài đơn hàng chờ</a></li>
                                        <li><a href="index.php?r=orderonlinelog"><span class="fa fa-circle-o"></span>Theo dõi đơn hàng</a></li>
                                        <li><a href="index.php?r=orderonlinelog/indexstatic"><span class="fa fa-circle-o"></span>Đơn hàng hủy</a></li>
                                        <!--<li><a href="index.php?r=orderonlinelog/allorderpos"><span class="fa fa-circle-o"></span>Danh sách đơn hàng</a></li>-->
                                        <li><a href="index.php?r=orderonlinelog/report"><span class="fa fa-circle-o"></span>Báo cáo đơn hàng</a></li>
                                        <li><a href="index.php?r=bookingonline"><span class="fa fa-circle-o"></span>Danh sách đặt bàn</a></li>
                                        '.$callhistory.'
                                        <li><a href="index.php?r=/orderonlinelog/reportall"><span class="fa fa-circle-o"></span>Thống kê đơn hàng</a></li>
                                    </ul>
                                </li>

                            </ul>',
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-users"></i> <span>CRM- Maketing</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <!--<li><a href="index.php?r=dmevent/create"><span class="fa fa-circle-o"></span>Tạo Chiến dịch CSKH</a></li>-->
                                        <!--<li><a href="index.php?r=/dmevent"><span class="fa fa-circle-o"></span>Quản lý Chiến dịch CSKH</a></li>-->
                                        <li><a href="index.php?r=/dmevent/report"><span class="fa fa-circle-o"></span>Chiến dịch CSKH</a></li>
                                        <li><a href="index.php?r=dmmembership/report"><span class="fa fa-circle-o"></span>Danh sách khách hàng</a></li>
                                        <li><a href="index.php?r=/orderrate/report"><span class="fa fa-circle-o"></span>Báo cáo đánh giá</a></li>


                                    </ul>
                                </li>
                            </ul>',
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-tags"></i> <span>E- Voucher</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=dmvouchercampaign/createevoucher"><span class="fa fa-circle-o"></span>Tạo loại voucher mới</a></li>
                                        <li><a href="index.php?r=dmvouchercampaign/statistics"><span class="fa fa-circle-o"></span>Quản lý loại voucher</a></li>
                                        <li><a href="index.php?r=dmvouchercampaign/sendevoucher"><span class="fa fa-circle-o"></span>Tặng 1 Voucher</a></li>
                                        <!--<li><a href="index.php?r=dmvouchercampaign/evoucher"><span class="fa fa-circle-o"></span>Quản lý E - Voucher</a></li>-->
                                        <li><a href="index.php?r=dmvouchercampaign/creatmulti"><span class="fa fa-circle-o"></span>Xuất mã Voucher hàng loạt</a></li>
                                        <li><a href="index.php?r=dmvoucherlog/check"><span class="fa fa-circle-o"></span>Tra mã Voucher</a></li>
                                        <li><a href="index.php?r=dmvoucherlog/report"><span class="fa fa-circle-o"></span>Báo cáo mã sử dụng</a></li>
                                    </ul>
                                </li>
                        </ul>',
                            ['label' => '<i class="fa fa-user"></i><span>Tài khoản của tôi</span>', 'url' => ['/usermanager/view','id' => $userId]],
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-server"></i> <span>Khác</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=dmposparent/connect"><span class="fa fa-circle-o"></span>Kết nối</a></li>
                                        <li><a href="index.php?r=dmposstats"><span class="fa fa-circle-o"></span>Thống kê giao vận</a></li>
                                    </ul>
                                </li>
                            </ul>',
                            [
                                'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sing in</span>', //for basic
                                'url' => ['/site/login'],
                                'visible' =>Yii::$app->user->isGuest
                            ],
                        ],
                    ]
                );
            }elseif($ipcc_permission == 2 ){
                echo Nav::widget(
                    [
                        'encodeLabels' => false,
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                            '<li class="header">Menu</li>',
                            ['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['site/index1']],
                            ['label' => '<i class="fa fa-bar-chart"></i><span>Biểu đồ khách hàng</span>', 'url' => ['dmmembershippoint/staticcrm']],
                            ['label' => '<i class="fa fa-desktop"></i><span>Danh sách nhà hàng</span>', 'url' => ['/dmpositem']],
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-phone-square"></i> <span>Tổng đài</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=orderonlinelogpending"><span class="fa fa-circle-o"></span>Tổng đài đơn hàng chờ</a></li>
                                        <li><a href="index.php?r=orderonlinelog"><span class="fa fa-circle-o"></span>Theo dõi đơn hàng</a></li>
                                        <li><a href="index.php?r=orderonlinelog/indexstatic"><span class="fa fa-circle-o"></span>Đơn hàng hủy</a></li>
                                        <!--<li><a href="index.php?r=orderonlinelog/allorderpos"><span class="fa fa-circle-o"></span>Danh sách đơn hàng</a></li>-->
                                        <li><a href="index.php?r=orderonlinelog/report"><span class="fa fa-circle-o"></span>Báo cáo đơn hàng</a></li>
                                        <li><a href="index.php?r=bookingonline"><span class="fa fa-circle-o"></span>Danh sách đặt bàn</a></li>
                                        '.$callhistory.'
                                    </ul>
                                </li>

                            </ul>',
                            /*'<ul class="sidebar-menu">
                                    <li class="treeview">
                                        <a href="#">
                                            <i class="fa fa-users"></i> <span>CRM - Maketing</span>
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <!--<li><a href="index.php?r=dmevent/create"><span class="fa fa-circle-o"></span>Tạo Chiến dịch CSKH</a></li>-->
                                            <!--<li><a href="index.php?r=/dmevent"><span class="fa fa-circle-o"></span>Quản lý Chiến dịch CSKH</a></li>-->
                                            <li><a href="index.php?r=/dmevent/report"><span class="fa fa-circle-o"></span>Chiến dịch CSKH</a></li>
                                            <li><a href="index.php?r=dmmembership/report"><span class="fa fa-circle-o"></span>Danh sách khách hàng</a></li>
                                            <li><a href="index.php?r=/orderrate/report"><span class="fa fa-circle-o"></span>Báo cáo đánh giá</a></li>
                                            <li><a href="index.php?r=/orderonlinelog/reportall"><span class="fa fa-circle-o"></span>Thống kê đơn hàng</a></li>

                                        </ul>
                                    </li>
                                </ul>',
                            '<ul class="sidebar-menu">
                                    <li class="treeview">
                                        <a href="#">
                                            <i class="fa fa-tags"></i> <span>E- Voucher</span>
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="index.php?r=dmvouchercampaign/createevoucher"><span class="fa fa-circle-o"></span>Tạo loại voucher mới</a></li>
                                            <li><a href="index.php?r=dmvouchercampaign/statistics"><span class="fa fa-circle-o"></span>Quản lý loại voucher</a></li>
                                            <li><a href="index.php?r=dmvouchercampaign/sendevoucher"><span class="fa fa-circle-o"></span>Tặng 1 Voucher</a></li>
                                            <!--<li><a href="index.php?r=dmvouchercampaign/evoucher"><span class="fa fa-circle-o"></span>Quản lý E - Voucher</a></li>-->
                                            <li><a href="index.php?r=dmvouchercampaign/creatmulti"><span class="fa fa-circle-o"></span>Xuất mã Voucher hàng loạt</a></li>
                                        </ul>
                                    </li>
                                </ul>',*/
                            ['label' => '<i class="fa fa-user"></i><span>Tài khoản của tôi</span>', 'url' => ['/usermanager/view','id' => $userId]],
                            /*'<ul class="sidebar-menu">
                                    <li class="treeview">
                                        <a href="#">
                                            <i class="fa fa-server"></i> <span>Khác</span>
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="index.php?r=dmposparent/connect"><span class="fa fa-circle-o"></span>Kết nối</a></li>
                                            <li><a href="index.php?r=dmposstats"><span class="fa fa-circle-o"></span>Thống kê giao vận</a></li>
                                        </ul>
                                    </li>
                                </ul>',*/
                            [
                                'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sing in</span>', //for basic
                                'url' => ['/site/login'],
                                'visible' =>Yii::$app->user->isGuest
                            ],
                        ],
                    ]
                );
            }else{
                echo Nav::widget(
                    [
                        'encodeLabels' => false,
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                            '<li class="header">Menu</li>',
                            ['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['site/index1']],
                            ['label' => '<i class="fa fa-bar-chart"></i><span>Biểu đồ khách hàng</span>', 'url' => ['dmmembershippoint/staticcrm']],
                            ['label' => '<i class="fa fa-desktop"></i><span>Danh sách nhà hàng</span>', 'url' => ['/dmpositem']],
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-phone-square"></i> <span>CRM - Maketing</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <!--<li><a href="index.php?r=dmevent/create"><span class="fa fa-circle-o"></span>Tạo Chiến dịch CSKH</a></li>-->
                                        <!--<li><a href="index.php?r=/dmevent"><span class="fa fa-circle-o"></span>Quản lý Chiến dịch CSKH</a></li>-->
                                        <li><a href="index.php?r=/dmevent/report"><span class="fa fa-circle-o"></span>Chiến dịch CSKH</a></li>
                                        <li><a href="index.php?r=dmmembership/report"><span class="fa fa-circle-o"></span>Danh sách khách hàng</a></li>
                                        <li><a href="index.php?r=/orderrate/report"><span class="fa fa-circle-o"></span>Báo cáo đánh giá</a></li>
                                        <li><a href="index.php?r=/orderonlinelog/reportall"><span class="fa fa-circle-o"></span>Thống kê đơn hàng</a></li>
                                    </ul>
                                </li>
                            </ul>',
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-phone-square"></i> <span>E- Voucher</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=dmvouchercampaign/createevoucher"><span class="fa fa-circle-o"></span>Tạo loại voucher mới</a></li>
                                        <li><a href="index.php?r=dmvouchercampaign/statistics"><span class="fa fa-circle-o"></span>Quản lý loại voucher</a></li>
                                        <li><a href="index.php?r=dmvouchercampaign/sendevoucher"><span class="fa fa-circle-o"></span>Tặng 1 Voucher</a></li>
                                        <!--<li><a href="index.php?r=dmvouchercampaign/evoucher"><span class="fa fa-circle-o"></span>Quản lý E - Voucher</a></li>-->
                                        <li><a href="index.php?r=dmvouchercampaign/creatmulti"><span class="fa fa-circle-o"></span>Xuất mã Voucher hàng loạt</a></li>
                                        <li><a href="index.php?r=dmvoucherlog/check"><span class="fa fa-circle-o"></span>Tra mã Voucher</a></li>
                                        <li><a href="index.php?r=dmvoucherlog/report"><span class="fa fa-circle-o"></span>Báo cáo mã sử dụng</a></li>
                                    </ul>
                                </li>
                            </ul>',
                            ['label' => '<i class="fa fa-user"></i><span>Tài khoản của tôi</span>', 'url' => ['/usermanager/view','id' => $userId]],
                            '<ul class="sidebar-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-server"></i> <span>Khác</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="index.php?r=dmposparent/connect"><span class="fa fa-circle-o"></span>Kết nối</a></li>
                                        <li><a href="index.php?r=dmposstats"><span class="fa fa-circle-o"></span>Thống kê giao vận</a></li>
                                    </ul>
                                </li>
                            </ul>',
                            [
                                'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sing in</span>', //for basic
                                'url' => ['/site/login'],
                                'visible' =>Yii::$app->user->isGuest
                            ],
                        ],
                    ]
                );
            }
        }


    }else{?>
        <li class="header">Menu</li>

        <!--Coupon menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-tags"></i> <span>Coupon</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/coupon']) ?>"><span class="fa fa-circle-o"></span>Tạo Coupon</a>
                    </li>
                    <li><a href="<?= \yii\helpers\Url::to(['/couponlog']) ?>"><span class="fa fa-circle-o"></span> Coupon Log</a>
                    </li>
                    <li><a href="<?= \yii\helpers\Url::to(['/campaign']) ?>"><span class="fa fa-circle-o"></span> Campaign</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmvouchercampaign']) ?>"><span class="fa fa-circle-o"></span>Voucher Campaign</a></li>
                    <li><a href="index.php?r=dmvoucherlog/check"><span class="fa fa-circle-o"></span>Tra mã Voucher</a></li>
                    <li><a href="index.php?r=dmvoucherlog/report"><span class="fa fa-circle-o"></span>Báo cáo mã sử dụng</a></li>
                </ul>
            </li>
        </ul>
        <!--./Coupon menu -->

        <!--Điểm bán hàng menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-desktop"></i> <span>Điểm bán hàng</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/dmpos']) ?>"><span class="fa fa-circle-o"></span>Điểm bán hàng</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmposimagelist']) ?>"><span class="fa fa-circle-o"></span>Ảnh nhà hàng</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmposmaster']) ?>"><span class="fa fa-circle-o"></span>Điểm bán hàng FB</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmposmasterrelate']) ?>"><span class="fa fa-circle-o"></span>Quan hệ điểm bán hàng</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmposparent']) ?>"><span class="fa fa-circle-o"></span>Điểm chính</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmposparentpolicy']) ?>"><span class="fa fa-circle-o"></span>Chính sách điểm chính</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmtimeorder']) ?>"><span class="fa fa-circle-o"></span>Khai báo thời gian</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmpos/ready']) ?>"><span class="fa fa-circle-o"></span>Trạng thái sẵn sàng</a></li>
                </ul>
            </li>
        </ul>
        <!--./Điểm bán hàng menu-->

        <!--Món ăn menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cutlery"></i> <span>Món ăn</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/dmitem']) ?>"><span class="fa fa-circle-o"></span>Món ăn</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmitem/reportitem']) ?>"><span class="fa fa-circle-o"></span>Báo cáo món ăn</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['dmitem/itemsupdate']) ?>"><span class="fa fa-circle-o"></span>Món ăn Update</a></li>
                    <!--<li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span> Món ăn Foodbook</a></li>-->
                    <li><a href="<?= \yii\helpers\Url::to(['/dmitemtypemaster']) ?>"><span class="fa fa-circle-o"></span>Nhóm món ăn FB</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmpositem']) ?>"><span class="fa fa-circle-o"></span>Nhà hàng</a></li>
                </ul>
            </li>
        </ul>
        <!--./Món ăn menu-->
        <!--./menu Giám sát hệ thống-->
        <ul class="sidebar-menu">
            <li><a href="<?= \yii\helpers\Url::to(['/dmpolicyimage']) ?>"><i class="fa fa-file-photo-o"></i> <span>Ảnh chính sách</span></a></li>
        </ul>

        <!--Danh mục menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-server"></i> <span>Tỉnh thành</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/dmcity']) ?>"><span class="fa fa-circle-o"></span>Thành phố</a>
                    </li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmdistrict']) ?>"><span class="fa fa-circle-o"></span>Quận huyện</a>
                </ul>
            </li>
        </ul>
        <!--./Danh mục menu-->






        <!--Thành viên menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Thành viên</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/usermanager']) ?>"><span class="fa fa-circle-o"></span>Danh sách thành viên</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmmembership']) ?>"><span class="fa fa-circle-o"></span>Danh sách khách hàng</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmmembershippoint']) ?>"><span class="fa fa-circle-o"></span>Điểm khách hàng</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmmemberactionlog']) ?>"><span class="fa fa-circle-o"></span>Lịch sử KH hoạt động</a></li>
                    <!--    <li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span>Loại thành viên</a></li>-->
                    <li><a href="<?= \yii\helpers\Url::to(['/dmdevice']) ?>"><span class="fa fa-circle-o"></span>Quản lý thiết bị</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/admin']) ?>"><span class="fa fa-circle-o"></span>Quản lý phân quyền</a></li>

                </ul>
            </li>
        </ul >
        <!--./Thành viên menu-->
        <!--Đối tác  menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Đối tác</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/dmpartner']) ?>"><span class="fa fa-circle-o"></span>Đối tác</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmuserpartner']) ?>"><span class="fa fa-circle-o"></span>Tài khoản đối tác</a></li>
                </ul>
            </li>
        </ul>
        <!--./đối tác menu-->


        <!--Cấu hình hệ thống menu-->
        <!--<ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-gear"></i> <span>Hệ thống</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?/*= \yii\helpers\Url::to(['/admin']) */?>"><span class="fa fa-circle-o"></span>Quản lý phân quyền</a></li>
                    <li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span>Cấu hình</a></li>
                    <li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span>Sec Log</a></li>
                    <li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span>Khai báo menu</a></li>
                    <li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span>Khai báo chức năng</a></li>
                    <li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span>Kích hoạt tài khoản</a></li>
                </ul>
            </li>
        </ul>-->
        <!--./Cấu hình hệ thống menu-->



        <!--Tổng đài  menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-phone-square"></i> <span>Tổng đài</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/orderonlinelog']) ?>"><span class="fa fa-circle-o"></span>Theo dõi đơn hàng</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/orderonlinelog/indexstatic']) ?>"><span class="fa fa-circle-o"></span>Đơn hàng hủy</a></li>
                    <!--<li><a href="<?/*= \yii\helpers\Url::to(['/orderonlinelog/allorder']) */?>"><span class="fa fa-circle-o"></span>Thống kê đơn hàng</a></li>-->
                    <li><a href="<?= \yii\helpers\Url::to(['/callcenterlog']) ?>"><span class="fa fa-circle-o"></span>Tổng đài điện thoại</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/bookingonline']) ?>"><span class="fa fa-circle-o"></span>Thống kê đặt bàn</a></li>
                </ul>
            </li>
        </ul>
        <!--./Tổng đài menu-->

        <!--Giám sát hệ thống menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-eye"></i><span>Giám sát hệ thống</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/dmposparent/monitor']) ?>"><span class="fa fa-circle-o"></span>TD Thương hiệu</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmpos/monitorfb','type' => 'fb']) ?>"><span class="fa fa-circle-o"></span>TD điểm FB</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/dmpos/monitorfb']) ?>"><span class="fa fa-circle-o"></span>TD điểm POSMOBILE</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/orderrate']) ?>"><span class="fa fa-circle-o"></span>TD lượt Rate</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/orderonlinelog/waitorder']) ?>"><span class="fa fa-circle-o"></span>TD đơn hàng chờ</a></li>
                </ul>
            </li>
        </ul>

        <!-- Push menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i> <span> Phí vận chuyển</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= \yii\helpers\Url::to(['/dmshipfee']) ?>"><span class="fa fa-circle-o"></span>Quản lý phí vận chuyển</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!--./Push menu-->

        <!--./menu Giám sát hệ thống-->
        <ul class="sidebar-menu">
            <li><a href="<?= \yii\helpers\Url::to(['site/pushnote']) ?>"><i class="fa fa-envelope"></i> <span>Gửi thông báo</span></a></li>
        </ul>

    <?php
    }
}

?>

</section>
</aside>
