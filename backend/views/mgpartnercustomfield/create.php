<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Mgpartnercustomfield */

$this->title = 'Tạo Tags';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mgpartnercustomfield-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'partnerMap' => $partnerMap,
        'allPosMap' => $allPosMap,
    ]) ?>

</div>
