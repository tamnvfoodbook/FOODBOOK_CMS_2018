<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Thông tin tài khoản: '.$model->USERNAME;
$this->params['breadcrumbs'][] = ['label' => 'Tài khoản', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$typeAcc = \Yii::$app->session->get('type_acc');

?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        echo Html::a('Sửa thông tin', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']);
        echo Html::a('Đổi mật khẩu', ['changepassword', 'id' => $model->ID], ['class' => 'btn btn-danger btn_orderonlinelog_action']);
        echo '<br>';
        echo '<br>';

//            echo Html::a('Xóa', ['delete', 'id' => $model->ID], [
//                'class' => 'btn btn-danger',
//                'data' => [
//                    'confirm' => 'Bạn có chắc chắn muốn xóa tài khoản?',
//                    'method' => 'post',
//                ],
//            ]);
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'POS_PARENT',
            'USERNAME',
            'PHONE_NUMBER',
            //'full_name',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'EMAIL:email',
            [
                'attribute' => 'ACTIVE',
                'value' => $model->ACTIVE ? 'Active' : 'Deactive',
            ],
            [
                'attribute' => 'CREATED_AT',
                'value' => isset($model->CREATED_AT) ? date(Yii::$app->params['DATE_TIME_FORMAT_2'],strtotime($model->CREATED_AT)) : $model->CREATED_AT,
            ],
            [
                'attribute' => 'UPDATED_AT',
                'value' => isset($model->UPDATED_AT) ? date(Yii::$app->params['DATE_TIME_FORMAT_2'],strtotime($model->UPDATED_AT)) : $model->UPDATED_AT,
            ],
            [
                'attribute' => 'POS_ID_LIST',
                'value' => $model->TYPE == 2 ? "Toàn bộ hệ thống" : $model->POS_ID_LIST,
            ],
//            [
//                'attribute' => 'UPDATED_AT',
//                'value' => $model->TYPE == 2 ? "Quản lý hệ thống" : "Quản lý chi nhánh",
//            ],
        ],
    ]) ?>

</div>
