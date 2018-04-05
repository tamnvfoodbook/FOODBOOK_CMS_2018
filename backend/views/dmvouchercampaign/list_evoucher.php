<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmvouchercampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách mã đã được tạo';
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new \yii\data\ArrayDataProvider([
]);

$dataProvider->allModels = $data;
$dataProvider->pagination = false;
//echo '<pre>';
//var_dump($data);
//echo '</pre>';

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'voucher_code',
        'label'=>'Mã',

    ],
    [
        'attribute' => 'date_start',
        'label'=>'Ngày bắt đầu',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->date_start));
        },
    ],

    [
        'attribute' => 'date_end',
        'label'=>'Ngày kết thúc',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->date_end));
        },
    ],

    [
        'attribute' => 'date_created',
        'label'=>'Giảm giá',
        'value' => function ($model){
            return ($model->discount_type == 1) ? number_format($model-> discount_amount).'đ' : $model->discount_extra*100 .'%' ;
        },
    ],
];

?>
<br>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title">'.$this->title.'</h3>',
    ],
    'toolbar' => [

//        '{toggleData}',
        '{export}',
        //$fullExportMenu,
    ]

]);
?>
