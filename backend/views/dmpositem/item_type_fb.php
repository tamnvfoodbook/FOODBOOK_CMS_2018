<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmitemtypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nhóm món';
$this->params['breadcrumbs'][] = $this->title;


$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'ITEM_TYPE_ID',
    'ITEM_TYPE_NAME',
    'MAX_ITEM_CHOICE',
    'ACTIVE',
    // 'LAST_UPDATED',

    ['class' => 'yii\grid\ActionColumn',
        'template'=>'{view} {update}'
    ],
];

?>
<br>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Nhà hàng</h3>',
    ],
    'toolbar' => [

        ['content'=>
            Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success'])
        ],
        '{export}',
    ]
]);
?>
