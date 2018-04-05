<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmnoticeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thông báo';
$this->params['breadcrumbs'][] = $this->title;


$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'title',
    'content',
//    'pos_parent',
    [
        'label' => 'Nhà hàng áp dụng',
        'value' => function ($model) use($allPosMap ){
            if(@$model->is_all_pos){
                return 'Toàn hệ thống';
            }else{
                $listPos = '';
                $posArray = explode(',',$model->list_pos);
                foreach($posArray as $item){
                    if($item){
                        if($listPos){
                            $listPos = $listPos .','.$allPosMap[$item];
                        }else{
                            $listPos = $allPosMap[$item];
                        }
                    }

                }
               /* echo '<pre>';
                var_dump($posArray);
                echo '</pre>';
                die();*/
                return $listPos;
            }
        },
    ],
    [
        'attribute' => 'created_at',
        'label' => 'Ngày tạo',
        'value' => function ($model) {
            if(@$model->created_at){
                return date(Yii::$app->params['DATE_TIME_FORMAT'],strtotime($model->created_at));
            }
        },
    ],

    [
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'headerOptions' => ['style'=>'color:#3c8dbc'],
        'value' => function ($data){
            return Html::a('Sửa', ['update','id' => $data->id ], ['class' => 'btn btn-primary']).' '.Html::a('Gửi', ['push','id' => $data->id ], [
                'class' => 'btn btn-success',
                'data' => [
                'confirm' => Yii::t('backend', 'Bạn có chắc chắn muốn gửi thông báo ?'),
            ],
            ]);
        },
        'label' => 'Thao tác'
    ],
];

?>

<br>

<?php $fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    //'pjaxContainerId' => 'kv-pjax-container',
    'dropdownOptions' => [
        'label' => 'Export Full',
        'class' => 'btn btn-default',
        'itemsBefore' => [
            '<li class="dropdown-header">Export All Data</li>',
        ],
    ],
]);
?>

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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Nhà hàng</h3>',
    ],
    'toolbar' => [
        //'{export}',
        $fullExportMenu,
        ['content'=>
            Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success'])
        ],
    ]
]);
?>
