<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use backend\models\Dmpos;
use backend\models\Dmposparent;

/* @var $this \yii\web\View */
/* @var $content string */
?>
<header class="main-header">

    <?= Html::a('<span class="logo-mini">FB</span><span class="logo-lg"><input type="image" src="'.Yii::$app->request->baseUrl.'/images/logo.png" alt="Foodbook-logo" ></span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div style="text-align: right; padding-top: 2%;">
        </div>
    </nav>
</header>
