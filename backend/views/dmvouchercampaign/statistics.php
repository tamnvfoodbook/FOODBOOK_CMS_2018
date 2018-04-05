<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmvouchercampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý loại voucher';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'id',
    [
        'attribute' => 'date_created',
        'label'=>'Ngày tạo',
        'width' => '95px',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->date_created));
        },
    ],
//    [
//        'attribute' => 'date_created',
//        'label'=>'Ngày tạo',
//    ],
    [
        'attribute' => 'voucher_campaign_name',
        'label'=>'Tên loại Voucher',
    ],

    [
        'attribute' => 'date_created',
        'label'=>'Giảm giá',
        'value' => function ($model){
//            echo '<pre>';
//            var_dump($model);
//            echo '</pre>';
//            die();
            return ($model->discount_type == 1) ? number_format($model-> discount_amount).' đ' : $model->discount_extra*100 .'%' ;
        },
    ],
    [
        'attribute' => 'campaign_type',
        'label'=>'Mục đích',
        'value' => function ($model){
            return @Yii::$app->params['campainType'][$model->campaign_type];
        },
    ],
    [
        'attribute' => 'total_voucher_log',
        'label'=>'Đã phát hành',
    ],
//    [
//        'attribute' => 'total_used',
//        'label'=>'Đã sử dụng',
//    ],

    [
        'attribute' => 'total_used',
        'format' => 'raw',
        'value' => function ($model){
            if(@$model->total_voucher_log != 0 && @$model->total_used != 0){
                $content = @$model->total_used .' ('.number_format(@$model->total_used/$model->total_voucher_log*100) .'%)</p>';
            }else{
                $content = '0';
            }

            return $content;
        },
        'label' => 'Đã sử dụng',
    ],

    [
        'attribute' => 'running_result.total_amount',
        'format' => 'raw',
        'width' => '200px',
        'value' => function ($model){
            if(@$model->total_amount_after_discount){
                $content = '<p>Trước giảm giá: '.number_format(@$model->total_used_amount).' đ</p> Sau giảm giá: '. number_format(@$model->total_amount_after_discount) .' đ ('.number_format(@$model->total_amount_after_discount/@$model->total_used_amount*100) .'%)</p>';
            }else{
                $content = '<p>Trước giảm giá: '.@$model->running_result->total_amount.' </p> Sau giảm giá: '. @$model->running_result->discount_amount.' </p>';
            }

            return $content;
        },
        'label' => 'Doanh số',
    ],
    [
        'attribute' => 'active',
        'label'=>'Trạng thái',
        'value' => function ($model){
            return ($model->active) ? 'Hoạt động' : 'Đã dừng' ;
        },
    ],
    [
        'attribute' => 'id',
        'format' => 'raw',
        'label'=>'Thao tác',
        'value' => function ($model){
            return Html::a('Xem',['view','id'=> $model->id,'total_voucher_log'=> @$model->total_voucher_log],['class' => 'btn btn-primary']).Html::a('Sửa &nbsp;',['update','id'=> $model->id,'total_voucher_log'=> @$model->total_voucher_log],['class' => 'btn btn-success']);
//            return Html::a('Xem',['view','id'=> $model->id,'total_voucher_log'=> @$model->total_voucher_log],['class' => 'btn btn-primary']);
        },
    ],

];

?>
<br>
<div>
    <?= $this->render('_search_report', [
        'model' => $searchModel,
    ])?>
</div>



<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title">'.$this->title.'</h3>',
    ],
    'toolbar' => [

        '{toggleData}',
        '{export}',
        //$fullExportMenu,
    ]

]);
?>
