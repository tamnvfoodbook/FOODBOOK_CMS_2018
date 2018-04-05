<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmpositemSearch */
/* @var $allPosMap backend\controllers\DmpositemController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Báo cáo khách hàng';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    'ID',
    'MEMBER_NAME',
    //'MEMBER_IMAGE_PATH',
    /*[
        'attribute' => 'MEMBER_IMAGE_PATH',
        'format' => ['image',['width'=>'80','height'=>'60']],
    ],*/
//    'ACTIVE',
    //'HASH_PASSWORD',
//    'FACEBOOK_ID',
//    'PHONE_NUMBER',
    'EMAIL:email',
    // 'CREATED_AT',
    // 'LAST_UPDATED',

    [
        'attribute' => 'CITY_ID',
//        'value' => 'city.CITY_NAME',
        'value' => function ($model) use($allCityMap){
            return @$allCityMap[$model->CITY_ID];
        },

        //'label' => 'Thành phố',
        'width' => '150px',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> $allCityMap,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn thành phố',
            'class' =>'select2-filter-city' // Set width của filter
        ],
    ],

    [
        'attribute' => 'USER_GROUPS',
//        'value' => 'city.CITY_NAME',
        'value' => function ($model) use($groupMember){
            return @$groupMember[$model->USER_GROUPS];
        },
        //'label' => 'Thành phố',
        'width' => '150px',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> $groupMember,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn nhóm...',
            'class' =>'select2-filter-status' // Set width của filter
        ],
    ],

    [
        'attribute' => 'SEX',
        'value' => function ($model){
            $sexArr = ['-1' =>  'Chưa xác định','0' => "Nữ", '1' => 'Nam'];
            return @$sexArr[$model->SEX];
        },
//        'value' => 'city.CITY_NAME',
        //'label' => 'Thành phố',
        'width' => '150px',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> ['-1' =>  'Chưa xác định','0' => "Nữ", '1' => 'Nam'],
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Giới tính...',
            'class' =>'select2-filter-city' // Set width của filter
        ],
    ],

    [
        'attribute' => 'BIRTHDAY',
        'value' => function ($model){
            if(isset($model->BIRTHDAY)){
                return date('d-m-Y',strtotime(@$model->BIRTHDAY));
            }
        },
//        'value' => 'city.CITY_NAME',
        'label' => 'Sinh nhật',
        'width' => '150px',
        'filterType'=> GridView::FILTER_SELECT2,
        'filter'=> [
            '1' => "Sinh tháng 1",
            '2' => 'Sinh tháng 2',
            '3' => "Sinh tháng 3",
            '4' => 'Sinh tháng 4',
            '5' => "Sinh tháng 5",
            '6' => 'Sinh tháng 6',
            '7' => "Sinh tháng 7",
            '8' => 'Sinh tháng 8',
            '9' => 'Sinh tháng 9',
            '10' => "Sinh tháng 10",
            '11' => 'Sinh tháng 11',
            '12' => "Sinh tháng 12",
        ],
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>[
            'placeholder'=>'Chọn tháng sinh...',
            'class' =>'select2-filter-city' // Set width của filter
        ],
    ],

    //'SEX',
    //'BIRTHDAY',
//    'CREATED_BY',

    ['class' => 'yii\grid\ActionColumn',
        'template'=>'{view}'
    ],
];

?>
<br>

<!--<div>
    <?/*= $this->render('_search_report', [
        'model' => $searchModel,
        'allCityMap' => $allCityMap,
        'userMap' => $userMap,
        'allDistrictMap' => $allDistrictMap,
        'allSourceMap' => $allSourceMap,
    ])*/?>
</div>
-->


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
    ],

    'toolbar' => [
        '{toggleData}',
        '{export}',
        /*['content'=>
            Html::a('Đặt lại dữ liệu', ['create'], ['class' => 'btn btn-danger'])
        ],*/
    ]
]);
?>
