<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmpartner */

$this->title = 'Tạo hoa hồng';
$this->params['breadcrumbs'][] = ['label' => 'Hoa hồng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmpartner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'partnerMap' => $partnerMap,
        'posparentMap' => $posparentMap,
        'allPosMap' => $allPosMap,
    ]) ?>

</div>
