<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
//use yii\widgets\Pjax;
use yii\helpers\Url;

use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/moment.min.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerJsFile('plugins/timepicker/bootstrap-timepicker.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('plugins/daterangepicker/daterangepicker.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('plugins/timepicker/bootstrap-timepicker.min.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('plugins/daterangepicker/daterangepicker-bs3.css', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderonlinelogSearch */
/* @var $allPosMap backend\controllers\OrderonlinelogController */
/* @var $dateRanger backend\controllers\OrderonlinelogController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thống kê đơn hàng';
$this->params['breadcrumbs'][] = $this->title;

//echo '<pre>';
//var_dump($allPosMap);
//echo '</pre>';
//die();

?>
<br>
<div>
<?= $this->render('_form_calendar_reportall', [
    'model' => $searchModel,
    'dateRanger' => $dateRanger,
    ])?>
</div>
<div id="report_content">
    <?= $this->render('reportall_form', [
        'allPosMap' => $allPosMap,
        'dataProvider' => $dataProvider,
    ])?>
</div>
