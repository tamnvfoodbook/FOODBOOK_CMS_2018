<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmzalopageconfig */

$this->title = 'Cấu hình Zalo';
$this->params['breadcrumbs'][] = ['label' => 'Dmzalopageconfigs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmzalopageconfig-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
