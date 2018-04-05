<?php
use yii\helpers\Html;
use \yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmeventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$campainType = Yii::$app->params['campainType'];


$this->title = 'Danh sách E - Voucher';
$this->params['breadcrumbs'][] = $this->title;
//echo '<pre>';
//var_dump($dataCampain);
//echo '</pre>';
//die();
?>
<br>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $this->title ?></h3>
        <div class="box-tools pull-right">
            <!--<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>-->
            <?= Html::a('Tạo e - Voucher', ['createevoucher'], ['class' => 'btn btn-success']) ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body" id="box_id">
        <?php
        foreach((array)$dataCampain as $value){
//            echo '<pre>';
//            var_dump($value);
//            echo '</pre>';
//            die();
            $campainName = mb_strimwidth(@$value->voucher_campaign_name,0,30,'...','utf-8');
            ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><a href="#" onclick="getvoucherdetail('<?= $value->id?>');"><?= $campainName ?></a></h3>
                        <div class="box-tools pull-right">
                            <!--<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>-->
                            <?php
                            if(!@$value->active){
                                echo '<button class="btn btn-box-tool" id="sk_<?= $value->id?>" onclick="removeEvent('.$value->id.')"><i class="fa fa-times"></i></button>';
                            }
                            ?>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 no-padding">
                            <h3 style="color: #35b429;font-weight: 700; margin-top:0"><?= $value->discount_type == 1 ? number_format(@$value->discount_amount).' đ' : (@$value->discount_extra *100 .'%');?><span style="font-size: 15px"></span></h3>
                        </div>
                        <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 ">
                            <div class="text-right">
                                <span><?= $value->duration.' ngày ('.$value->quantity_per_day.' vc/ngày)' ?></span><br>
                                <span><?= @$campainType[$value->campaign_type] ?></span><br>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding">
                            <span>Phát hành</span><br>
                            <span>Đã sử dụng</span><br>
                            <span>Doanh số trước giảm giá</span><br>
                            <span>Doanh số sau giảm giá</span><br>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                            <div class="pull-right text-right">
                                <span><?= '<b>'.$value->total_voucher_log.'</b>'.' KH'?></span><br>
                                <span><?= '<b>'.number_format(@$value->total_used).'</b>'?></span><br>
                                <span> <?= '<b>'.number_format(@$value->total_used_amount) .'</b> đ' ?></span><br>
                                <span> <?= '<b>'.number_format(@$value->total_amount_after_discount) .'</b> đ' ?></span><br>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div>
            </div>
        <?php
        }
        ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->


<?php
Modal::begin([
    'header' => '<h4>Chi tiết bình luận</h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo '<div id="detailCampain">';
echo '</div>';
Modal::end();
?>

<script>
    function removeEvent(id){
        var r = confirm("Bạn có chắc chắn muốn hủy e - Voucher ?");
        if(r == true) {
            $.ajax({type: "GET",
                url: "<?= Url::toRoute('dmvouchercampaign/removeevoucher')?>",
                data: { id: id },
                beforeSend: function() {
                    //that.$element is a variable that stores the element the plugin was called on
                    $("#box_id").addClass("fb-grid-loading");
                },
                success:function(result){
                    $("#box_id").removeClass("fb-grid-loading");
                    alert(result);
                }
            });
        } else {
            return false;
        }
    }

    function getvoucherdetail(voucherId){
        $.ajax({type: "GET",
            url: "<?= Url::toRoute('dmvouchercampaign/getvoucherdetail')?>",
            data: { id: voucherId },
            beforeSend: function() {
                //that.$element is a variable that stores the element the plugin was called on
                $("#box_id").addClass("fb-grid-loading");
            },
            success:function(result){
                $("#box_id").removeClass("fb-grid-loading");
                $('#modal').modal('show').find('#detailCampain').load($(this).attr('value'));
                $("#detailCampain").html(result);
                //alert(result);
            }
        });
    }
</script>
