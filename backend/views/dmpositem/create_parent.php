<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmpos */

$this->title = 'Tạo món';
$this->params['breadcrumbs'][] = ['label' => 'Món ăn', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmpos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
