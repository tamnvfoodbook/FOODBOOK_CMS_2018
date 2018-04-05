<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmvoucherlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu';
$this->params['breadcrumbs'][] = $this->title;
echo '<br>';

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'title',
    [
        'label' => 'Chức năng',
        'format' => 'raw',
        'width' => '220px',
        'value' => function ($model){
            $button3 =  Html::a('Menu con', '#',
                [
                    'class' => 'btn btn-primary',
                    'onclick' => 'updateMenuChildren('.$model['id'].')',
                ]
            );

            $button2 =  '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" onclick="updateMenu('.$model['id'].')">Sửa</button>';
            if(@$model['active'] == 0){
                $button1 =  '<button type="button" class="btn btn-primary"  onclick="hideMenu('.$model['id'].')">Hiện</button>';
            }else{
                $button1 =  '<button type="button" class="btn btn-danger"  onclick="hideMenu('.$model['id'].')">Ẩn</button>';
            }

            return $button3.' '.$button2.' '.$button1;
        }
    ],
];

?>
<div class="col-md-6" id="menu-content">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
        //'pjax' => true,
        //'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'columns' => $gridColumns,
        'panel' => [
            'type' => GridView::TYPE_SUCCESS,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
        ],
        'toolbar' => [
        ]
    ]);
    ?>
</div>


<div  class="col-md-6" id="data-edit">
    <?php
    if($parentId != null){
        $girlChildrenColum = [
            ['class' => 'kartik\grid\SerialColumn'],
            'title',
            'payload',
            [
                'label' => 'Chức năng',
                'format' => 'raw',
                'width' => '200px',
                'value' => function ($model){

                    if(@$model['active'] == 0){
                        $button2 =  '<button type="button" class="btn btn-primary"  onclick="hideChildren('.$model['id'].')">Hiện</button>';
                    }else{
                        $button2 =  '<button type="button" class="btn btn-danger"  onclick="hideChildren('.$model['id'].')">Ẩn</button>';
                    }

                    $button1 =  '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" onclick="getData('.$model['id'].')">Sửa</button>';
                    $button3 =  Html::a('Xóa', 'index.php?r=dmfacebookpageconfig/submenu&id='.$model['id'],
                        [
                            'class' => 'btn btn-danger',
                        ]
                    );
                    return $button1.' '.$button3.' '.$button2;
                }
            ],
        ];

        echo GridView::widget([
            'dataProvider' => $dataProviderChildren,
//    'filterModel' => $searchModel,
            //'pjax' => true,
            //'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
            'columns' => $girlChildrenColum,
            'panel' => [
                'type' => GridView::TYPE_SUCCESS,
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Menu con</h3>',
            ],
            'toolbar' => [
            ]
        ]);
    }
    ?>
</div>


<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sửa</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>



<script>
function updateMenuChildren(id){
    $.ajax({type: "GET",
        url: "<?= Url::toRoute('dmfacebookpageconfig/updatemenu')?>",
        data: { id : id },

        beforeSend: function() {
            //that.$element is a variable that stores the element the plugin was called on
            $("#menu-content").addClass("fb-grid-loading");
        },
        complete: function() {
            //$("#modalButton").removeClass("loading");
            $("#menu-content").removeClass("fb-grid-loading");
        },

        success:function(result){
            $("#data-edit").html(result);
        }
    });
}


function updateMenu(id){
    $.ajax({type: "GET",
        url: "<?= Url::toRoute('dmfacebookpageconfig/update')?>",
        data: { id : id },

        beforeSend: function() {
            //that.$element is a variable that stores the element the plugin was called on
            $("#menu-content").addClass("fb-grid-loading");
        },
        complete: function() {
            //$("#modalButton").removeClass("loading");
            $("#menu-content").removeClass("fb-grid-loading");
        },

        success:function(result){
            $(".modal-body").html(result);
        }
    });
}

function hideMenu(id){
    $.ajax({type: "GET",
        url: "<?= Url::toRoute('dmfacebookpageconfig/hide')?>",
        data: { id : id },

        beforeSend: function() {
            //that.$element is a variable that stores the element the plugin was called on
            $("#menu-content").addClass("fb-grid-loading");
        },
        complete: function() {
            //$("#modalButton").removeClass("loading");
            $("#menu-content").removeClass("fb-grid-loading");
        },

        success:function(result){
            $(".modal-body").html(result);
        }
    });
}

var parentId = '<?= $parentId ?>';
function hideChildren(id){
    console.log(parentId);
    $.ajax({type: "GET",
        url: "<?= Url::toRoute('dmfacebookpageconfig/hidechil')?>",
        data: { id : id , parentId : parentId },

        beforeSend: function() {
            //that.$element is a variable that stores the element the plugin was called on
            $("#menu-content").addClass("fb-grid-loading");
        },
        complete: function() {
            //$("#modalButton").removeClass("loading");
            $("#menu-content").removeClass("fb-grid-loading");
        },

        success:function(result){
            $(".modal-body").html(result);
        }
    });
}

</script>
