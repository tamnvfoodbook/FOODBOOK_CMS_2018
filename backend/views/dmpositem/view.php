<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

/* @var $itemTypeMasterMap backend\controllers\DmpositemController */

$this->title = 'Danh mục món ăn '.$model->POS_NAME;
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
    //'ID',

    'ITEM_ID',
    [
        'attribute' => 'ITEM_TYPE_ID',
        'value' => 'itemtype.ITEM_TYPE_NAME',

        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> $itemTypeMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn loại',
            'class' =>'select2-filter' // Set width của filter

        ],
    ],
    //'ITEM_TYPE_ID',

    'ITEM_NAME',
    // 'ITEM_MASTER_ID',
    //'ITEM_TYPE_MASTER_ID',
    /*[
        'attribute' => 'ITEM_TYPE_MASTER_ID',
        'value' => 'itemtypemaster.ITEM_TYPE_MASTER_NAME',
        'label' => 'Loại món ăn FB',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> $itemTypeMasterMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn loại',
            'class' =>'select2-filter-city' // Set width của filter

        ],

    ],*/
    [
        'attribute' => 'ITEM_ID_EAT_WITH',
        'value' => 'itemeatwith',
    ],
    //'ITEM_ID_EAT_WITH',

//            [
//                'attribute' => 'ITEM_ID_EAT_WITH',
//                'value'=> function () {
//                    $data = ['1' => 'Hà Nội','2' => 'Thành phố Hồ chí minh'];
//                    //echo '<label>Province</label><br>';
//                    return Editable::widget([
//                        'name'=>'province',
//                        'asPopover' => true,
//                        'header' => 'Province',
//                        'format' => Editable::FORMAT_BUTTON,
//                        'inputType' => Editable::INPUT_DROPDOWN_LIST,
//                        'data'=>$data, // any list of values
//                        'options' => ['class'=>'form-control', 'prompt'=>'Select province...'],
//                        'editableValueOptions'=>['class'=>'text-danger']
//                    ]);
//                }
//            ],
    //'ITEM_IMAGE_PATH_THUMB',
    /*[
        'attribute' => 'ITEM_IMAGE_PATH_THUMB',
        'format' => ['image',['width'=>'60','height'=>'60']],
        'label' => 'Thumb',
    ],*/
    [
        'attribute' => 'ITEM_IMAGE_PATH',
        'format' => ['image',['width'=>'60','height'=>'60']],
        'label' => 'Ảnh',
    ],
    // 'zITEM_IMAGE_PATH',
//     'DESCRIPTION:ntext',
    'OTS_PRICE',
    'TA_PRICE',
    // 'POINT',
    // 'IS_GIFT',
    // 'SHOW_ON_WEB',
    // 'SHOW_PRICE_ON_WEB',
    //'ACTIVE',
    'IS_FEATURED',
    [
        'attribute' => 'ACTIVE',
        'value' => 'ACTIVE',
        'filter' => Html::activeDropDownList($searchModel, 'ACTIVE', [1=>'Active',2=> 'Pending',0=> 'Deactive'],['class'=>'form-control','prompt' => 'Chọn trạng thái']),
    ],
    // 'SPECIAL_TYPE',
    // 'LAST_UPDATED',
    // 'FB_IMAGE_PATH',
    // 'FB_IMAGE_PATH_THUMB',
    // 'ALLOW_TAKE_AWAY',
    // 'IS_EAT_WITH',
    // 'REQUIRE_EAT_WITH',

    // 'IS_FEATURED',
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template'=>'{update}'
//            ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template'=>'{update}{delete}'
    ],
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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Danh mục món ăn '.$model->POS_NAME.'</h3>',
    ],
    'toolbar' => [
        //'{export}',
        ['content'=>
            Html::a('Tạo món', ['createparentitem','POS_ID' => $model->ID], ['class' => 'btn btn-success'])
        ],
        '{toggleData}',
        '{export}',

        //$fullExportMenu,
    ]
]);
?>

