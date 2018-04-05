<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmuserpartner */

$this->title = 'Tạo đối tác';
$this->params['breadcrumbs'][] = ['label' => 'Đối tác', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmuserpartner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'posParentMap' => $posParentMap,
    ]) ?>

</div>
