<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Download';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row row1">
    <div class="container">
        <!--Left Col-->
        <div class="col-lg-6">
            <h2 class="title-foodbook">Foodbook.vn</h2>
            <div class="title-am-thuc" >
                <h4>Ẩm Thực Theo Phong Cách Mới</h4>
                <div class="img-amthuc" ><img src="<?php echo \yii\helpers\Url::base().'/images/line-amthuc.png'?>" alt="Ipos"  /></div>
            </div>
            <div class="row1-text">
                <div style="float: left;"><a class="btn btn-default download-btn" href="#"style="width: 143px">Final version</a></div>
                <div style="float: left; margin:1% 3%;"><img src="<?php echo \yii\helpers\Url::base().'/images/separator-pink.png'?>" alt="Ipos" /></div>
                <div class="ios-btn"><a class="btn btn-default version-btn" href="https://itunes.apple.com/nz/app/foodbook.vn/id1025260209?mt=8">IOS Version</a></div>
                <div><a class="btn btn-default version-btn" href="https://play.google.com/store/apps/details?id=com.ipos.foodbook">Android Version</a></div>
            </div>
            <div class="row1-text">
                <div style="float: left;"><a class="btn btn-default download-btn" href="http://install.diawi.com/L5ySEw" style="width: 143px">Demo version </a></div>
                <div style="float: left; margin:1% 3%;"><img src="<?php echo \yii\helpers\Url::base().'/images/separator-pink.png'?>" alt="Ipos" /></div>
                <div class="ios-btn"><a class="btn btn-default version-btn" href="#">IOS Version</a></div>
                <div><a class="btn btn-default version-btn" href="http://119.17.212.89:3382/images/download/foodbooktest.apk">Android Version</a></div>
            </div>

        </div>
        <!--Right-->
        <div class="col-lg-6">
            <img src="<?php echo \yii\helpers\Url::base().'/images/man-hinh-dang-nhap.png' ?>" alt="Ipos" style="width: 75%; height: auto;padding-top: 22%; float:right; margin-right: 10%" class="fb-img">
        </div>
    </div>
</div>
