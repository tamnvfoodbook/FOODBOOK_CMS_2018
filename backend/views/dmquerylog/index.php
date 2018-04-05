<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DmquerylogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dmquerylogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmquerylog-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dmquerylog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'CREATED_AT',
            'ACTION_QUERY',
            'TABLE_NAME',
            'DATA_OLD:ntext',
            // 'DATA_NEW:ntext',
            // 'USER_MANAGER_ID',
            // 'USER_MANAGER_NAME',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
