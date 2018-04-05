<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use backend\assets\AppAsset;
AppAsset::register($this);
//$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('plugins/iCheck/icheck.min.js', ['position' => \yii\web\View::POS_HEAD]);

//$this->registerCssFile('plugins/iCheck/all.css',['position' => \yii\web\View::POS_HEAD]);



/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmposparentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kết nối';
$this->params['breadcrumbs'][] = $this->title;
?>

<br>


<div class="row">
    <!-- Left col -->
    <section class="col-lg-12  ui-sortable">
        <?php $form = ActiveForm::begin([
            'id' => 'smsbrandname'
        ]); ?>
        <!-- Chat box -->
        <div class="box  box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">SMS Brand name</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>
                <label>Loại</label>
                <?= Html::dropDownList('type',null,['1' => 'Ảnh, đường dẫn','2' => 'Văn bản'], ['class' => 'form-control'] ) ?>
                <?php
                echo $form->field($model, 'name')->dropDownList(['1' => 'Ảnh, đường dẫn','2' => 'Văn bản'],['prompt'=>'Select User']);
                ?>


                <?php
                if($model->ITEM_IMAGE_PATH){
                    echo Html::hiddenInput('ITEM_IMAGE_PATH-old',$model->ITEM_IMAGE_PATH);
                    echo $form->field($model, 'ITEM_IMAGE_PATH')->widget(FileInput::classname(), [
                        'pluginOptions' =>
                            [
                                'showCaption' => false,
                                'showRemove' => false,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-primary btn-block',
                                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                'browseLabel' =>  'Select Photo',
                                'initialPreview'=>[
                                    Html::img("$model->ITEM_IMAGE_PATH", ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                                ],
                                'maxFileSize'=>260
                            ],
                        'options' =>
                            ['accept' => 'image/*'],
                    ]);
                }else{
                    echo $form->field($model, 'ITEM_IMAGE_PATH')->widget(FileInput::classname(), [
                        'pluginOptions' =>
                            [
                                'showCaption' => false,
                                'showRemove' => false,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-primary btn-block',
                                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                'browseLabel' =>  'Select Photo',
                                'maxFileSize'=>260
                            ],
                        'options' =>
                            ['accept' => 'image/*'],
                    ]);
                }
                ?>

                <br>
                <label>Link</label>
                <?= Html::dropDownList('type',null,['1' => 'Ảnh, đường dẫn','2' => 'Văn bản'], ['class' => 'form-control'] ) ?>



                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>

            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <?php ActiveForm::end(); ?>
    </section>
    <!-- End /.Left col -->
</div>
