<?php
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderonlinelogSearch */
/* @var $allPosMap backend\controllers\OrderonlinelogController */
/* @var $dateRanger backend\controllers\OrderonlinelogController */
/* @var $dataProvider yii\data\ActiveDataProvider */

//echo '<pre>';
//var_dump($allPosMap);
//echo '</pre>';
//die();
$this->title = 'Thống kê đơn hàng';

$gridColumns = [
    [
        'class'=>'kartik\grid\SerialColumn',
        'vAlign'=>'top'

    ],
    [
        'attribute' => 'pos_id',
        'value' => function ($model) use ($allPosMap) {
            return @$allPosMap[$model['pos_id']];
        },
        'label' => 'Nhà hàng'
    ],
    [

        'value' => function ($model){
            return number_format(@$model['CONFIRMED'] + @$model['CANCELLED']);
        },
        'label' => 'Tổng đơn hàng'
    ],
    [
        'attribute' => 'CONFIRMED',
        'format'=>['decimal',0],
        'label' => 'Đơn đã nhận'
    ],
    [
        'attribute' => 'CANCELLED',
        'value' => function ($model){
            $sum = @$model['CONFIRMED'] + @$model['CANCELLED'];
            if($sum){
                return @$model['CANCELLED'].' ('.  number_format(@$model['CANCELLED']/(@$model['CONFIRMED'] + @$model['CANCELLED']),2) *100 .' %)';
            }else{
                return @$model['CANCELLED'].' ( 0%)';
            }

        },
        'label' => 'Đơn hủy'
    ],


    [
        'attribute' => 'AMOUNT_CONFIRMED',
        'label' => 'Tổng tiền nhận',
        'format'=>['decimal',0]
    ],
    [
        'attribute' => 'AMOUNT_CANCELLED',
        'label' => 'Tổng tiền hủy',
        'format'=>['decimal',0]
    ],
    [
        'value' => function ($model){
            return number_format(@$model['AMOUNT_CONFIRMED'] + @$model['AMOUNT_CANCELLED']);
        },
        'label' => 'Tổng tiền'
    ],

];

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'showPageSummary' => true,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title">'.$this->title.'</h3>',
    ],
    'toolbar' => [
//        [
//            'content'=>
//
//        ],
        '{toggleData}',
        '{export}',
        //$fullExportMenu,
    ]
]);
?>