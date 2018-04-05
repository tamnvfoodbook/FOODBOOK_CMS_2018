<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposmaster */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmposmasters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmposmaster-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'POS_MASTER_NAME',
            'DESCRIPTION',
            'IMAGE_PATH',
            'IS_COLLECTION',
            'ACTIVE',
            'FOR_BREAKFAST',
            'FOR_LUNCH',
            'FOR_DINNER',
            'FOR_MIDNIGHT',
            'SORT',
            'CITY_ID',
            'TIME_START',
            'DAY_ON',
        ],
    ]) ?>

</div>
