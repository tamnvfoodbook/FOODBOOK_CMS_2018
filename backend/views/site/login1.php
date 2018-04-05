<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback1'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>
<link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>//favicon.ico" type="image/x-icon" />
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b></b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <input type="image" src="<?php echo Yii::$app->request->baseUrl; ?>/images/bannerFoodBook.jpg" alt="Foodbook-banner" style="width:95%;">
        <p class="login-box-msg">Foodbook for <b>Manager</b></p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('Số điện thoại')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('Mật khẩu')]) ?>

        <div class="row">
            <div class="col-xs-7">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <?=Html::a('Quên mật khẩu','index.php?r=usermanager/forgot')?>
            </div>
            <!-- /.col -->
            <div class="col-xs-5">
                <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>

        <?php ActiveForm::end(); ?>
        
        <!-- /.social-auth-links -->
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
