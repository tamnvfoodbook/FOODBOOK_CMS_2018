<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposparent */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmposparent-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Sửa', ['posupdate'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'NAME',
            'MERCHANT_ID',
            [
                'attribute' => 'DESCRIPTION',
                'format' => 'raw'
            ],
            [
                'attribute' => 'IMAGE',
                'format' => 'image'
            ],
            'FACEBOOK_URL',
            'POS_FEATURE',
            'MANAGER_EMAIL_LIST',
            'MANAGER_PHONE',
        ],
    ]) ?>

</div>