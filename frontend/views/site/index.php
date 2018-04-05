<?php
use frontend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('js/jquery-1.9.1.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/jquery.onepage-scroll.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/scroll-main.js', ['position' => \yii\web\View::POS_READY]);
$this->registerCssFile('css/onepage-scroll.css',['position' => \yii\web\View::POS_HEAD]);

/* @var $this \yii\web\View */
/* @var $content string */
?>

    <section class="page1">
        <div class="row row1">
				<!--Left Col-->
                <div class="col-lg-8 col-sm-8">
                    <div class="col-lg-offset-2">
                        <h2 class="title-foodbook">Foodbook.vn</h2>
                        <div class="title-am-thuc" >
                            <h4>Ẩm Thực Theo Phong Cách Mới</h4>
                            <div class="img-amthuc" ><img src="<?php echo \yii\helpers\Url::base().'/images/line-amthuc.png'?>" alt="Ipos"  /></div>
                        </div>
                        <div class="download-blog ">
                            <a class="btn btn-default version-btn center-block" href="#">Download</a>
                            <br>
                            <div class="center-block">
                                <a href="#"><img src="<?php echo \yii\helpers\Url::base().'/images/ios_ic.png' ?>" alt="Ipos" ></a>
                                <a  href="#"><img src="<?php echo \yii\helpers\Url::base().'/images/androi_ic.png' ?>" alt="Ipos"></a>
                            </div>
                        </div>
                    </div>
                    <div class="img-row-1">
                        <div class="col-lg-offset-1">
                            <h2 style="color: #fff; font-family: helveticaneuelight;padding-top: 2%;">Foodbook có gì nổi bật ?</h2>
                            <ul><li>Nhân viên giao hàng vận chuyển tới tận nơi .</li>
                                <li>Bạn có thể theo dõi được đồ ăn của mình đang đi đến đâu trên bản đồ.</li>
                                <li>Foodbook - Nơi hội tụ những địa điểm ăn uống thương hiệu bậc nhất Việt Nam</li>
                                <li>Bạn sẽ được hưởng những chính sách khuyến mãi và những món quà bất ngờ đến từ các nhà hàng</li>
                                <li>Bạn sẽ có trải nghiệm mới thông qua việc gọi đồ tại các nhà hàng hoặc có thể đặt hàng bất kì đâu </li>
                            </ul>
                            <br>
                        </div>
                    </div>
				</div>

                <!--Right Col-->
                <div class="col-lg-4 col-sm-4 ">
                    <img src="<?php echo \yii\helpers\Url::base().'/images/manhinh1.png' ?>" alt="Màn hình " class="fb-img single-img-1"/>
                </div>
                <!--End left-->
		</div>
    </section>
<div class="clearfix visible-xs"></div>
<div class="clearfix visible-sm"></div>


    <section class="page2">
        <!--Row 5-->
        <div class="row row2">
            <div class="container">
                <div class="col-lg-6">
                    <h2 style="padding-top:19%"><span>Tìm kiếm các địa điểm</span></h2>
                    <img  class="center-block fb-img" src="<?php echo \yii\helpers\Url::base().'/images/icon-nha-hang.png' ?>" alt="Logo Ipos"/>
                    <p style="font-size: large; font-family: helveticaneuelight;">Khi sử dụng App, Foodbook sẽ <span>định vị</span> và <span> dẫn đường </span>giúp khách hàng tới Nhà hàng nhanh chóng nhất.</p>
                    <br>
                    <img src="<?php echo \yii\helpers\Url::base().'/images/map.png' ?>" alt="Logo Ipos" class="center-block fb-img"/>
                </div>
                <div class="col-lg-6 row5-right">
                    <img src="<?php echo \yii\helpers\Url::base().'/images/manhinh3.png' ?>" alt="Logo Ipos" class="single-img center-block fb-img"/>
                </div>
            </div>
        </div>
    </section>

    <section class="page3">
        <!--Row 3-->
        <div class="row row1">
            <div class="container">
                <div class="col-lg-6">
                    <img src="<?php echo \yii\helpers\Url::base().'/images/manhinh2.png' ?>" alt="Ipos" class="fb-img single-img center-block">
                </div>
                <div class="col-lg-6 rơw4-right">
                    <img src="<?php echo \yii\helpers\Url::base().'/images/logo-ipos-xanh.png' ?>" alt="Logo Ipos" class="inlineimg"/><span class="text-right-row4">xây dựng ứng dụng Foodbook từ năm 2014. Mục tiêu: Foodbook là công cụ hỗ trợ Nhà hàng thực hiện các chương trình về marketing nhằm thúc đẩy về hình ảnh và tăng doanh số bán hàng.</span>
                    <br>
                    <br>
                    <br>
                    <br>
                    <img src="<?php echo \yii\helpers\Url::base().'/images/ipos-ip.png' ?>" alt="Logo Ipos" class="center-block fb-img"/>
                </div>
            </div>
        </div>
    </section>

    <section class="page4">
        <!--Row 6-->
        <div class="row row1">
            <div class="container">
                <div class="col-lg-6">
                    <img src="<?php echo \yii\helpers\Url::base().'/images/manhinh4.png' ?>" alt="Ipos" class="center-block fb-img single-img">
                </div>
                <div class="col-lg-6">
                    <h2 style="margin-top: 30%;"><span>Nội dung, hình ảnh</span></h2>
                    <p style="font-size: 150%; margin-bottom: 5%; font-family: helveticaneuelight;">Nội dung, hình ảnh chuyên nghiệp giới thiệu về nhà hàng và các món ăn đặc trưng.</p>
                    <img src="<?php echo \yii\helpers\Url::base().'/images/mon-an.png' ?>" alt="Logo Ipos" class="fb-img" />
                </div>
            </div>
        </div>
    </section>

    <section class="page5">
        <!--Row 7-->
        <div class="row row2">
            <div class="container">
                <div class="col-lg-6">
                    <h2 style="padding-top:14%"><span>Đặt đồ Trực tuyến</span></h2>
                    <p style="font-size: large; font-family: helveticaneuelight;">Khách hàng có thể đặt món online. dù ở bất kỳ đâu chỉ với một vài thao tác đơn giản.</p>
                    <img  class="center-block fb-img" src="<?php echo \yii\helpers\Url::base().'/images/tien.png' ?>" alt="Logo Ipos" class="inlineimg" />
                    <p style="font-size: large; font-family: helveticaneuelight;">Theo thống kê một năm, tại Mỹ, thương mại điện tử trong lĩnh vực nhà hàng đem đến doanh thu <span>200</span> tỷ USD, và có mức tăng trưởng <span>15%</span>/năm. Như vậy, đặt món trực tuyến là một thị trường đầy tiềm năng nếu nhà hàng đầu tư đúng mức.</p>
                </div>
                <div class="col-lg-6 row5-right">
                    <img src="<?php echo \yii\helpers\Url::base().'/images/manhinh5.png' ?>" alt="Logo Ipos" class="image-5 center-block fb-img"/>
                </div>
            </div>
        </div>
    </section>

    <section class="page6">
        <div class="row row1">
            <div class="container">
                <div class="title-product">Liên hệ hợp tác</div>
                <img src="<?php echo \yii\helpers\Url::base().'/images/icon-bat-tay.png' ?>" alt="Logo Ipos" class="image-hop-tac center-block fb-img"/>
            </div>
        </div>
        <div class="background-footer">
            <div class="container">
                <h4 class="tite-footer">CÔNG TY TNHH FOODBOOK</h4>
                <h5 class="footer-body">Địa chỉ : Tầng 11, Tòa nhà Hòa Bình, 106 Hoàng Quốc Việt. Cầu Giấy, Hà Nội.</h5>
                <h5 class="footer-body">Số điện thoại : 04 3750 9666 / 04 3750 9777</h5>
                <h5 class="footer-body">Email: cskh@foodbook.vn.</h5>
                <br>
            </div>
        </div>
    </section>



<script>
    $(document).ready(function(){
        $(".main").onepage_scroll({
            sectionContainer: "section",
            responsiveFallback: 600,
            loop: true
        });
    });
</script>