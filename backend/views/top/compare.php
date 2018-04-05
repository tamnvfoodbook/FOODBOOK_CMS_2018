<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\models\DMPOS;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('bootstrap/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/select2/select2.full.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('plugins/input-mask/jquery.inputmask.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/input-mask/jquery.inputmask.date.extensions.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/input-mask/jquery.inputmask.extensions.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('plugins/colorpicker/bootstrap-colorpicker.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/timepicker/bootstrap-timepicker.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/slimScroll/jquery.slimscroll.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/iCheck/icheck.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/fastclick/fastclick.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('dist/js/app.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('dist/js/demo.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('bootstrap/css/bootstrap.min.css',['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/iCheck/all.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/colorpicker/bootstrap-colorpicker.min.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/select2/select2.min.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/timepicker/bootstrap-timepicker.min.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('dist/css/AdminLTE.min.css',['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('dist/css/skins/_all-skins.min.css',['position' => \yii\web\View::POS_HEAD]);

$posId = \Yii::$app->session->get('pos_id_list');
$posParent = \Yii::$app->session->get('pos_parent');
$arrayPosId = (explode(',', $posId));
// Phan quyen
if ($posId == null){
    $arrayPosId = null;
    $tmparrayPosId = DMPOS::find()
        ->select(['ID','POS_NAME'])
        ->where(['POS_PARENT' => $posParent])
        ->asArray()
        ->all();
    $arrayPos = ArrayHelper::map($tmparrayPosId,'ID','POS_NAME');
}else{
    $tmparrayPosId = DMPOS::find()
        ->select(['ID','POS_NAME'])
        ->where(['ID' => $arrayPosId])
        ->asArray()
        ->all();
    $arrayPos = ArrayHelper::map($tmparrayPosId,'ID','POS_NAME');

}

?>
<div style ="min-height: auto">
<?= Html::beginForm(); ?>
    <?= Html::dropDownList('posOption','text',$arrayPos,
        ['options' =>
            [
                'class' => 'selectpicker'
            ]
    ]) ?>
        <select id="callbacks" tabindex="0" name="optionTime">
            <option value="manual">Tùy chỉnh</option>
            <option value="0D">Hôm nay</option>
            <option value="1D">Hôm qua</option>
            <option value="1W">Tuần trước</option>
            <option value="1M">Tháng trước</option>
            <option value="7D">7 ngày trước</option>
            <option value="30D">30 ngày trước</option>
        </select>
    <div class="form-group">
        <label>Phạm vi ngày :</label>
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" name="dateFrom" id="reservation" />
        </div><!-- /.input group -->
        <br/>
        <input type="checkbox" name="sosanh" id="sosanh" value="true"> So sánh <br/><br/>

        <div id="TimeAfter" class="TimeAfter" style="display:none">
            <label>So sánh với :</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" name="inputDateAfter" id="reservationAfter" />
            </div><!-- /.input group -->
        </div>
        <br/>
        <?= Html::a('Xem', '', [
            'class'=>'btn btn-primary',
            'data' => [
                'method' => 'post',
                'params' => [
                    'action' => 'createNew'
                ],
            ]
        ])?>
    </div><!-- /.form group -->
    </div>

<?= Html::endForm(); ?>

<script type="text/javascript">
    $(".select2").select2();
    //Date range picker
    $('#reservation').daterangepicker();
    $('#reservationAfter').daterangepicker();
    window.onload=function(){
        $('#callbacks')
            // You can bind to change event on original element
            .on('change', function() {
                var x = document.getElementById("callbacks").selectedIndex;
                if(document.getElementsByTagName("option")[x].value != 3){
                    document.getElementById("reservation").disabled = true;
                    document.getElementById("sosanh").disabled = true;
                }else{
                    if(document.getElementById("reservation").disabled = true){
                        document.getElementById("reservation").disabled = false;
                        document.getElementById("sosanh").disabled = false;
                    }
                }
            });
    };

    $(document).ready(function(){

        $('#sosanh').change(function(){
            if(this.checked)
                $('#TimeAfter').fadeIn('slow');
            else
                $('#TimeAfter').fadeOut('slow');

        });
    });

</script>


