<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Thông tin tài khoản: '.$model->username;
$this->params['breadcrumbs'][] = ['label' => 'Tài khoản', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$typeAcc = \Yii::$app->session->get('type_acc');

?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        echo Html::a('Sửa thông tin', ['updatelala', 'id' => $model->id], ['class' => 'btn btn-primary']);
        echo Html::a('Đổi mật khẩu', ['changepasswordlala', 'id' => $model->id], ['class' => 'btn btn-danger btn_orderonlinelog_action']);
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
            'id',
            'pos_parent',
            'username',
            'phone_number',
            //'full_name',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            [
                'attribute' => 'active',
                'value' => $model->active ? 'Active' : 'Deactive',
            ],

            /*[
                'attribute' => 'CREATED_AT',
                'value' => isset($model->CREATED_AT) ? date(Yii::$app->params['DATE_TIME_FORMAT_2'],strtotime($model->CREATED_AT)) : $model->CREATED_AT,
            ],*/


            [
                'attribute' => 'updated_at',
                'value' => isset($model->updated_at) ? date(Yii::$app->params['DATE_TIME_FORMAT_2'],strtotime($model->updated_at)) : $model->updated_at,
            ],
            [
                'attribute' => 'pos_id_list',
                'value' => $model->type == 2 ? "Toàn bộ hệ thống" : @$model->pos_id_list,
            ],
//            [
//                'attribute' => 'UPDATED_AT',
//                'value' => $model->TYPE == 2 ? "Quản lý hệ thống" : "Quản lý chi nhánh",
//            ],
        ],
    ]) ?>

</div>
