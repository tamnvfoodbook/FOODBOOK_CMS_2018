<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyC3dpfQQg9YAinYUz8ifmVHlous9WGiD6s&libraries=places', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/orderonlinemap.js', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $model backend\models\Orderonlinelog */
/* @var $form yii\widgets\ActiveForm */

?>

<BR>
<?php $form = ActiveForm::begin(); ?>
<div  class="grid-view" data-width="100%">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"></h3>
            <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Lấy địa chỉ cho đơn hàng : <?= $model->user_phone?></h3>
            <div class="clearfix"></div>
        </div>

        <div class="rc-handle-container"></div><div class="table-responsive kv-grid-container" id="w0-container">
            <div style="margin-top: 2%">
                <div class="col-md-8">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Bản đồ</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <input id="pac-input" class="controls" type="text" placeholder="Gõ địa chỉ tìm kiếm..."  name="mapAdress">
                            <div id="map-canvas" style="float: left"></div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>

                <div class="col-md-4">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin vị trí</h3>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <div class="clearfix">
                            <label>Nhà hàng</label>
                            <?= Html::textInput('adressFirst',$pos['POS_NAME'],
                                [
                                    'class' => 'form-control readonly',
                                    'readonly' => true,
                                ]
                            )?>
                            <br>
                            <label>Tên khách hàng</label>
                            <?= Html::textInput('adressFirst',$model->username,
                                [
                                    'class' => 'form-control readonly',
                                    'readonly' => true,
                                ]
                            )?>
                            <br/>
                            <?= $form->field($model, 'to_address') ?>
                            <label>Lat</label>
                            <input type="text" id="latitude" name="newLatAdress" placeholder="Latitude" class="form-control"/>
                            <?= Html::hiddenInput('possion_pos',$pos['POS_LATITUDE'].'-'.$pos['POS_LONGITUDE'],['id' => 'possion_pos'])?>
                            <label>Long</label>
                            <input type="text" id="longitude" name="newLongAdress" placeholder="Longitude" class="form-control"/>
                            <label>Khoảng cách</label>
                            <input type="text" id="distance" placeholder="Distance" class="form-control"/>

                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>

            </div>
        </div>
        <div class="kv-panel-after"></div>
        <div class="panel-footer pull-right">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<script>
    var getPosPossion = function() {
        possionPos = document.getElementById("possion_pos").value;
        if(possionPos){
            var arrayPos = possionPos.split('-');
        }
        return arrayPos; // returns the distance in meter
    };
</script>

