<?php

use yii\helpers\Html;
use kartik\grid\GridView;

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
    'POS_PARENT',
    'NAME',
    'POS_ID',
//    'PASSWORD',
    // 'CREATED_AT',
     'PERMISTION',
    [
        'class' => 'yii\grid\ActionColumn',

    ],

];
?>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
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

