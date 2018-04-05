<?php
use kartik\tabs\TabsX;
use yii\helpers\Url;

/* @var $searchModel backend\controllers\SaleposmobileController */
/* @var $dataAllPosMap backend\controllers\SaleposmobileController */
/* @var $menus backend\controllers\SaleposmobileController */
//echo '<pre>';
//var_dump($menus);
//echo '</pre>';
//die();



$items = [
    [
        'label'=>'<i class="glyphicon glyphicon-home"></i> '.Yii::t('backend','All pos'),
        'content'=> $this->render('allpos',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'data' => $data,
                'dateStartDay' => $dateStartDay,
                'today' => $today,
                'yesterday' => $yesterday,
                'allDayToChart' => $allDayToChart,
            ]),
        'active'=>true,
        'linkOptions'=>['data-url'=>Url::to(['/saleposmobile/tabs-data'])]
    ],

    [
        'label'=>'<i class="glyphicon glyphicon-list-alt"></i> One Pos',
        'items'=>$menus,
    ],
];
// Ajax Tabs Above
echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false
]);