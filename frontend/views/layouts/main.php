<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="'.\yii\helpers\Url::base().'/images/logo.png" alt="Foodbook">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo '<img src="'.\yii\helpers\Url::base().'/images/separator.png" alt="Thanh chắn dọc" style="padding:10px">';
    echo '<img src="'.\yii\helpers\Url::base().'/images/logo-ipos-trang.png" alt="Ipos" style="padding:10px">';
    //echo '<img src="'.\yii\helpers\Url::base().'/images/icon-facebook.png" alt="Ipos" style="padding:10px" class="navbar-nav navbar-right">';
    $menuItems = [
        ['label' => 'Download', 'url' => ['/download']],
        //['label' => 'About', 'url' => ['/site/about']],
        //                ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    //            if (Yii::$app->user->isGuest) {
    //                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    //                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    //            } else {
    //                $menuItems[] = [
    //                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
    //                    'url' => ['/site/logout'],
    //                    'linkOptions' => ['data-method' => 'post']
    //                ];
    //            }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
<div class="main">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
