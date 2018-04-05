<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Wmslideimagelist */

$this->title = 'Tạo slide';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách slide', 'url' => ['index','id' => $model->POS_ID]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wmslideimagelist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
    ]) ?>

</div>
