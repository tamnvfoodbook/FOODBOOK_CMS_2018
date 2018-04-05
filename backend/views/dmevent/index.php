<?php
use yii\helpers\Html;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmeventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý sự kiện CSKH';
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Sự kiện CSKH</h3>
        <div class="box-tools pull-right">
            <!--<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>-->
            <?= Html::a('Tạo sự kiện', ['create'], ['class' => 'btn btn-success']) ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body" id="box_id">
                    <?php
                        foreach((array)$data as $value){
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <div class="box box-default box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><?= $value-> event_name?></h3>
                                        <div class="box-tools pull-right">
                                            <!--<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>-->
                                            <?php
                                                if(!$value->status){
                                                    echo '<button class="btn btn-box-tool" id="sk_<?= $value->id?>" onclick="removeEvent('.$value->id.')"><i class="fa fa-times"></i></button>';
                                                }
                                            ?>
                                        </div><!-- /.box-tools -->
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 no-padding">
                                            <h3 style="color: #35b429;font-weight: 700; margin-top: 0"><?= @$value->discount_type == 1 ? number_format(@$value->discount_amount).' đ' : (@$value->discount_extra *100 .'%');?><span style="font-size: 15px"></span></h3>
                                            <span><?= date('d-m-Y', strtotime($value->date_start)) ?></span><br><br>
                                            <span><b><?= $value->status ? "<span style='color: #35b429'>Hoàn Thành</span>": "<span style='color: #ffa12b'>Chờ thực hiện</span>" ?></b></span><br>
                                        </div>
                                        <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 no-padding">
                                            <div class="pull-right text-right">
                                                <span ><?php
                                                    if($value->max_eat_count != 99999){
                                                        echo 'Ăn từ '. $value->min_eat_count.' - '.$value->max_eat_count.' lần';
                                                    }else{
                                                        echo 'Ăn từ '. $value->min_eat_count.' - Không giới hạn';
                                                    }
                                                ?></span><br>
                                                <div style="height: 40px">
                                                    <?php
                                                    if($value->max_pay_amount != 1000000000000){
                                                        echo 'Tiêu từ '.number_format($value->min_pay_amount).'đ - '.number_format($value->max_pay_amount).'đ';
                                                    }else{
                                                        echo 'Tiêu từ '. $value->min_pay_amount.' - Không giới hạn';
                                                    }

                                                    ?>
                                                </div>
                                                <span style="color: #ffa129 "><?= '<b>'.$value->last_visit_frequency .'</b> ngày' ?></span><br>
                                                <span style="color: #ffa129"> <?= 'Tiếp cận dự kiến <b>'.$value->expected_approach .'</b> KH' ?></span><br>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="style-one" style="margin: 5px 0"></div>
                                        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 no-padding">
                                            <span>Tiếp cận thực tế</span><br>
                                            <span>Số khách tham gia</span><br>
                                            <span>Tổng doanh số</span><br>
                                            <span>Tổng giảm giá</span><br>
                                        </div>
                                        <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 ">
                                            <div class="pull-right text-right">
                                                <span><?= '<b>'.$value->practical_approach.'</b>'.' KH'?></span><br>
                                                <span><?= '<b>'.number_format(@$value->running_result->member_used_voucher).'</b>'?><?= $value->practical_approach != 0  ?  ' ('. number_format(@$value->running_result->member_used_voucher/@$value->practical_approach *100) .' %)' : '(0%)'?></span><br>
                                                <span> <?= '<b>'.number_format(@$value->running_result->total_amount) .'</b> đ' ?></span><br>
                                                <span> <?= '<b>'.number_format(@$value->running_result->discount_amount) .'</b> đ'?> <?= @$value->running_result->total_amount != 0  ?  ' ('. number_format(@$value->running_result->discount_amount/@$value->running_result->total_amount *100) .' %)' : '(0%)' ?></span><br>
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

<style>
    .style-one {
        border: 0;
        height: 1px;
        background: #333;
        background-image: linear-gradient(to right, #9c9c9c, #333, #9c9c9c);
    }

</style>

<script>
    function removeEvent(id){
        var r = confirm("Bạn có chắc chắn muốn xóa sự kiện ?");
        if(r == true) {
            $.ajax({type: "GET",
                url: "<?= Url::toRoute('dmevent/remove')?>",
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
</script>
