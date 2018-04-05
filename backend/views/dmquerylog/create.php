<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmquerylog */

$this->title = 'Create Dmquerylog';
$this->params['breadcrumbs'][] = ['label' => 'Dmquerylogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmquerylog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
