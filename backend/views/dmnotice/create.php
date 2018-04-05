<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmnotice */

$this->title = 'Tạo thông báo';
$this->params['breadcrumbs'][] = ['label' => 'Thông báo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmnotice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'lala_pos_parent' => $lala_pos_parent,
        'user_token' => $user_token,
        'allPosMap' => $allPosMap,
        'isNewRecord' => 1,
    ]) ?>

</div>
