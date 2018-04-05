<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\PmpurchaseSearch */
/* @var $form yii\widgets\ActiveForm */

?>


<?php $form = ActiveForm::begin([
    'method' => 'get',
    'id' => 'searchTime'
]); ?>

<!-- START PROGRESS BARS -->
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid ">
            <div class="box-header with-border">
                <h3 class="box-title">Công cụ lọc</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <!--<div class="col-md-3">
                    <?/*= $form->field($model, 'VOUCHER_CODE')->textInput();
                    */?>
                </div>-->

                <div class="col-md-3">
                    <?= $form->field($model, 'VOUCHER_CAMPAIGN_ID')->widget(Select2::classname(), [
                        'data' => $allCampaginMap,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Chọn..'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>

                <!--<div class="col-md-2">
                    <?/*= $form->field($model, 'STATUS')->widget(Select2::classname(), [
                        'data' => Yii::$app->params['VOUCHER_LOG_STATUS'],
                        'language' => 'en',
                        'options' => ['placeholder' => 'Chọn..'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    */?>
                </div>-->

                <div class="col-md-2">
                    <?= $form->field($model, "USED_DATE")->checkbox(['label' => false])->label('Sử dụng cùng ngày'); ?>
                </div>


                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">Lọc báo cáo</button>
                    </div>
                </div>

            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div><!-- /.row -->
<!-- END PROGRESS BARS -->


<?php ActiveForm::end(); ?>

<script>
    $(document).ready(function() {

        $.fn.ajaxData = function() {
            //('#searchTime').submit();
            $("#searchTime").submit();
//            $.ajax({type: "GET",
//                url: "<?//= Url::toRoute('/saleposmobile/purchaseorder/')?>//",
//                data: {dateTime: $("#reservation").val(), checkAjax : 1,id : '<?//= @$id?>//'},
//
//                beforeSend: function() {
//                    //that.$element is a variable that stores the element the plugin was called on
//                    $("#table-body").addClass("fb-grid-loading");
//                },
//                complete: function() {
//                    //$("#modalButton").removeClass("loading");
//                    $("#table-body").removeClass("fb-grid-loading");
//                },
//
//                success:function(result){
//                    $("#table-body").html(result);
//                }
//            });
        }

    });
</script>
