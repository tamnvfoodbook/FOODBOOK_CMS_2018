<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SALEDETAILSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Saledetails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saledetail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Saledetail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            '_id',
            'Pos_Id',
            'Pos_Parent',
            'Fr_Key',
            'Amount',
            // 'Price_Sale',
            // 'Tran_Id',
            // 'Created_At',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
