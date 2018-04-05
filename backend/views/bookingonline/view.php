<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$timeFormat = Yii::$app->params['DATE_TIME_FORMAT'];

/* @var $this yii\web\View */
/* @var $model backend\models\Bookingonlinelog */

$this->title = 'Thông tin đặt bàn mã: '.$model->Foodbook_Code;
$this->params['breadcrumbs'][] = ['label' => 'Thống kê đặt bàn', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bookingonlinelog-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'_id',
            'Foodbook_Code',
            [
                'attribute' => 'Pos_Id',
                //'format'=>'ra',
                'value' => $model->pos->POS_NAME
            ],
            //'Pos_Workstation',
            'User_Id',
            //'Book_Date',
            [
                'attribute' => 'Book_Date',
                //'format'=>'ra',
                'value' => $model->Hour.':'.$model->Minute.':00 '. date(Yii::$app->params['DATE_FORMAT'], $model->Book_Date->sec)
            ],
//            'Hour',
//            'Minute',
            'Number_People',

            [
                'attribute' => 'Status',
                //'format'=>'ra',
                'value' => Yii::t('yii',$model->Status)
            ],
            [
                'attribute' => 'Created_At',
                //'format'=>'ra',
                'value' => date($timeFormat, $model->Created_At->sec)
            ],
            [
                'attribute' => 'Updated_At',
                //'format'=>'ra',
                'value' => @$model->Updated_At->sec ? date($timeFormat, $model->Updated_At->sec) : null
            ],

            'Note',
            'Created_By',
        ],
    ]) ?>

</div>
