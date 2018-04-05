<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderrateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bình luận';
$this->params['breadcrumbs'][] = $this->title;
use backend\assets\AppAsset;
AppAsset::register($this);

$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

?>
<br>
<?= $this->render('_form_calendar', [
]) ?>

<div id="orderrate-index">
    <?= $this->render('_form_report', [
        'dataProvider' => $dataProvider,
        'allPosMap' => $allPosMap
    ]) ?>
</div>
