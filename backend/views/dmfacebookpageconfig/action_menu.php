<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmvoucherlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu con';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
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
?>
<div id="menu-content-children">
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


<script>
    var parentId =  '<?= $prarentId; ?>';
function getData(subId){
    $.ajax({type: "GET",
        url: "<?= Url::toRoute('dmfacebookpageconfig/updatemenu')?>",
        data: { id : parentId , subId : subId },
        beforeSend: function() {
            //that.$element is a variable that stores the element the plugin was called on
            $("#menu-content-children").addClass("fb-grid-loading");
        },
        complete: function() {
            //$("#modalButton").removeClass("loading");
            $("#menu-content-children").removeClass("fb-grid-loading");
        },

        success:function(result){
            $(".modal-body").html(result);
        }
    });
}

</script>

<!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
