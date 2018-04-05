<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MgitemchangedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mgitemchangeds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mgitemchanged-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Mgitemchanged', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            '_id',
            'pos_parent',
            'pos_id',
            'last_changed',
            'reversion',
            // 'changed',
            // 'last_broadcast',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
