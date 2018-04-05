<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'group'],
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>
<link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>favicon.ico" type="image/x-icon" />

<div class="box">
    <div id="header">
        <div id="cont-lock"><i class="material-icons lock">Shop</i></div>
        <div id="bottom-head"><h1 id="logintoregister">Login</h1></div>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false,
        'fieldConfig' => [
            'template' => "{input}<span class='highlight'></span><span class='bar'></span>{label}{error}",
        ],
    ]); ?>
    <div class="input-login-form">

        <?= $form
            ->field($model, 'pos_parrent', $fieldOptions1)
            ->textInput(['class' =>"inputMaterial input_posparent",'required' => ''])
        ?>
        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->textInput(['class' =>"inputMaterial", 'required' => ''])
        ?>
        <?= $form
            ->field($model, 'password', $fieldOptions1)
            ->passwordInput(['class' =>"inputMaterial", 'required' => ''])
        ?>

    </div>


    <button id="buttonlogintoregister" type="submit">Đăng nhập</button>


    <?php ActiveForm::end(); ?>
    <div id="footer-box">
        <p class="footer-text">Bạn chưa có tài khoản? <?=Html::a('Tạo tài khoản ','index.php?r=usermanager/register',['class'=> 'sign-up'])?> </p>
        <?php /*echo  $form->field($model, 'rememberMe')->checkbox() */?>

    </div>
</div>


<style>


/* BOX LOGIN */


.box{
    position: relative;
    margin: auto;
    min-height: 510px;
    top: 40px;
    left: 0;
    z-index: 200;
    right: 0;
    width:400px;
    color:#666;
    border-radius: 3px;
    background: #FFF;
    margin-bottom: 100px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
    overflow: hidden;
}

#header{
    background: #00aa46;
    position: relative;
    height: 100px;
    width: 100%;
    margin-bottom: 30px;
}

#cont-lock{
    width: 100%;
    height: 65px;
    position: relative;
}

.lock{
    text-align: center;
    color: white;
    position: absolute;
    left: 0;
    right: 0;
    margin: 0;
    top: 0;
    bottom: 0;
    line-height: 65px;
    font-size: 28px;
}

#bottom-head{
    position: relative;
    background: #00695c;
    height: 35px;
}

#bottom-head::after{
    content: '';
    width: 0px;
    height: 0px;
    display: block;
    position: absolute;
    margin: auto;
    left: 0;
    right: 0;
    bottom: 0;
    border-bottom: 7px solid white;
    border-right: 7px solid rgba(0,0,0,0);
    border-left: 7px solid rgba(0,0,0,0);
    border-top: 7px solid rgba(0,0,0,0);
}

.box h1{
    margin-left: 20px;
    margin-top: 0;
    font-size: 20px;
    font-weight: 300;
    color: #cfd8dc;
    line-height: 35px;
}

.box button{
    background: #cfd8dc;
    border:0;
    color: #00aa46;
    padding:10px;
    font-size: 16px;
    font-weight: 300;
    width:330px;
    margin:20px auto;
    display:block;
    cursor:pointer;
    -webkit-transition: all 0.4s;
    transition: all 0.4s;
    border-radius: 2px;
}

.box button:active{
    background: #00aa46;
    color: #263238;
}

.box button:hover{
    background: #00aa46;
    color: #FFF;
    -webkit-transition: all 0.4s;
    transition: all 0.4s;
}

.box p{
    font-size:14px;
    text-align:center;
}

.group 			  {
    position:relative;
    margin-bottom: 35px;
    margin-left: 40px;
}

.inputMaterial 				{
    font-size:18px;
    padding:10px 10px 10px 5px;
    display:block;
    width:100%;
    border:none;
    border-bottom:1px solid #757575;
}

.inputMaterial:focus 		{ outline:none;}

/* LABEL ======================================= */

label 				 {
    color:#999;
    font-size:14px;
    font-weight:normal;
    position:absolute;
    pointer-events:none;
    left:5px;
    top:10px;
    transition:0.2s ease all;
    -moz-transition:0.2s ease all;
    -webkit-transition:0.2s ease all;
}

/* active state */
.inputMaterial:focus ~ label, .inputMaterial:valid ~ label 		{
    top:-20px;
    font-size:10px;
    color: #00aa46;
}

/* BOTTOM BARS ================================= */
.bar 	{ position:relative; display:block; width:100%; }
.bar:before, .bar:after 	{
    content:'';
    height:2px;
    width:0;
    bottom:1px;
    position:absolute;
    background: #00aa46;
    transition:0.2s ease all;
    -moz-transition:0.2s ease all;
    -webkit-transition:0.2s ease all;
}
.bar:before {
    left:50%;
}
.bar:after {
    right:50%;
}

/* active state */
.inputMaterial:focus ~ .bar:before, .inputMaterial:focus ~ .bar:after {
    width:50%;
}


/* active state */
.inputMaterial:focus ~ .highlight {
    -webkit-animation:inputHighlighter 0.3s ease;
    -moz-animation:inputHighlighter 0.3s ease;
    animation:inputHighlighter 0.3s ease;
}

/* ANIMATIONS ================ */
@-webkit-keyframes inputHighlighter {
    from { background:#5264AE; }
    to 	{ width:0; background:transparent; }
}
@-moz-keyframes inputHighlighter {
    from { background:#5264AE; }
    to 	{ width:0; background:transparent; }
}
@keyframes inputHighlighter {
    from { background:#5264AE; }
    to 	{ width:0; background:transparent; }
}

#footer-box{
    width: 100%;
    height: 50px;
    background: #00aa46;
    position: absolute;
    bottom: 0;
}

.footer-text{
    color: #cfd8dc;
    padding-top: 15px;

}

.sign-up{
    color: white;
    cursor: pointer;
}

.sign-up:hover{
    color: #b2dfdb;
}


$transition: all 0.3s;
$shadow-L1: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
$shadow-L2: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
$shadow-L3: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);

body{
    background: #eceff1;
}

#container-a{
    border-radius: 50%;
    width: 60px;
    height: 60px;
    position: fixed;
    top: 20px;
    right: 20px;
    overflow: hidden;
    transition: $transition;
    box-shadow: $shadow-L3;

/*&:hover{
  width: 150px;
  border-radius: 50px;
  transition: $transition;
}*/

#badge{
    width: 100%;
    height: 100%;
    background-image: url("https://lh3.googleusercontent.com/-X-aQXHatDQY/Uy86XLOyEdI/AAAAAAAAAF0/TBEZvkCnLVE/w140-h140-p/fb3a11ae-1fb4-4c31-b2b9-bf0cfa835c27");
    background-size: 100%;
    transition: $transition;
    position: absolute;


&:hover .codepen{
     display: block;
 }
}

&:hover #letter{
     display: block;
 }

&:hover #badge{
     width: 150px;
     height: 150px;
     transition: $transition;
     filter: blur(7px);
 }

#letter{
    display: none;
    z-index: 20;
    width: 100%;
    height: 100%;
    position: absolute;

span{
    font-family: 'Roboto';
    font-size: 32px;
    color: white;
    text-align: center;
    line-height: 60px;
    margin: auto;
    left: 0;
    right: 0;
    position: absolute;
    cursor: pointer;
}
}
}


#container-floating{
    position: fixed;
    width: 60px;
    height: 60px;
    top: 20px;
    right: 20px;
    z-index: 50px;

&:hover{
     height: 400px;
     width: 60px;
     top: 20px;
     right: 20px;
 }

&:hover .nds{
     animation: bounce-nds 0.1s linear;
     animation-fill-mode:  forwards;
 }
&:hover .nd3{
     animation-delay: 0.08s;
 }
&:hover .nd4{
     animation-delay: 0.15s;
 }
&:hover .nd5{
     animation-delay: 0.2s;
 }

.nds{
    width: 40px;
    height: 40px;
    border-radius: 50%;
    position: fixed;
    z-index: 300;
    transform:  scale(0);
    right: 33px;
    cursor: pointer;
&:hover{
     box-shadow: $shadow-L3;
     transition: $transition;
     width: 50px;
     right: 25px;
     height: 50px;
 }
}

.nd1{
    background-image: url("http://blog.codepen.io/wp-content/uploads/2012/06/Button-Fill-Black-Large.png");
    background-size: 100%;
    top: 110px;
    animation-delay: 0.1s;
    animation: bounce-out-nds 0.3s linear;
    animation-fill-mode:  forwards;
    box-shadow: $shadow-L2;
    transition: $transition;
}

.nd3{
    background: url("https://cdn3.iconfinder.com/data/icons/free-social-icons/67/twitter_circle_color-512.png");
    background-size: 100%;
    top: 165px;
    animation-delay: 0.15s;
    animation: bounce-out-nds 0.15s linear;
    animation-fill-mode:  forwards;
    box-shadow: $shadow-L2;
    transition: $transition;
}

.nd4{
    background: url("http://www.studiotomasi.org/images/gplusicon.svg");
    background-size: 100%;
    top: 225px;
    animation-delay: 0.1s;
    animation: bounce-out-nds 0.1s linear;
    animation-fill-mode:  forwards;
    box-shadow: $shadow-L2;
    transition: $transition;
}

}


@keyframes bounce-nds{
    from {opacity: 0;}
    to {opacity: 1; transform: scale(1);}
}

@keyframes bounce-out-nds{
    from {opacity: 1; transform: scale(1);}
    to {opacity: 0; transform: scale(0);}
}


.profile-name{
    line-height: 60px;
    left: -70px;
    position: absolute;
    font-family: 'Roboto';
    color: #455a64;
}

.profile-name:hover{
    text-decoration: underline;
}

a:link, a:visited{
    text-decoration: none;
}

input:required {
    box-shadow:none;
}
.input-login-form{
    width: 365px;
}

.input_posparent{
    text-transform: uppercase;
}

</style>