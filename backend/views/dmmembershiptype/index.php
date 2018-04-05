<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmmembershiptypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmmembershiptypes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmmembershiptype-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dmmembershiptype', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'POS_PARENT',
            'MEMBERSHIP_TYPE_ID',
            'MEMBERSHIP_TYPE_NAME',
            'ACTIVE',
            // 'MEMBERSHIP_TYPE_IMAGE',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
