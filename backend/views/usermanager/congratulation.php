<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/23/2015
 * Time: 10:38 AM
 */

?>

<div class="pad margin no-print">
    <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Note:</h4>
        <p>Chúc mừng bạn đã đổi mật khẩu thành công, website sẽ chuyển về màn hình đăng nhập sau <span id="counter">10</span> second(s).</p>
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