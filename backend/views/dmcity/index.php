<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmcitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmcities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmcity-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dmcity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'CITY_NAME',
            'SORT',
            'ACTIVE',
            'LONGITUDE',
            'LATITUDE',
            // 'GG_LOCALITY',
            // 'AM_LOCALITY',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update}'
            ],
        ],
    ]); ?>

</div>
