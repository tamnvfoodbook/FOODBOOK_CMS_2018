<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmconfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmconfigs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmconfig-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dmconfig', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'KEYGROUP',
            'SORT',
            'KEYWORD',
            'VALUES',
            // 'DESC',
            // 'ACTIVE',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
