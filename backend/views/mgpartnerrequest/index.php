<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MgpartnerrequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mgpartnerrequests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mgpartnerrequest-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Mgpartnerrequest', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            '_id',
            'partner_name',
            'request_at',
            'response_at',
            'request_data',
            // 'response_data',
            // 'has_exception',
            // 'tag',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
