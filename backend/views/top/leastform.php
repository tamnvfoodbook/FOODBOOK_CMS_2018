<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\models\DmPosStats; 
?>

<?php

?>

<?php
$age = array("1"=>"1", "2"=>"2", "3"=>"3","4"=>"4", "5"=>"5", "6"=>"6","7"=>"7", "8"=>"8", "9"=>"9","10"=>"10");
?>

<h2>Xem Bottom</h2>

<?= Html::beginForm(); ?>

    <?= Html::dropDownList('least','text',$age) ?>

    <?= Html::a('Xem Bottom', '', [
        'data' => [
            'method' => 'post',
            'params' => [
                'action' => 'createNew'
            ]
        ]
    ])?>
<?= Html::endForm(); ?>