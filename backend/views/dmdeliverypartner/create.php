<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmdeliverypartner */

$this->title = 'Create Dmdeliverypartner';
$this->params['breadcrumbs'][] = ['label' => 'Dmdeliverypartners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmdeliverypartner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
