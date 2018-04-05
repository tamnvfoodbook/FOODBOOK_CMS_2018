<?php
use backend\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Bình luận trên FOODBOOK </a></li>
                <li><a href="#tab_2" data-toggle="tab" id="comment_reate">Bình luận khi Rate</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active " id="tab_1">
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="commentDetail" class="table table-bordered table-striped">
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
                                    <li id="li_prePage"><a href="#" id="prePage">&laquo; Trở lại</a></li>
                                    <li id="li_nextPage"><a id="loadmore" href="#"> Tiếp theo &raquo;</a></li>
                                </ul>
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div class="row">
                        <div class="col-xs-12" id="table-body">
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
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div><!-- nav-tabs-custom -->
    </div><!-- /.col -->
</div>
    <script type="text/javascript">
        var customerComment = <?= json_encode(array_values((array)$comment)) ?>;
        dataTableCustomerComment("#commentDetail",customerComment,"comment");
        var commentRate = 0;  // Xác định xem dã gọi lần đầu chưa, nếu gọi rồi thì thôi không load lại nữa khi click bào bình luận trên Rate.
        var pageCmFB = 1;
        var pageCmRate = 1;
        var isNextCmFB = 1;
        var isNextCmRate = 1;
        var dateStart = '<?= @$date_start ?>';
        var dateEnd = '<?= @$date_end?>';

        /*console.log('dateStart', dateStart);
        console.log('dateEnd', dateEnd);*/

        $('a[id="comment_reate"]').click(function(event) {
            if(!commentRate){
                getdataCommentRate(1);
            }
        });

        function getdataCommentRate(page){
                $.ajax({type: "GET",
                        url: "<?= Url::toRoute('/ajaxapi/getcommentinrate')?>",
                        data: { page: page,'type' : 'get_comments_in_rate','dateStart' : dateStart, 'dateEnd' : dateEnd  },

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
                getdataCommentRateLoadMore(2);
            });
        }

        if(pageCmRate == 1){ //Nếu kết quả trả về null thì sẽ disable nút next
            //console.log('next comment on FOodbook');
            $('#li_prePageRate').addClass('disabled');
            $('a[id="loadmore"]').click(function(event) {
                getdataCommentRateLoadMore(2);
            });

        }else{
            $('#li_nextPage').addClass('disabled');
            $('a[id="loadmore"]').click(function(event) {
                return false;
            });
        }



        if(isNextCmRate == 1){ //Nếu kết quả trả về is_next = 0 thì sẽ disable nút next
            $('a[id="loadmoreRate"]').click(function(event) {
                getdataCommentRateLoadMore(2);
            });

        }else{
            console.log('sang ben xit nay ');
            $('#li_nextPage').addClass('disabled');
            $('a[id="loadmoreRate"]').click(function(event) {
                return false;
            });
        }
    </script>
