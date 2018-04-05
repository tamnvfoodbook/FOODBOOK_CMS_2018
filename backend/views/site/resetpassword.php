<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\label\LabelInPlace;
use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('css/site.css', ['position' => \yii\web\View::POS_HEAD]);


$this->title = 'Thông tin lấy lại mật khẩu';
?>
<link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>//favicon.ico" type="image/x-icon" />

<div class="col-md-6 col-sm-6 col-lg-6 col-md-offset-2 col-sm-offset-3 col-lg-offset-3" >
    <div class="box1 col-md-8  col-lg-6 col-sm-12" id="resetContent">
        <div id="header">
            <div>Thông tin lấy lại mật khẩu</div>
        </div>
        <?php $form = ActiveForm::begin(['id' => 'resetpass-form', 'enableClientValidation' => false,
            'fieldConfig' => [
                //'template' => "{input}<span class='highlight'></span><span class='bar'></span>{error}",
                'template' => "{input}{error}",

            ],
        ]); ?>
        <div class="input-login-form">
            <?= $form->field($model, 'POS_PARENT')->widget(LabelInPlace::classname(),[
                'options' => ['class'=>'fb-input input_posparent' , 'required' =>true]
            ]);
            ?>
            <?=
            $form->field($model, 'USERNAME')->widget(LabelInPlace::classname(),[
                //'type' => LabelInPlace::TYPE_HTML5,
                'options' => ['class'=>'fb-input','required' =>true]
            ]);
            ?>
            <?= $form->field($model, 'EMAIL')->widget(LabelInPlace::classname(),[
                'options' => ['class'=>'fb-input', 'required' =>true]
            ]);
            ?>
        </div>
        <button id="buttonlogintoregister" type="submit">Nhận mã xác thực</button>
        <p class="footer-text">Bạn đã có tài khoản ?<?=Html::a('Đăng nhập ','index.php',['class'=> 'sign-up'])?> </p>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-4 col-sm-6 col-lg-6 hidden-xs hidden-sm right-panel">
        <img src="<?php echo Yii::$app->request->baseUrl; ?>images/panel-right.png"/>
    </div>
</div>


<style>

    /* BOX LOGIN */

    @media screen and (device-aspect-ratio: 2/3) {}

    .box1{
        background: #fff none repeat scroll 0 0;
        border-radius: 10px;
        border-top: 0 none;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
        color: #666;
        min-height: 260px;
        min-width: 220px;
        max-width: 420px;
        margin: 15% auto;
    }



    .box1 button{
        background: #00aa46;
        border:0;
        color: #fff;
        padding:10px;
        font-size: 16px;
        font-weight: 300;
        width:95%;
        margin:20px auto;
        display:block;
        cursor:pointer;
        -webkit-transition: all 0.4s;
        transition: all 0.4s;
        border-radius: 4px;
    }

    .box1 button:active{
        background: #00aa46;
        color: #263238;
    }

    .box1 button:hover{
        background: #00aa46;
        color: #FFF;
        -webkit-transition: all 0.4s;
        transition: all 0.4s;
    }

    .box1 p{
        font-size:14px;
        text-align:center;
    }

    .right-panel{
        margin-top: 15%;
    }

    #header {
        font-size: 150%;
        text-align: center;
        padding: 25px 0;
    }
    .footer-text{
        padding: 5px 0;
    }

    .sign-up{
        color: #00aa46;
        cursor: pointer;
    }

    .sign-up:hover{
        color: #b2dfdb;
    }


    a:link, a:visited{
        text-decoration: none;
    }

    .input-login-form{
        width: 95%;
        margin: 0 auto;
    }

    .fb-input{
        width: 100%;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        color: #555;
        display: block;
        font-size: 14px;
        height: 44px;
        line-height: 1.42857;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    }

    .input_posparent{
        text-transform: uppercase;
    }

</style>


<script>
    $(document).ready(function () {
        $("#resetpass-form").on("beforeSubmit", function (event, messages) {
            var form = $(this);
            // return false if form still have some validation errors
//            if (form.find('.has-error').length) {
//                return false;
//            }
            // submit form
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),

                beforeSend: function() {
                    //that.$element is a variable that stores the element the plugin was called on
                    $("#resetContent").addClass("fb-grid-loading");
                },

                success: function (response) {
                    console.log(response);
                    $("#resetContent").removeClass("fb-grid-loading");
                    if(response == 300){
                        //form.yiiActiveForm('updateAttribute', 'user-auth_key', ["I have an error..."]);
                        $('.field-user-email').addClass('has-error');
                        $('.field-user-email .help-block').html('Thương hiệu, tài khoản hoặc email không đúng, vui lòng kiểm tra lại');
                        return false;
                    }

                   /* if(response == 1405){
                        $('.field-user-pos_parent').addClass('has-error');
                        $('.field-user-pos_parent').removeClass('has-success');
                        $('.field-user-pos_parent .help-block').html('Thương hiệu đã tồn tại');
                        return false;
                    }if(response == 301){
                        $('.field-user-email').addClass('has-error');
                        $('.field-user-email').removeClass('has-success');
                        $('.field-user-email .help-block').html('Email đã gửi yêu cầu quá nhiều lần');
                        return false;
                    }*/

                    $("#resetContent").removeClass("fb-grid-loading");
                    // do something with response
                }
            });
            return false;
        });
    });
</script>