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
            $imgLink = @$posParen->LOGO;
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

$totalMenu = ['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['/site']];
if ($type!= 1) {?>
    <?php
    if($type == 2){
        echo Nav::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    '<li class="header menu-txt">Menu</li>',
                    ['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['/site']],
                    ['label' => '<i class="fa fa-bar-chart"></i><span>Biểu đồ khách hàng</span>', 'url' => ['dmmembershippoint/staticcrm']],
                    ['label' => '<i class="fa fa-desktop"></i><span>Nhà hàng & món ăn</span>', 'url' => ['/dmpositem/index']],
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
                                <i class="fa fa-gift"></i> <span>CSKH có điều kiện</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="index.php?r=event&triggername=birthday"><span class="fa fa-circle-o"></span>Sinh nhật</a></li>
                                <li><a href="index.php?r=event&triggername=membership_money_spent"><span class="fa fa-circle-o"></span>Thay đổi mức chi tiêu</a></li>
                                <li><a href="index.php?r=event&triggername=bill_printed"><span class="fa fa-circle-o"></span>Khi in hóa đơn</a></li>
                                <li><a href="index.php?r=event&triggername=remind_voucher"><span class="fa fa-circle-o"></span>Voucher sắp hết hạn</a></li>
                                <li><a href="index.php?r=event&triggername=remind_return"><span class="fa fa-circle-o"></span>Lâu ngày không trở lại</a></li>
                                <li><a href="index.php?r=event&triggername=membership_card_changed"><span class="fa fa-circle-o"></span>Thay đổi loại thành viên</a></li>
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
                                        <li><a href="index.php?r=dmfacebookpageconfig/facefunction"><span class="fa fa-circle-o"></span>Cấu hình Facebook</a></li>
                                        <li><a href="index.php?r=dmtimeorder"><span class="fa fa-circle-o"></span>Thời gian bán Deivery</a></li>
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
                        ['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['/site']],
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
                        ['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['/site']],
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
                        ['label' => '<i class="fa fa-user"></i><span>Tài khoản của tôi</span>', 'url' => ['/usermanager/view','id' => $userId]],

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
                        ['label' => '<i class="fa fa-dashboard"></i><span>Tổng quan đơn hàng</span>', 'url' => ['/site']],
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
    <li class="header">Menu FB</li>

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
                <li><a href="<?= \yii\helpers\Url::to(['/dmshipfee']) ?>"><span class="fa fa-circle-o"></span>Quản lý phí vận chuyển</a>
                <li><a href="<?= \yii\helpers\Url::to(['/dmpolicyimage']) ?>"><span class="fa fa-circle-o"></span>Ảnh chính sách</a>
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
                <li><a href="<?= \yii\helpers\Url::to(['/dmpositem']) ?>"><span class="fa fa-circle-o"></span>Nhà hàng & món ăn</a></li>
                <!--<li><a href="<?/*= \yii\helpers\Url::to(['/dmitem']) */?>"><span class="fa fa-circle-o"></span>Món ăn</a></li>-->
                <li><a href="<?= \yii\helpers\Url::to(['/dmitemtype']) ?>"><span class="fa fa-circle-o"></span>Nhóm món ăn</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['/dmitem/reportitem']) ?>"><span class="fa fa-circle-o"></span>Báo cáo món ăn</a></li>
                <!--<li><a href="<?/*= \yii\helpers\Url::to(['dmitem/itemsupdate']) */?>"><span class="fa fa-circle-o"></span>Món ăn Update</a></li>-->
                <!--<li><a href="<?/*= \yii\helpers\Url::to(['#']) */?>"><span class="fa fa-circle-o"></span> Món ăn Foodbook</a></li>-->
                <li><a href="<?= \yii\helpers\Url::to(['/dmitemtypemaster']) ?>"><span class="fa fa-circle-o"></span>Nhóm món ăn FB</a></li>

            </ul>
        </li>
    </ul>
    <!--./Món ăn menu-->

    <!--Thành viên menu-->
    <ul class="sidebar-menu">
        <li class="treeview">
            <a href="#">
                <i class="fa fa-user"></i> <span>Tài khoản - khách hàng</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?= \yii\helpers\Url::to(['/usermanager']) ?>"><span class="fa fa-circle-o"></span>Tài khoản quản trị</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['/dmuserpartner']) ?>"><span class="fa fa-circle-o"></span>Tài khoản đối tác</a></li>

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


    <ul class="sidebar-menu">
        <li class="treeview">
            <a href="#">
                <i class="fa fa-wrench"></i><span>Khác</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?= \yii\helpers\Url::to(['site/pushnote']) ?>"><span class="fa fa-circle-o"></span>Gửi thông báo</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['/dmpartner']) ?>"><span class="fa fa-circle-o"></span>Đối tác</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['/dmcity']) ?>"><span class="fa fa-circle-o"></span>Thành phố</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['/dmdistrict']) ?>"><span class="fa fa-circle-o"></span>Quận huyện</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['/mgpartnercustomfield']) ?>"><span class="fa fa-circle-o"></span>Tags</a></li>
            </ul>
        </li>
    </ul>


    <ul class="sidebar-menu">
        <li class="treeview">
            <a href="#">
                <i class="fa fa-cloud-download"></i><span>Commision</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?= \yii\helpers\Url::to(['/commission']) ?>"><span class="fa fa-circle-o"></span>Cấu hình Commission</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['/commission/report']) ?>"><span class="fa fa-circle-o"></span>Báo cáo Commission</a></li>
            </ul>
        </li>
    </ul>

    <li class="header">Menu LaLa</li>
    <ul class="sidebar-menu">
        <li><a href="<?= \yii\helpers\Url::to(['dmpositem/lala']) ?>"><i class="fa fa-mobile"></i> <span>Nhà hàng & Món ăn</span></a></li>
    </ul>

    <ul class="sidebar-menu">
        <li class="treeview">
            <a href="#">
                <i class="fa fa-users"></i><span>Tài khoản</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?= \yii\helpers\Url::to(['usermanager/lalauser']) ?>"><span class="fa fa-circle-o"></span>Thành viên</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['/pmemployee']) ?>"><span class="fa fa-circle-o"></span>Nhân viên</a></li>
            </ul>
        </li>
    </ul>

    <ul class="sidebar-menu">
        <li><a href="<?= \yii\helpers\Url::to(['/dmnotice']) ?>"><i class="fa fa-comment"></i> <span>Thông báo</span></a></li>
    </ul>


<?php
}

?>

</section>
</aside>

<style>
    .header{
        color: #fff;
        list-style: none;
        margin-top: 10px;
        margin-left: 9px;
    }
</style>