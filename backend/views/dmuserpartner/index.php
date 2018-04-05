<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmuserpartnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tài khoản đối tác';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    'ID',
    'PARTNER_NAME',
    'AUTH_KEY',
    'ACCESS_TOKEN',
    'ACTIVE',
     'IS_SEND_SMS',
    // 'LIST_POS_PARENT',
     'BRAND_NAME',
    // 'SMS_PARTNER',
    // 'API_KEY',
    // 'SECRET_KEY',
    // 'RESPONSE_URL:url',
    ['class' => 'yii\grid\ActionColumn'],
];

?>
<div class="dmuserpartner-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,

        'panel' => [
            'type' => GridView::TYPE_SUCCESS,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> '.$this->title.'</h3>',
        ],
        'toolbar' => [
            //'{export}',
            ['content'=>
                Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success'])
            ],
        ]
    ]);
    ?>

</div>
