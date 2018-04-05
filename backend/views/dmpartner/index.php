<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modelsDmpartnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đối tác';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    //'ID',
    'PARTNER_NAME',
    'DESCRIPTION:ntext',
    //'AVATAR_IMAGE',
    [
        'attribute' => 'AVATAR_IMAGE',
        'format' => ['image',['width'=>'50','height'=>'50']],
        'headerOptions' => ['style'=>'color:#3c8dbc'],
    ],
    'ACTIVE',

    ['class' => 'yii\grid\ActionColumn'],
];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,

    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
    'toolbar' => [
        //'{export}',
        ['content'=>
            Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success'])
        ],
    ]
]);
?>
