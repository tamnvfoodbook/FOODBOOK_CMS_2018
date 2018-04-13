<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dmpos */

$this->title = 'Update: ' . ' ' . $model->ITEM_NAME;
$this->params['breadcrumbs'][] = ['label' => 'Nhà hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ITEM_NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dmpos-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        if($model->IS_PARENT){
            echo $this->render('_form_parent_item', [
                'model' => $model,
                'modelItem' => $modelItem,
                'itemEatWith' => $itemEatWith,
                'timesaleBinArray' => $timesaleBinArray,
                'houraleBinArray' => $houraleBinArray,
                'itemTypeMasterMap' => $itemTypeMasterMap,
                'itemTypeMap' => $itemTypeMap,
                'itemMap' => $itemMap,
                'allPos' => $allPos,
                'POS_ID' => $POS_ID,
            ]);
        }else{
            echo $this->render('_form', [
                'model' => $model,
                'modelItem' => $modelItem,
                'itemEatWith' => $itemEatWith,
                'timesaleBinArray' => $timesaleBinArray,
                'houraleBinArray' => $houraleBinArray,
                'itemTypeMasterMap' => $itemTypeMasterMap,
                'itemTypeMap' => $itemTypeMap,
                'itemMap' => $itemMap,
                'allPos' => $allPos,
                'POS_ID' => $POS_ID,
            ]);
        }

     ?>

</div>
