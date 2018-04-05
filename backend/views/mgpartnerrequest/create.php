<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Mgpartnerrequest */

$this->title = 'Create Mgpartnerrequest';
$this->params['breadcrumbs'][] = ['label' => 'Mgpartnerrequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mgpartnerrequest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
