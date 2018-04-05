<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberaddresslistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Memberaddresslists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberaddresslist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Memberaddresslist', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            '_id',
            'user_id',
            'alias_name',
            'extend_address',
            'full_address',
            // 'city_id',
            // 'district_id',
            // 'created_at',
            // 'longitude',
            // 'latitude',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
