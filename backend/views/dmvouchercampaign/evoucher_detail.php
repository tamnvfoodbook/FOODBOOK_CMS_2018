<?php
use yii\helpers\Url;
$this->registerJsFile('plugins/datatables/jquery.dataTables.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/custom_dataTable.js', ['position' => \yii\web\View::POS_HEAD]);

//echo '<pre>';
//var_dump($dataCampain);
//echo '</pre>';
//die();

?>
<div id="content_bill">
    <table id="voucherDetail" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th></th>
            <th>Mã Voucher</th>
            <th>Số điện thoại</th>
            <th>Nhà hàng</th>
            <th>Ngày sử dụng</th>
            <th>Giảm giá</th>
            <th>Tổng hóa đơn</th>
        </tr>
        </thead>
    </table>
    <div class="box-footer clearfix">
        <ul class="pagination pagination-sm no-margin pull-right">
            <li id="li_prePage"><a href="#" id="prePage">&laquo; Trở lại</a></li>
            <li id="li_nextPage"><a id="loadmore" href="#"> Tiếp theo &raquo;</a></li>
        </ul>
    </div>
</div><!-- /.row -->


<script type="text/javascript">
    var data = <?= json_encode(array_values((array)$dataCampain)); ?>;
    dataTableDeatailcampaign("#voucherDetail",data);

    var is_next = <?= $is_next; ?>;
    var pageinside = <?= $pageinside; ?>;
    var id = <?= $id ; ?>;

    function getdataLoadMore(id,pageinside){
        $.ajax({type: "GET",
                url: "<?= Url::toRoute('/dmvouchercampaign/getvoucherdetail')?>",
                data: { pageinside: pageinside, id : id},

                beforeSend: function() {
                    //that.$element is a variable that stores the element the plugin was called on
                    $("#content_bill").addClass("fb-grid-loading");
                },
                complete: function() {
                    //$("#modalButton").removeClass("loading");
                    $("#content_bill").removeClass("fb-grid-loading");
                },

                success:function(result){
                    $("#content_bill").html(result);
                }}
        );
    }

    if(pageinside == 1){
        $('#li_prePage').addClass('disabled');
        $('a[id="prePage"]').click(function(event) {
            return false;
        });
    }else{
        $('a[id="prePage"]').click(function(event) {
            getdataLoadMore(id,pageinside - 1);
        });
    }

    if(is_next == 0){ //Nếu kết quả trả về null thì sẽ disable nút next
        //console.log('next comment on FOodbook');

        $('#li_nextPage').addClass('disabled');
        $('a[id="loadmore"]').click(function(event) {
            return false;
        });

    }else{
        $('a[id="loadmore"]').click(function(event) {
            getdataLoadMore(id,pageinside + 1);
        });
    }
</script>