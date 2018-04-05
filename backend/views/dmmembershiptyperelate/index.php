<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmmembershiptyperelateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmmembershiptyperelates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmmembershiptyperelate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dmmembershiptyperelate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'MEMBERSHIP_ID',
            'POS_PARENT',
            'MEMBERSHIP_TYPE_ID',
            'CREATED_AT',
            // 'DOB',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
