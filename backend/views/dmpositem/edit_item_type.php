<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\editable\Editable;

/* @var $itemTypeMasterMap backend\controllers\DmpositemController */

//$this->title = 'Danh mục  nhóm món ăn '.$model->POS_NAME;
$this->title = 'Danh mục  nhóm món ăn ';
$this->params['breadcrumbs'][] = ['label' => 'Nhà hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//echo '<pre>';
//var_dump($itemTypeMasterMap);
//echo '</pre>';
//die();

?>
<br>
<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'item_type_id',
    'item_type_name',
    'last_updated',
    'active',
//    'MAX_ITEM_CHOICE',
//    'SORT',
//    'ACTIVE',
    /*[
        'attribute' => 'id',
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function ($data){

//            echo '<pre>';
//            var_dump($data);
//            echo '</pre>';
//            die();

            return Html::a('Sửa', ['edittiemtype','id' => $data->ID,'pos_id' => $data->POS_ID ], ['class' => 'btn btn-primary']);
        },

        'label' => 'Loại món'
    ],*/

];


?>

<?php $fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'pjaxContainerId' => 'kv-pjax-container',

    //'dataProvider' => $dataProvider,
    //'columns' => $gridColumns/
]);
?>



<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
//    'pjax' => true,
//    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],
    'toolbar' => [
        ['content'=>
            Html::a('Tạo nhóm mới', ['createtypelala','POS_ID' => $pos_id], ['class' => 'btn btn-success'])
        ],
        //'{export}',
        '{toggleData}',
        '{export}',
        //$fullExportMenu,
    ]
]);
?>

