<?php
use yii\helpers\Url;
?>
<table id="commentRate" class="table table-bordered table-striped">
    <thead>
    <tr>
        <th></th>
        <th>Tên khách hàng</th>
        <th>Số điện thoại</th>
        <th>Nhà hàng</th>
        <th>Bình luận</th>
    </tr>
    </thead>
</table>
<div class="box-footer clearfix">
    <ul class="pagination pagination-sm no-margin pull-right">
        <li id="li_prePageRate"><a href="#" id="prePageRate">&laquo; Trở lại</a></li>
        <li id="li_nextPageRate"><a id="loadmoreRate" href="#"> Tiếp theo &raquo;</a></li>
    </ul>
    <input type="hidden" name="" value="<?= $curentpage; ?>">
</div>
<script>
    var customerComment = <?= json_encode(array_values((array)$comment)) ?>;
    dataTableCustomerComment("#commentRate",customerComment,"comment");
    var commentRate = 0;  // Xác định xem dã gọi lần đầu chưa, nếu gọi rồi thì thôi không load lại nữa khi click bào bình luận trên Rate.
    var pageCmFB = 1;
    var pageCmRate = 1;
    var isNextCmFB = 1;
    var isBackCmRate = <?= $curentpage ?>;
    var isNextCmRate = <?= @$is_next?>;

    var page = <?= $curentpage ?>

    $('a[id="comment_reate"]').click(function(event) {
        if(!commentRate){
            getdataCommentRate(1);
        }
    });

    function getdataCommentRate(page){
        $.ajax({type: "GET",
                url: "<?= Url::toRoute('/ajaxapi/getcommentinrate')?>",
                data: { page: page,'type' : 'get_comments_in_rate' },

                beforeSend: function() {
                    //that.$element is a variable that stores the element the plugin was called on
                    $("#content_bill").addClass("fb-grid-loading");
                },
                complete: function() {
                    //$("#modalButton").removeClass("loading");
                    $("#content_bill").removeClass("fb-grid-loading");
                },

                success:function(result){
                    var obj = JSON.parse(result);
                    dataTableCustomerComment("#commentRate",obj,"commentRate");
                    commentRate = 1;
                }}
        );
    }

    function getdataCommentRateLoadMore(page){
        $.ajax({type: "GET",
                url: "<?= Url::toRoute('/site/getcommentinrateloadmore')?>",
                data: { page: page,'type' : 'get_comments_in_rate' },

                beforeSend: function() {
                    //that.$element is a variable that stores the element the plugin was called on
                    $("#content_bill").addClass("fb-grid-loading");
                },
                complete: function() {
                    //$("#modalButton").removeClass("loading");
                    $("#content_bill").removeClass("fb-grid-loading");
                },

                success:function(result){
                    $("#table-body").html(result);
                }}
        );
    }

    if(pageCmFB == 1){
        $('#li_prePage').addClass('disabled');
        $('a[id="prePage"]').click(function(event) {
            return false;
        });
    }else{
        $('a[id="prePage"]').click(function(event) {
            getdataCommentRateLoadMore(page);
        });
    }

    if(pageCmRate == 1){ //Nếu kết quả trả về null thì sẽ disable nút next
        //console.log('next comment on FOodbook');
        $('a[id="loadmore"]').click(function(event) {
            getdataCommentRateLoadMore(page);
        });

    }else{
        $('#li_nextPage').addClass('disabled');
        $('a[id="loadmore"]').click(function(event) {
            return false;
        });
    }

    if(isBackCmRate >= 1){ //Nếu kết quả trả về is_next = 0 thì sẽ disable nút back
        console.log(isBackCmRate);
        var prePage = Number(page) - 2;
        $('a[id="prePageRate"]').click(function(event) {
            getdataCommentRateLoadMore(prePage);
        });
    }else{

        console.log(isBackCmRate);
        console.log('xit');
        $('#li_prePageRate').addClass('disabled');
        $('a[id="prePageRate"]').click(function(event) {
            return false;
        });
    }

    if(isNextCmRate == 1){ //Nếu kết quả trả về is_next = 0 thì sẽ disable nút next
        $('a[id="loadmoreRate"]').click(function(event) {
            getdataCommentRateLoadMore(page);
        });

    }else{
        $('#li_nextPageRate').addClass('disabled');
        $('a[id="loadmoreRate"]').click(function(event) {
            return false;
        });
    }

</script>