<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PmemployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nhân viên';
$this->params['breadcrumbs'][] = $this->title;
?>

<BR>

<?php
$gridColumns = [

    ['class' => 'yii\grid\SerialColumn'],

    //'ID',
    //'POS_PARENT',
    [
        'attribute' => 'POS_ID',
        'width'=>'300px',
        'value' => 'pos.POS_NAME',
        'group' => true,

        //'filterType'=> '\kartik\widgets\Select2',
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
    'NAME',
    [
        'attribute' => 'PERMISTION',
        'value' => 'permis',
        'width'=>'260px',
        'format' => 'raw'
    ],
//    [
//        'value' => 'resetpassword',
//        'width'=>'150px',
//        'format' => 'raw',
//        'label' => 'Đặt lại mật khẩu'
//    ],
//    'PASSWORD',
    // 'CREATED_AT',
     //'PERMISTION',


    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Thao tác',
        'template' => '{view}'
    ],

];
?>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> '.$this->title.'</h3>',
    ],
    'toolbar' => [
        [
            'content'=>
                Html::a('Tạo nhân viên', ['create'], ['class' => 'btn btn-success']),
        ],
//        '{toggleData}',
//        '{export}',

        //$fullExportMenu,
    ]
]);
?>

