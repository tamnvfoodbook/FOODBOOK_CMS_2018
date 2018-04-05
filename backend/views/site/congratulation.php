<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/23/2015
 * Time: 10:38 AM
 */

?>
<div class="content-welcome">
    <div class="">
        <img src="images/loading-bubbles.svg" width="64" height="64" />
        <h1 class=""><?= $meseage ?> thành công!</h1>
        <p>Chúc mừng bạn đã <?= $meseage ?> thành công, website sẽ chuyển về màn hình <a href="index.php">đăng nhập</a> sau <span id="counter">10</span> giây(s)....</p>
    </div>
</div>

<script type="text/javascript">
    function countdown() {
        var i = document.getElementById('counter');
        if (parseInt(i.innerHTML)<=1) {
            location.href = '<?= \Yii::$app->urlManager->createUrl("site/index")?>';
        }
        i.innerHTML = parseInt(i.innerHTML)-1;
    }
    setInterval(function(){ countdown(); },1000);
</script>

<style>
    .content-welcome{
        width: 60%;;
        margin: 0 auto;
        text-align: center;
        padding-top: 15%;
        color: white;
    }
    .content-welcome p{
        font-size: 110%;
    }
</style>