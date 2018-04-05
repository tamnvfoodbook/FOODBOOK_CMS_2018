<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmuserpartner */

$this->title = $model->PARTNER_NAME;
$this->params['breadcrumbs'][] = ['label' => 'Dmuserpartners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmuserpartner-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->PARTNER_NAME], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->PARTNER_NAME], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'PARTNER_NAME',
            'AUTH_KEY',
            'ACCESS_TOKEN',
            'ACTIVE',
            'IS_SEND_SMS',
            'LIST_POS_PARENT',
            'BRAND_NAME',
            'SMS_PARTNER',
            'API_KEY',
            'SECRET_KEY',
            'RESPONSE_URL:url',
        ],
    ]) ?>

</div>
