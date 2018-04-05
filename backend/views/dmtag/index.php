<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmtagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmtags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmtag-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dmtag', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'NAME',
            'SCORE',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
