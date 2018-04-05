<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmmembership */

$this->title = $model->MEMBER_NAME;
$this->params['breadcrumbs'][] = ['label' => 'Báo cáo khách hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$sexArr = ['-1' =>  'Chưa xác định','0' => "Nữ", '1' => 'Nam'];
$timeFormat = Yii::$app->params['DATE_TIME_FORMAT'];

?>
<div class="dmmembership-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'MEMBER_NAME',
//            'MEMBER_IMAGE_PATH',
//            'ACTIVE',
//            'HASH_PASSWORD',
            'FACEBOOK_ID',
            'PHONE_NUMBER',
            'EMAIL:email',
//            'LAST_UPDATED',
//            'MY_STATUS',
            'BIRTHDAY',
            'CREATED_BY',

            [
                'attribute' => 'SEX',
                //'format'=>'ra',
                'value' => @$model->CREATED_AT ? date($timeFormat, strtotime($model->CREATED_AT)) : null
            ],
            [
                'attribute' => 'SEX',
                //'format'=>'ra',
                'value' => $sexArr[$model->SEX]
//                'value' => @$model->Updated_At->sec ? date($timeFormat, $model->Updated_At->sec) : null
            ],

        ],
    ]) ?>

</div>
