<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmitemtype */

$this->title = 'Tạo loại món';
$this->params['breadcrumbs'][] = ['label' => 'Loại món', 'url' => ['itemtype','id'=>$POS_ID]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmitemtype-create">

    <?= $this->render('_form_creat_item_type', [
        'model' => $model,
        'autoGenId' => $autoGenId,
        'allPos' => $allPos,
        'allPosMap' => $allPosMap,
        'POS_ID' => $POS_ID
    ]) ?>
</div>
