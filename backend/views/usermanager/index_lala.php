<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tài khoản chi nhánh';
$this->params['breadcrumbs'][] = $this->title;


$typeAcc = \Yii::$app->session->get('type_acc');
if($typeAcc == 3){
    // Truường hợp đối với các tài khoản quản lý của chinh nhánh chỉ cho phép xem bên ngoài tài khoản
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        //'id',
        //'USERNAME',
        [
            'attribute' => 'USERNAME',
            'width' => '150px',
        ],
        //'full_name',
        //'auth_key',
        //'password_hash',
        //'password_reset_token',
        'EMAIL:email',
        // 'created_at',
        // 'updated_at',
        //'pos_parrent',
        //'pos_id_list',
        [
            'attribute' => 'POS_ID_LIST',
            'format' => 'raw',
            'value' => 'idToNamePos',
        ],
        [
            'attribute' => 'ACTIVE',
            'width' => '100px',
        ],
    ];

    $girdviewConfig = [
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
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
            //'{export}',
            //$fullExportMenu,
            ['content'=>
                Html::a('Tạo mới', ['createlala'], ['class' => 'btn btn-success'])
            ],
        ]
    ];
}else{
// Truường hợp đối với các tài khoản quản lý root cho phép xem sửa xóa

    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        //'id',
        //'USERNAME',
        [
            'attribute' => 'username',
            'width' => '150px',
        ],
        //'full_name',
        //'auth_key',
        //'password_hash',
        //'password_reset_token',
        'email:email',
        // 'created_at',
        // 'updated_at',
        //'pos_parrent',
        //'pos_id_list',
       /* [
            'attribute' => 'pos_id_list',
//            'format' => 'raw',
//            'value' => 'idToNamePoslala',
        ],*/
        [
            'attribute' => 'active',
            'width' => '100px',
        ],

        [
            'format' => 'raw',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'headerOptions' => ['style'=>'color:#3c8dbc'],
            'value' => function ($data){
                return Html::a('Xem', ['viewlala','id' => $data->id ], ['class' => 'btn btn-primary']).' '.Html::a('Sửa', ['viewlala','id' => $data->id ], ['class' => 'btn btn-success']);
            },
            'label' => 'Món ăn'
        ],

    ];


    $girdviewConfig = [
        'dataProvider' => $dataProvider,
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
            //'{export}',
            //$fullExportMenu,
            ['content'=>
                Html::a('Tạo mới', ['createlala'], ['class' => 'btn btn-success'])
            ],
        ]
    ];
}

?>
<br>
<?= GridView::widget($girdviewConfig); ?>

