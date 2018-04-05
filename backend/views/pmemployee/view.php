<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Pmemployee */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Nhân viên', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pmemployee-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Sửa thông tin', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Đặt lại mật khẩu', ['resetemploypassword', 'NAME' => $model->NAME,'EM_ID' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Bạn có chắc chắn muốn đặt lại mật khẩu ?',
                //'method' => 'post',
            ],
        ]) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'POS_PARENT',
            'NAME',
            'POS_ID',
            //'PASSWORD',
            'CREATED_AT',
            //'PERMISTION',
            [
                'attribute' => 'PERMISTION',
                'format' => 'raw',
                //'value' => 'idToNamePos',
            ],
        ],
    ]) ?>

</div>
