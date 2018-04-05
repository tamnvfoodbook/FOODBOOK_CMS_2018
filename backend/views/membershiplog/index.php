<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MembershiplogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Membershiplogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="membershiplog-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Membershiplog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            '_id',
            'className',
            'Pos_Id',
            'User_Id',
            'Pr_Key',
            // 'Membership_Log_Type',
            // 'Amount',
            // 'Point',
            // 'Membership_Log_Date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
