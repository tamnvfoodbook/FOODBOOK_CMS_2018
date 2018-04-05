<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmitemSearch */
/* @var $allPosMap backend\controllers\DmitemController */
/* @var $itemTypeMasterMap backend\controllers\DmitemController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Món ăn mới cập nhật';
$this->params['breadcrumbs'][] = $this->title;
?>
<BR>

<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    //'ID',
    [
        'attribute' => 'POS_ID',
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
    [
        'attribute' => 'pos',
        'value' => 'pos.IS_POS_MOBILE',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> [1 => 'POS MOBILE', 0 => 'POS'],
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn loại nhà hàng',
            'class' =>'select2-filter-city' // Set width của filter
        ],
        'label' => 'Loại nhà hàng'
    ],
    //'ITEM_ID',
    //'ITEM_TYPE_ID',
    'ITEM_NAME',
    'OTS_PRICE',
    // 'ITEM_MASTER_ID',
    [
        'attribute' => 'ITEM_TYPE_MASTER_ID',
        'value' => 'itemtypemaster.ITEM_TYPE_MASTER_NAME',

        'filterType'=> GridView::FILTER_SELECT2,

        'filter'=> $itemTypeMasterMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn loại',
            'class' =>'select2-filter' // Set width của filter

        ],

    ],


    [
        'attribute' => 'ITEM_IMAGE_PATH_THUMB',
        'value' => 'ITEM_IMAGE_PATH_THUMB',
        'format' => ['image',['width'=>'50','height'=>'50']],
    ],
    [
        'attribute' => 'ITEM_IMAGE_PATH',
        'value' => 'ITEM_IMAGE_PATH',
        'format' => ['image',['width'=>'50','height'=>'50']],
    ],
    // 'ITEM_IMAGE_PATH',
    // 'DESCRIPTION:ntext',
//     'TA_PRICE',
    // 'POINT',
    // 'IS_GIFT',
    // 'SHOW_ON_WEB',
    // 'SHOW_PRICE_ON_WEB',
    //'ACTIVE',
    // 'SPECIAL_TYPE',
    // 'LAST_UPDATED',
    // 'FB_IMAGE_PATH',
    // 'FB_IMAGE_PATH_THUMB',
    // 'ALLOW_TAKE_AWAY',
    // 'IS_EAT_WITH',
    // 'REQUIRE_EAT_WITH',
    'ITEM_ID_EAT_WITH',
    // 'IS_FEATURED',
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template'=>'{update}'
//            ],
    [
        'class' => 'yii\grid\CheckboxColumn',
    ],
];
?>

<?=Html::beginForm(['dmitem/setactive'],'post');?>
    <div style="float: right" class="col-lg-2">

        <div style="width: 70%; float: left;">
            <?= Html::dropDownList('set_value',NULL,[0 => 'Dective',1 => 'Active',2=>'Pending'],['class' => 'form-control'])?>
        </div>

        <div style="width: 10%;float: left;margin-left: 10%">
            <input type="submit" class="btn btn-info"  value="Set">
        </div>
    </div>



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
    'toolbar' => [
        //'{export}',
//        ['content'=>
//            Html::a('Create', ['create'], ['class' => 'btn btn-success'])
//        ],
    ]
]);
?>

<?= Html::hiddenInput('checkupdate_page',1)?>
<?= Html::endForm();?>