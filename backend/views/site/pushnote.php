<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use \yii\helpers\Url;
//use kartik\select2\Select2;
use backend\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

?>


<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::label('Nội dung') ?>
    <?= Html::textarea('noidung',null,['class' => 'form-control','placeholder'=>'Nội dung...','required' => true]) ?>

    <?= Html::label('Đường dẫn') ?>
    <?= Html::textInput('url',null,['class' => 'form-control','placeholder'=>'Nội dung...','required' => true]) ?>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Gửi', ['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!--<script type="text/javascript">
    $(".select2").select2();
</script>-->

