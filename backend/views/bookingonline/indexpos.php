<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BookingonlinelogSearch */
/* @var $allPosMap backend\controllers\BookingonlineController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bookingonlinelogs';
$this->params['breadcrumbs'][] = $this->title;
?>


<BR>

<?php

$gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],

        //'_id',
        'Foodbook_Code',
        //'Pos_Id',
        [
            'attribute' => 'Pos_Id',
            'width'=>'310px',
            'value' => 'pos.POS_NAME',

            'filterType'=> GridView::FILTER_SELECT2,

            'filter'=> $allPosMap,
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>[
                'placeholder'=>'Chọn nhà hàng',
                'class' =>'select2-filter' // Set width của filter

            ],

        ],
        //'Pos_Workstation',
        'User_Id',
        //'Book_Date',

        [
            'attribute' => 'Book_Date',
            //'format'=>'ra',
            'value' => 'chagebookdate'
        ],

        'Hour',
        'Minute',
        'Number_People',
        'Note',
        'Status',
        //'Created_At',
        [
            'attribute' => 'Created_At',
            //'format'=>'ra',
            'value' => 'changeCreat'
        ],
    //            [
    //                'attribute' => 'Updated_At',
    //                //'format'=>'ra',
    //                'value' => 'changeUpdate'
    //            ],
        //'Updated_At',

        //['class' => 'yii\grid\ActionColumn'],
];
?>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'pjax' => true,
    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
    /*'toolbar' => [
        //'{export}',
        $fullExportMenu,
    ]*/
]);
?>
