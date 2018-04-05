<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

use backend\assets\AppAsset;
AppAsset::register($this);

$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $model backend\models\Dmitemtype */
/* @var $form yii\widgets\ActiveForm */
?>
<br>
<div class="grid-view">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-cutlery"></i> <?= $this->title ?></h3>
        </div>

        <div class="clearfix"></div>

        <div class="rc-handle-container">
            <div class="box-body">
                <?php $form = ActiveForm::begin(

                ); ?>

                <?php
                if(!$autoGenId){
                    if($model->isNewRecord){
                        echo $form->field($model,'ITEM_TYPE_ID')->textInput(['maxlength' => true,'required' => true,'class' => 'text-uppercase form-control']);
                    }else{
                        echo $form->field($model,'ITEM_TYPE_ID')->textInput(['maxlength' => true,'required' => true,'class' => 'text-uppercase form-control','readonly' => true]);
                    }
                }

                ?>

                <?= $form->field($model, 'ITEM_TYPE_NAME')->textInput(['maxlength' => true]) ?>



                <?= $form->field($model, 'ACTIVE')->dropDownList([1=> "Active", 0 => 'Deactive']) ?>

                <?= Html::checkbox('sync',false, ['id' => 'syncCheckBtn']) ?>  Đồng bộ sang các điểm khác

                <?php
                Modal::begin([
                    'header' => '<h4>Chọn nhà hàng</h4>',
                    'id' => 'modal',
                    'size' => 'modal-lg',
                    'footer' => Html::button('Chọn xong',['class' => 'btn btn-success','data-dismiss' => "modal",'id'=> 'process']),
                ]);
                ?>
                <div id="modalContent">
                    <?= $this->render('sync', [
                        'allPos' => $allPos,
                        'model' => $model,
                        'POS_ID' => $POS_ID
                    ]) ?>
                </div>
                <?php Modal::end();?>
                <br/>
                <br/>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Lưu' : 'Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div><!-- /.box-body -->
        </div>
    </div>

<script>
    // Script Popup Rating
    $(function(){
        $("#syncCheckBtn").click(function (e) {
            if ($(this).is(':checked')) {
                /*$('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));*/
                //e.preventDefault();
                $('#modal').modal('show').find('#modalContent')
                    .load($(this).attr('href'));
            }
        });
    });
</script>
