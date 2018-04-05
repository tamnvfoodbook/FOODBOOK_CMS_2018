<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmitemtype */

$this->title = 'Tạo nhóm món';
$this->params['breadcrumbs'][] = ['label' => 'Nhóm món', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmitemtype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
    ]) ?>

</div>
