<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmtagrelateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmtagrelates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmtagrelate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dmtagrelate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'TAG_ID',
            'POS_ID',
            'PIORITY',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update}'
            ],
        ],
    ]); ?>

</div>
