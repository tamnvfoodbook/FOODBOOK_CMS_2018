<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmpartner */

$this->title = $model->pos_name;
$this->params['breadcrumbs'][] = ['label' => 'Hoa hồng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="dmpartner-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Sửa', ['update', 'id' => $model->_id], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            '_id',
            'partner_id',
            'partner_name',
            'pos_id',
            'pos_name',
            'pos_parent',
            'commission_rate',
            'created_at',
            'updated_at',
        ],
    ]) ?>
</div>
