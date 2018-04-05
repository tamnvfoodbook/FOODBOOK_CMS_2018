<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmitemcomboSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmitemcombos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmitemcombo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dmitemcombo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'POS_ID',
            'ITEM_ID',
            'COMBO_ITEM_ID_LIST',
            'QUANTITY',
            // 'TA_PRICE',
            // 'OTS_PRICE',
            // 'TA_DISCOUNT',
            // 'OTS_DISCOUNT',
            // 'SORT',
            // 'CREATED_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
