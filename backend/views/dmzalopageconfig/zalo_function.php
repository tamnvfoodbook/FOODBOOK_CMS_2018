<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\FileInput;
use kartik\sidenav\SideNav;


use backend\assets\AppAsset;
AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmposparentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kết nối';
$this->params['breadcrumbs'][] = $this->title;

?>


<br>
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6  ui-sortable">
        <?= SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => 'Chức năng',
            'items' => $items,
        ]);?>
    </section>
    <section class="col-lg-6  ui-sortable" id="content-config-form">

        <!-- Chat box -->
        <div class="box  box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Đặt hàng online</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>
                <?= $form->field($model, 'TYPE_FUNCTION')->dropDownList(['2' => 'Ảnh, đường dẫn','1' => 'Văn bản']); ?>
                <div id="type-img">
                    <?= $form->field($model, 'IMAGE_PATH')->widget(FileInput::classname(), [
                        'pluginOptions' =>
                            [
                                'showCaption' => false,
                                'showRemove' => false,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-primary btn-block',
                                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                'browseLabel' =>  'Select Photo',
                                'initialPreview'=>[
                                    Html::img("$model->IMAGE_PATH", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                                ],
                                'maxFileSize'=>260
                            ],
                        'options' =>
                            ['accept' => 'image/*'],
                    ]);
                    ?>

                    <?= $form->field($model, 'TITLE')->textInput(); ?>
                </div>
                <?= $form->field($model, 'FUNCTION_NAME')->hiddenInput()->label(false); ?>

                <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => '4']) ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Lưu' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section>
    <!-- End /.Left col -->
</div>

<style>
    #content-config-form{
        display: none;
    }
</style>

<script>

    function removeSpecialChars(str) {
        return str.replace(/\s+/g, " ");
    }

    function checktype(type){
        if(type == 1){
            $('#type-img').hide();
        }else{
            $('#type-img').show();
        }
    }

    $( document ).ready(function(){
        var data = '<?= json_encode($model->JSON_FUNCTION)?>';
        var dataClean = removeSpecialChars(data);
        var type = $('#dmzalopageconfig-type_function').val();
        checktype(type);


        $('#dmzalopageconfig-type_function').on('change', function() {
            if(this.value == 1){
                $('#type-img').hide();
            }else{
                $('#type-img').show();
            }
        });

        $('a').click(function(){
            var addressValue = $(this).attr("href");
            var dataArray = JSON.parse(dataClean);


            if(addressValue != '#'){
                var indexArray = addressValue.split('-');
                var trimmed = indexArray[0].substring(1);
                var messObj = dataArray[trimmed][indexArray[1]];
                console.log('messObj',messObj);
                $('.box-title').html(messObj.title);
                $('#dmzalopageconfig-title').val(messObj.title);
                $('#dmzalopageconfig-type_function').val(messObj.type);
                checktype(messObj.type);

                $('#dmzalopageconfig-description').val(messObj.content);
                $('#dmzalopageconfig-function_name').val(addressValue);

                $.ajax({
                    url: messObj.image,
                    type:'HEAD',
                    error:
                        function(){
                            //do something depressing
                            $('.file-preview-image').attr('src',messObj.image);
                        },
                    success:
                        function(){
                            //do something cheerful :)
                            $('.file-preview-image').attr('src','https://image.foodbook.vn/images/fb/items/thumbs/2740/2017-08-02-10_29_35_Tra-sua-tran-chau-nghe-nhan.jpg');

                        }
                });

                $("#content-config-form").show();
            }
        });
    });
</script>
