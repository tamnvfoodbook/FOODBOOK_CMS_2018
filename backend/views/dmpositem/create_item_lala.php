<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmpos */

if($model->isNewRecord){
    $this->title = 'Tạo món ăn';
}else{
    $this->title = 'Cập nhật món ăn';
}

$this->params['breadcrumbs'][] = ['label' => 'Món ăn', 'url' => ['view','id' => $POS_ID]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmpos-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form_item_lala', [
        'model' => $model,
        'itemTypeMap' => $itemTypeMap,
        'autoGenId' => $autoGenId,
        'allPos' => $allPos,
        'allPosMap' => $allPosMap,
        'POS_ID' => $POS_ID,
    ]) ?>

</div>
